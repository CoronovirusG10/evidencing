#!/bin/bash
# Deploy the Horizon banking portal to Azure App Service (UAE North)
set -euo pipefail

RESOURCE_GROUP="horizon-rg-uae"
LOCATION="uaenorth"
APP_SERVICE_PLAN="horizon-asp-uae"
WEBAPP_NAME="horizon-banking-uae"
KEY_VAULT_NAME="horizon-kv-uae"
ZIP_PATH="horizon-internet-banking.zip"
NODE_RUNTIME="NODE|20-lts"
STARTUP_FILE="./startup.sh"

banner() {
  echo "" && echo "=================================================="
  echo "$1"
  echo "=================================================="
  echo ""
}

require_binary() {
  if ! command -v "$1" >/dev/null 2>&1; then
    echo "Required binary '$1' not found in PATH" >&2
    exit 1
  fi
}

banner "Horizon Banking — Azure Deployment"

require_binary az

if ! az account show >/dev/null 2>&1; then
  echo "Azure CLI session not found. Launching 'az login'..."
  az login >/dev/null
fi

SUBSCRIPTION_ID="$(az account show --query id -o tsv)"
if [[ -z "$SUBSCRIPTION_ID" ]]; then
  echo "Unable to resolve active Azure subscription. Run 'az account set --subscription <id>'." >&2
  exit 1
fi

echo "Active subscription: $SUBSCRIPTION_ID"
echo "Resource group:      $RESOURCE_GROUP"
echo "App Service plan:    $APP_SERVICE_PLAN"
echo "Web App:             $WEBAPP_NAME"
echo "Key Vault:           $KEY_VAULT_NAME"
echo "Package:             $ZIP_PATH"
echo ""

if [ ! -f "$ZIP_PATH" ]; then
  echo "Deployment package '$ZIP_PATH' not found. Run scripts/create-azure-zip.sh first." >&2
  exit 1
fi

echo "Ensuring resource group exists..."
az group create --name "$RESOURCE_GROUP" --location "$LOCATION" >/dev/null

echo "Ensuring App Service plan ($APP_SERVICE_PLAN) exists..."
az appservice plan show --name "$APP_SERVICE_PLAN" --resource-group "$RESOURCE_GROUP" >/dev/null 2>&1 || \
  az appservice plan create \
    --name "$APP_SERVICE_PLAN" \
    --resource-group "$RESOURCE_GROUP" \
    --location "$LOCATION" \
    --sku P1v3 \
    --is-linux >/dev/null

echo "Ensuring Web App ($WEBAPP_NAME) exists..."
az webapp show --name "$WEBAPP_NAME" --resource-group "$RESOURCE_GROUP" >/dev/null 2>&1 || \
  az webapp create \
    --resource-group "$RESOURCE_GROUP" \
    --plan "$APP_SERVICE_PLAN" \
    --name "$WEBAPP_NAME" \
    --runtime "$NODE_RUNTIME" >/dev/null

echo "Configuring runtime and startup command..."
az webapp config set \
  --resource-group "$RESOURCE_GROUP" \
  --name "$WEBAPP_NAME" \
  --linux-fx-version "$NODE_RUNTIME" \
  --startup-file "$STARTUP_FILE" >/dev/null

echo "Applying core app settings..."
az webapp config appsettings set \
  --resource-group "$RESOURCE_GROUP" \
  --name "$WEBAPP_NAME" \
  --settings \
    SCM_DO_BUILD_DURING_DEPLOYMENT="false" \
    WEBSITE_RUN_FROM_PACKAGE="0" \
    WEBSITE_NODE_DEFAULT_VERSION="20-lts" >/dev/null

echo "Assigning system identity and granting Key Vault access (Key Vault Secrets User)..."
PRINCIPAL_ID="$(az webapp identity assign --resource-group "$RESOURCE_GROUP" --name "$WEBAPP_NAME" --query principalId -o tsv)"
if [[ -n "$PRINCIPAL_ID" ]]; then
  SCOPE="/subscriptions/$SUBSCRIPTION_ID/resourceGroups/$RESOURCE_GROUP/providers/Microsoft.KeyVault/vaults/$KEY_VAULT_NAME"
  az role assignment create \
    --assignee "$PRINCIPAL_ID" \
    --role "Key Vault Secrets User" \
    --scope "$SCOPE" >/dev/null || true
else
  echo "Warning: could not resolve Web App managed identity principalId." >&2
fi

echo "Deploying ZIP package..."
az webapp deploy \
  --resource-group "$RESOURCE_GROUP" \
  --name "$WEBAPP_NAME" \
  --src-path "$ZIP_PATH" \
  --type zip >/dev/null

echo "Validating Key Vault-backed app settings..."
az webapp config appsettings list \
  --resource-group "$RESOURCE_GROUP" \
  --name "$WEBAPP_NAME" \
  --query "[?contains(@.value,'@Microsoft.KeyVault')].[name,value]" -o table

echo "Deployment complete. Validate at https://$WEBAPP_NAME.azurewebsites.net/internet-banking/"
