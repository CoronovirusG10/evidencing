#!/bin/bash

# Horizon Banking App - Azure Deployment Script
# Resource Group: horizon-rg-uae

set -e

# Configuration
RESOURCE_GROUP="horizon-rg-uae"
LOCATION="UAE North"  # or your preferred Azure region
SUBSCRIPTION_ID="your-subscription-id"  # Update with your subscription ID

# App Service Names
LANDING_APP_NAME="horizonbank-landing"
BANKING_APP_NAME="horizonbank-app"
APP_SERVICE_PLAN="horizonbank-plan"

# Custom Domain (update with your actual domain)
CUSTOM_DOMAIN="horizonbank.ae"
BANKING_SUBDOMAIN="app.horizonbank.ae"

echo "🚀 Starting deployment to Azure Resource Group: $RESOURCE_GROUP"

# Check if Azure CLI is installed
if ! command -v az &> /dev/null; then
    echo "❌ Azure CLI is not installed. Please install it first."
    exit 1
fi

# Login and set subscription
echo "🔐 Logging into Azure..."
az login
az account set --subscription "$SUBSCRIPTION_ID"

echo "📋 Checking if resource group exists..."
if ! az group show --name "$RESOURCE_GROUP" &> /dev/null; then
    echo "📦 Creating resource group: $RESOURCE_GROUP"
    az group create --name "$RESOURCE_GROUP" --location "$LOCATION"
else
    echo "✅ Resource group already exists"
fi

echo "🏗️ Creating App Service Plan..."
if ! az appservice plan show --name "$APP_SERVICE_PLAN" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    az appservice plan create \
        --name "$APP_SERVICE_PLAN" \
        --resource-group "$RESOURCE_GROUP" \
        --location "$LOCATION" \
        --sku P1v2 \
        --is-linux
else
    echo "✅ App Service Plan already exists"
fi

echo "🌐 Creating Landing Site App Service..."
if ! az webapp show --name "$LANDING_APP_NAME" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    az webapp create \
        --name "$LANDING_APP_NAME" \
        --resource-group "$RESOURCE_GROUP" \
        --plan "$APP_SERVICE_PLAN" \
        --runtime "PHP|8.1"

    # Configure PHP settings
    az webapp config appsettings set \
        --name "$LANDING_APP_NAME" \
        --resource-group "$RESOURCE_GROUP" \
        --settings \
            PHP_VERSION="8.1" \
            WEBSITE_LOAD_USER_PROFILE="1" \
            WEBSITE_DYNAMIC_CACHE="0" \
            BANKING_APP_URL="https://$BANKING_SUBDOMAIN"
else
    echo "✅ Landing App Service already exists"
fi

echo "💻 Creating Banking App Service..."
if ! az webapp show --name "$BANKING_APP_NAME" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    az webapp create \
        --name "$BANKING_APP_NAME" \
        --resource-group "$RESOURCE_GROUP" \
        --plan "$APP_SERVICE_PLAN" \
        --runtime "NODE|18-lts"

    # Configure Node.js settings
    az webapp config appsettings set \
        --name "$BANKING_APP_NAME" \
        --resource-group "$RESOURCE_GROUP" \
        --settings \
            WEBSITE_NODE_DEFAULT_VERSION="18.17.0" \
            NEXT_PUBLIC_SITE_URL="https://$BANKING_SUBDOMAIN" \
            NODE_ENV="production"
else
    echo "✅ Banking App Service already exists"
fi

echo "🔒 Creating Key Vault for secrets..."
KEYVAULT_NAME="horizon-keyvault-$(date +%s)"
if ! az keyvault show --name "$KEYVAULT_NAME" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    az keyvault create \
        --name "$KEYVAULT_NAME" \
        --resource-group "$RESOURCE_GROUP" \
        --location "$LOCATION" \
        --enabled-for-template-deployment true
else
    echo "✅ Key Vault already exists"
fi

echo "📊 Setting up Application Insights..."
APPINSIGHTS_NAME="horizon-insights"
if ! az monitor app-insights component show --app "$APPINSIGHTS_NAME" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    az monitor app-insights component create \
        --app "$APPINSIGHTS_NAME" \
        --location "$LOCATION" \
        --resource-group "$RESOURCE_GROUP" \
        --application-type web
else
    echo "✅ Application Insights already exists"
fi

echo "📦 Building and deploying Landing Site..."
cd UI-UX
zip -r ../landing-site.zip . -x "*.git*" "node_modules/*" "*.DS_Store*"
cd ..

az webapp deploy \
    --resource-group "$RESOURCE_GROUP" \
    --name "$LANDING_APP_NAME" \
    --src-path landing-site.zip \
    --type zip

echo "🏗️ Building Next.js Banking App..."
npm ci
npm run build

echo "📦 Deploying Banking App..."
# Create deployment package excluding unnecessary files
zip -r banking-app.zip . \
    -x "*.git*" \
    -x "node_modules/*" \
    -x "UI-UX/*" \
    -x "*.DS_Store*" \
    -x "landing-site.zip" \
    -x "tests/*" \
    -x "docs/*"

az webapp deploy \
    --resource-group "$RESOURCE_GROUP" \
    --name "$BANKING_APP_NAME" \
    --src-path banking-app.zip \
    --type zip

echo "🌍 Setting up custom domains..."
# Note: You'll need to configure your DNS to point to Azure before running these commands
# az webapp config hostname add --webapp-name "$LANDING_APP_NAME" --resource-group "$RESOURCE_GROUP" --hostname "$CUSTOM_DOMAIN"
# az webapp config hostname add --webapp-name "$BANKING_APP_NAME" --resource-group "$RESOURCE_GROUP" --hostname "$BANKING_SUBDOMAIN"

echo "🔐 Enabling HTTPS..."
# az webapp config ssl bind --certificate-source AppServiceManaged --hostname "$CUSTOM_DOMAIN" --name "$LANDING_APP_NAME" --resource-group "$RESOURCE_GROUP"
# az webapp config ssl bind --certificate-source AppServiceManaged --hostname "$BANKING_SUBDOMAIN" --name "$BANKING_APP_NAME" --resource-group "$RESOURCE_GROUP"

echo "🧹 Cleaning up deployment files..."
rm -f landing-site.zip banking-app.zip

echo "✅ Deployment completed successfully!"
echo ""
echo "🌐 Your applications are now available at:"
echo "   Landing Site: https://$LANDING_APP_NAME.azurewebsites.net"
echo "   Banking App:  https://$BANKING_APP_NAME.azurewebsites.net"
echo ""
echo "📋 Next steps:"
echo "   1. Configure your DNS to point $CUSTOM_DOMAIN to the landing site"
echo "   2. Configure your DNS to point $BANKING_SUBDOMAIN to the banking app"
echo "   3. Set up SSL certificates for your custom domains"
echo "   4. Configure environment variables in Key Vault"
echo "   5. Test the banking portal integration"
echo ""
echo "🔍 Monitor your applications:"
echo "   Azure Portal: https://portal.azure.com"
echo "   Resource Group: $RESOURCE_GROUP"