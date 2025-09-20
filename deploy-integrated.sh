#!/bin/bash

# Horizon Banking - Integrated Deployment Script
# Deploys PHP landing site + Next.js banking app to single Azure App Service
# Structure: Landing site at root, Banking app at /internet-banking/

set -e

echo "🚀 Horizon Banking - Integrated Azure Deployment"
echo "================================================="

# Configuration
RESOURCE_GROUP="horizon-rg-uae"
APP_NAME="horizonbank"
SUBSCRIPTION_ID="your-subscription-id"  # Update with your actual subscription

echo "🔧 Configuration:"
echo "   Resource Group: $RESOURCE_GROUP"
echo "   App Service: $APP_NAME"
echo "   Subscription: $SUBSCRIPTION_ID"
echo ""

# Check prerequisites
echo "🔍 Checking prerequisites..."
if ! command -v az &> /dev/null; then
    echo "❌ Azure CLI not found. Please install Azure CLI first."
    exit 1
fi

if ! command -v npm &> /dev/null; then
    echo "❌ npm not found. Please install Node.js and npm first."
    exit 1
fi

if ! command -v php &> /dev/null; then
    echo "❌ PHP not found. Please install PHP first."
    exit 1
fi

echo "✅ All prerequisites met"

# Login and set subscription
echo "🔐 Authenticating with Azure..."
az login --output none
az account set --subscription "$SUBSCRIPTION_ID"

echo "🏗️ Building Next.js Banking Application..."
npm ci --silent
npm run build

echo "📦 Creating integrated deployment package..."

# Create deployment directory
rm -rf deployment
mkdir -p deployment

