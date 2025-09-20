#!/bin/bash

# Horizon Banking - Quick Azure Deployment Script
# This script deploys the integrated banking website to Azure

set -e

echo "=================================================="
echo "🚀 Horizon Banking - Azure Deployment"
echo "=================================================="
echo ""

# Configuration - Update these values
RESOURCE_GROUP="horizon-rg-uae"
APP_NAME="horizonbank"  # Change this to your preferred app name
LOCATION="UAE North"    # or "UAE Central", "East US", etc.

echo "📋 Deployment Configuration:"
echo "   Resource Group: $RESOURCE_GROUP"
echo "   App Service Name: $APP_NAME"
echo "   Location: $LOCATION"
echo "   Package: horizon-banking-integrated.zip (6.1MB)"
echo ""

# Check if Azure CLI is installed
if ! command -v az &> /dev/null; then
    echo "❌ Azure CLI is not installed."
    echo "   Please install it from: https://docs.microsoft.com/en-us/cli/azure/install-azure-cli"
    exit 1
fi

# Check if deployment package exists
if [ ! -f "horizon-banking-integrated.zip" ]; then
    echo "❌ Deployment package not found!"
    echo "   Run: npm run build && ./create-deployment-package.sh"
    exit 1
fi

echo "🔐 Please login to Azure..."
az login --output none

echo ""
echo "📋 Available subscriptions:"
az account list --query "[].{Name:name, ID:id, Default:isDefault}" -o table

echo ""
read -p "Enter your subscription ID (or press Enter to use default): " SUBSCRIPTION_ID

if [ ! -z "$SUBSCRIPTION_ID" ]; then
    echo "Setting subscription to: $SUBSCRIPTION_ID"
    az account set --subscription "$SUBSCRIPTION_ID"
fi

echo ""
echo "🔍 Checking resource group..."
if ! az group show --name "$RESOURCE_GROUP" &> /dev/null; then
    echo "📦 Creating resource group: $RESOURCE_GROUP"
    az group create --name "$RESOURCE_GROUP" --location "$LOCATION"
else
    echo "✅ Resource group exists: $RESOURCE_GROUP"
fi

echo ""
echo "🏗️ Checking App Service Plan..."
APP_SERVICE_PLAN="${APP_NAME}-plan"
if ! az appservice plan show --name "$APP_SERVICE_PLAN" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    echo "Creating App Service Plan: $APP_SERVICE_PLAN"
    az appservice plan create \
        --name "$APP_SERVICE_PLAN" \
        --resource-group "$RESOURCE_GROUP" \
        --location "$LOCATION" \
        --sku P1V2 \
        --is-linux
else
    echo "✅ App Service Plan exists: $APP_SERVICE_PLAN"
fi

echo ""
echo "🌐 Checking App Service..."
if ! az webapp show --name "$APP_NAME" --resource-group "$RESOURCE_GROUP" &> /dev/null; then
    echo "Creating App Service: $APP_NAME"

    # Create with PHP runtime initially for the landing site
    az webapp create \
        --name "$APP_NAME" \
        --resource-group "$RESOURCE_GROUP" \
        --plan "$APP_SERVICE_PLAN" \
        --runtime "PHP|8.2"
else
    echo "✅ App Service exists: $APP_NAME"
fi

echo ""
echo "⚙️ Configuring App Service settings..."
az webapp config appsettings set \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --settings \
        WEBSITE_NODE_DEFAULT_VERSION="18.17.0" \
        PHP_VERSION="8.2" \
        SCM_DO_BUILD_DURING_DEPLOYMENT="false" \
        WEBSITE_HTTPLOGGING_RETENTION_DAYS="7" \
        NEXT_PUBLIC_SITE_URL="https://${APP_NAME}.azurewebsites.net/internet-banking" \
        NODE_ENV="production" \
    --output none

echo "✅ App settings configured"

echo ""
echo "🚀 Deploying application package..."
echo "   This may take 2-3 minutes..."

# Deploy the ZIP package
az webapp deploy \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --src-path "horizon-banking-integrated.zip" \
    --type zip \
    --timeout 600

echo ""
echo "🔒 Enabling HTTPS only..."
az webapp update \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --https-only true \
    --output none

echo ""
echo "🔄 Restarting app service..."
az webapp restart \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --output none

echo ""
echo "=================================================="
echo "✅ DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "=================================================="
echo ""
echo "🌐 Your banking website is now live at:"
echo ""
echo "   🏠 Landing Page:"
echo "      https://${APP_NAME}.azurewebsites.net/"
echo ""
echo "   🏦 Internet Banking Portal:"
echo "      https://${APP_NAME}.azurewebsites.net/internet-banking/"
echo ""
echo "   ℹ️ About Page:"
echo "      https://${APP_NAME}.azurewebsites.net/pages/about/"
echo ""
echo "   📞 Contact Page:"
echo "      https://${APP_NAME}.azurewebsites.net/pages/contact.php"
echo ""
echo "=================================================="
echo ""
echo "📋 Next Steps:"
echo ""
echo "1. Visit your website and test all pages"
echo "2. Click 'Internet Banking' to test the portal redirect"
echo "3. Configure environment variables for your banking app:"
echo "   - Go to Azure Portal > App Service > Configuration"
echo "   - Add your Appwrite, Plaid, and Dwolla credentials"
echo ""
echo "4. Optional: Set up custom domain"
echo "   - Go to Azure Portal > App Service > Custom domains"
echo "   - Add your domain (e.g., horizonbank.ae)"
echo ""
echo "5. Monitor your application:"
echo "   - Azure Portal: https://portal.azure.com"
echo "   - Resource Group: $RESOURCE_GROUP"
echo "   - App Service: $APP_NAME"
echo ""
echo "🎉 Congratulations! Your professional banking website is live!"
echo ""

# Open the website in default browser
echo "Opening your website in browser..."
if [[ "$OSTYPE" == "darwin"* ]]; then
    open "https://${APP_NAME}.azurewebsites.net/"
elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
    xdg-open "https://${APP_NAME}.azurewebsites.net/"
elif [[ "$OSTYPE" == "msys" ]] || [[ "$OSTYPE" == "cygwin" ]]; then
    start "https://${APP_NAME}.azurewebsites.net/"
fi