echo "   📄 Copying PHP landing site to root..."
# Copy PHP landing site to deployment root
cp -r UI-UX/* deployment/

echo "   🏦 Setting up internet banking directory..."
# Create internet-banking directory
mkdir -p deployment/internet-banking

# Copy Next.js standalone build
if [ -d ".next/standalone" ]; then
    cp -r .next/standalone/* deployment/internet-banking/
else
    echo "❌ Next.js standalone build not found. Make sure output: 'standalone' is in next.config.mjs"
    exit 1
fi

# Copy Next.js static files
cp -r .next/static deployment/internet-banking/.next/static
cp -r public deployment/internet-banking/public

echo "   ⚙️ Creating web.config for Azure App Service..."
# Create web.config for proper routing
cat > deployment/web.config << 'EOF'
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <defaultDocument>
            <files>
                <clear />
                <add value="index.php" />
            </files>
        </defaultDocument>

        <handlers>
            <!-- PHP Handler -->
            <add name="PHP" path="*.php" verb="*" modules="FastCgiModule" scriptProcessor="C:\Program Files\PHP\v8.1\php-cgi.exe" resourceType="File" />

            <!-- Node.js Handler for Internet Banking -->
            <add name="InternetBanking" path="/internet-banking/*" verb="*" modules="iisnode" scriptProcessor="C:\Program Files\nodejs\node.exe" resourceType="File" />
        </handlers>

        <rewrite>
            <rules>
                <!-- Force HTTPS -->
                <rule name="Force HTTPS" stopProcessing="true">
                    <match url=".*" />
                    <conditions>
                        <add input="{HTTPS}" pattern="off" ignoreCase="true" />
                    </conditions>
                    <action type="Redirect" url="https://{HTTP_HOST}/{R:0}" redirectType="Permanent" />
                </rule>

                <!-- Internet Banking App Routes -->
                <rule name="Internet Banking API" stopProcessing="true">
                    <match url="^internet-banking/api/(.*)$" />
                    <action type="Rewrite" url="/internet-banking/server.js" />
                </rule>

                <rule name="Internet Banking Static" stopProcessing="true">
                    <match url="^internet-banking/_next/(.*)$" />
                    <action type="Rewrite" url="/internet-banking/.next/{R:1}" />
                </rule>

                <rule name="Internet Banking Pages" stopProcessing="true">
                    <match url="^internet-banking/(.*)$" />
                    <action type="Rewrite" url="/internet-banking/server.js" />
                </rule>

                <!-- PHP Routes (Landing Site) -->
                <rule name="PHP Pages" stopProcessing="false">
                    <match url="^(.*)\.php$" />
                    <action type="None" />
                </rule>

                <!-- Static Assets -->
                <rule name="Static Assets" stopProcessing="true">
                    <match url="^(assets|images|css|js)/(.*)$" />
                    <action type="None" />
                </rule>
            </rules>
        </rewrite>

        <!-- Static Content -->
        <staticContent>
            <mimeMap fileExtension=".woff" mimeType="application/font-woff" />
            <mimeMap fileExtension=".woff2" mimeType="application/font-woff2" />
            <mimeMap fileExtension=".json" mimeType="application/json" />
            <mimeMap fileExtension=".js" mimeType="application/javascript" />
        </staticContent>

        <!-- Security Headers -->
        <httpProtocol>
            <customHeaders>
                <add name="X-Frame-Options" value="SAMEORIGIN" />
                <add name="X-Content-Type-Options" value="nosniff" />
                <add name="X-XSS-Protection" value="1; mode=block" />
                <add name="Strict-Transport-Security" value="max-age=31536000; includeSubDomains" />
            </customHeaders>
        </httpProtocol>

        <!-- Error Pages -->
        <httpErrors errorMode="Custom">
            <remove statusCode="404" subStatusCode="-1" />
            <error statusCode="404" path="/404.php" responseMode="ExecuteURL" />
        </httpErrors>
    </system.webServer>
</configuration>
EOF

echo "   📋 Creating package.json for internet banking..."
# Create package.json for internet banking
cat > deployment/internet-banking/package.json << 'EOF'
{
  "name": "horizon-internet-banking",
  "version": "1.0.0",
  "private": true,
  "scripts": {
    "start": "node server.js"
  },
  "dependencies": {
    "next": "^14.2.32"
  }
}
EOF

echo "   🔧 Creating startup script..."
# Create startup script for Azure
cat > deployment/startup.sh << 'EOF'
#!/bin/bash

# Start PHP-FPM for landing site
service php8.1-fpm start

# Start Node.js for internet banking
cd /home/site/wwwroot/internet-banking
npm start &

# Keep container running
tail -f /dev/null
EOF

chmod +x deployment/startup.sh

echo "   📁 Final deployment structure:"
echo "      /"
echo "      ├── index.php                 (Landing homepage)"
echo "      ├── pages/                    (About, Contact)"
echo "      ├── assets/                   (CSS, JS, Images)"
echo "      ├── internet-banking/         (Next.js App)"
echo "      │   ├── server.js            (Next.js server)"
echo "      │   ├── .next/               (Built app)"
echo "      │   └── public/              (Static files)"
echo "      ├── web.config               (IIS routing)"
echo "      └── startup.sh               (Startup script)"

echo "📦 Creating deployment ZIP..."
cd deployment
zip -r ../horizon-banking-integrated.zip . -q
cd ..

echo "🚀 Deploying to Azure App Service..."
az webapp deploy \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --src-path horizon-banking-integrated.zip \
    --type zip

echo "⚙️ Configuring App Service settings..."
# Set application settings
az webapp config appsettings set \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --settings \
        PHP_VERSION="8.1" \
        WEBSITE_NODE_DEFAULT_VERSION="18.17.0" \
        WEBSITE_LOAD_USER_PROFILE="1" \
        NEXT_PUBLIC_SITE_URL="https://$APP_NAME.azurewebsites.net/internet-banking" \
        NODE_ENV="production" \
        PORT="8080"

echo "🔒 Enabling HTTPS Only..."
az webapp update \
    --resource-group "$RESOURCE_GROUP" \
    --name "$APP_NAME" \
    --https-only true

echo "🧹 Cleaning up..."
rm -rf deployment horizon-banking-integrated.zip

echo ""
echo "✅ Deployment completed successfully!"
echo "================================================="
echo ""
echo "🌐 Your integrated banking website is now live:"
echo "   🏠 Landing Site: https://$APP_NAME.azurewebsites.net"
echo "   🏦 Internet Banking: https://$APP_NAME.azurewebsites.net/internet-banking"
echo ""
echo "📋 Next steps:"
echo "   1. Test the landing site and banking portal integration"
echo "   2. Configure custom domain if needed"
echo "   3. Set up SSL certificate for custom domain"
echo "   4. Configure environment variables in App Service"
echo "   5. Set up monitoring and alerts"
echo ""
echo "🔍 Monitor your deployment:"
echo "   Azure Portal: https://portal.azure.com"
echo "   App Service: $APP_NAME"
echo "   Resource Group: $RESOURCE_GROUP"
echo ""
echo "🎉 Happy banking! Your professional website is ready."