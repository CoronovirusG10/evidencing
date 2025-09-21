# Banking App Integration Guide

## 🎯 Target Architecture

### **Production Structure:**
```
https://horizonbank.ae/                    → PHP Landing Site (UI-UX folder)
https://horizonbank.ae/internet-banking/   → Next.js Banking App (main app)
https://horizonbank.ae/api/               → API endpoints (if needed)
```

### **Local Development Structure:**
```
/banking/
├── UI-UX/                     → Landing site (PHP)
├── app/                       → Next.js banking app
├── components/                → React components
├── lib/                       → Utilities
└── public/                    → Static assets
```

## 🔧 Configuration Updates

### **1. Next.js App Configuration (`next.config.mjs`)**
```javascript
/** @type {import('next').NextConfig} */
const nextConfig = {
  experimental: {
    serverComponentsExternalPackages: ["node-appwrite"],
  },

  // Configure for hosting in /internet-banking/ subdirectory
  basePath: '/internet-banking',
  assetPrefix: '/internet-banking',

  // Ensure standalone output for Azure
  output: 'standalone',
  distDir: '.next',

  async redirects() {
    return [
      {
        source: '/internet-banking',
        destination: '/internet-banking/sign-in',
        permanent: false,
      },
      // Redirect root banking access to sign-in
      {
        source: '/',
        destination: '/internet-banking/sign-in',
        permanent: false,
        has: [
          {
            type: 'header',
            key: 'referer',
            value: '.*internet-banking.*',
          },
        ],
      },
    ]
  },

  async headers() {
    return [
      {
        source: '/internet-banking/(.*)',
        headers: [
          {
            key: 'X-Frame-Options',
            value: 'SAMEORIGIN',
          },
          {
            key: 'X-Content-Type-Options',
            value: 'nosniff',
          },
          {
            key: 'Cache-Control',
            value: 'public, max-age=31536000, immutable',
          },
        ],
      },
    ]
  },
}

export default nextConfig
```

### **2. Update Banking Portal JavaScript**
Update `/UI-UX/assets/js/banking-portal.js`:
```javascript
// Redirect to internet banking section
setTimeout(() => {
    // Production: Internet banking section
    const bankingAppUrl = '/internet-banking/sign-in';

    // For local development
    const isDevelopment = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
    const finalUrl = isDevelopment ? 'http://localhost:3000/sign-in' : bankingAppUrl;

    showAlert('Redirecting to secure banking portal...', 'success');

    setTimeout(() => {
        window.location.href = finalUrl;
    }, 1500);
}, 2000);
```

### **3. Azure App Service Configuration**

#### **Single App Service Approach (Recommended)**
Deploy everything as one App Service with proper routing:

**web.config for Azure App Service:**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <defaultDocument>
            <files>
                <clear />
                <add value="index.php" />
            </files>
        </defaultDocument>

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

                <!-- Route Internet Banking to Next.js -->
                <rule name="Internet Banking Route" stopProcessing="true">
                    <match url="^internet-banking(.*)$" />
                    <action type="Rewrite" url="/internet-banking/server.js" />
                </rule>

                <!-- API Routes -->
                <rule name="API Routes" stopProcessing="true">
                    <match url="^api/(.*)$" />
                    <action type="Rewrite" url="/internet-banking/server.js" />
                </rule>

                <!-- Static Assets for Banking App -->
                <rule name="Banking Static Assets" stopProcessing="true">
                    <match url="^_next/(.*)$" />
                    <action type="Rewrite" url="/internet-banking/_next/{R:1}" />
                </rule>

                <!-- PHP Landing Site (default) -->
                <rule name="PHP Landing" stopProcessing="false">
                    <match url="^(.*)\.php$" />
                    <action type="None" />
                </rule>
            </rules>
        </rewrite>

        <!-- Static Content Types -->
        <staticContent>
            <mimeMap fileExtension=".woff" mimeType="application/font-woff" />
            <mimeMap fileExtension=".woff2" mimeType="application/font-woff2" />
            <mimeMap fileExtension=".json" mimeType="application/json" />
        </staticContent>

        <!-- Security Headers -->
        <httpProtocol>
            <customHeaders>
                <add name="X-Frame-Options" value="SAMEORIGIN" />
                <add name="X-Content-Type-Options" value="nosniff" />
                <add name="X-XSS-Protection" value="1; mode=block" />
            </customHeaders>
        </httpProtocol>
    </system.webServer>
</configuration>
```

## 📁 Deployment Structure

### **Azure App Service File Structure:**
```
/home/site/wwwroot/
├── index.php                          # Landing homepage
├── pages/                             # About, Contact pages
├── assets/                            # CSS, JS, Images
├── includes/                          # PHP includes
├── forms/                            # Contact forms
├── config/                           # Site configuration
├── internet-banking/                 # Next.js app folder
│   ├── server.js                     # Next.js server
│   ├── .next/                        # Built Next.js app
│   ├── public/                       # Static assets
│   └── package.json
├── web.config                        # IIS configuration
└── README.md
```

## 🚀 Deployment Script Update

### **Updated Azure Deployment (`deploy-to-azure.sh`):**
```bash
#!/bin/bash

echo "🏗️ Building Next.js Banking App..."
npm ci
npm run build

echo "📦 Creating deployment package..."
# Create the internet-banking directory structure
mkdir -p deployment/internet-banking

# Copy Next.js build to internet-banking folder
cp -r .next deployment/internet-banking/
cp -r public deployment/internet-banking/
cp package.json deployment/internet-banking/
cp next.config.mjs deployment/internet-banking/

# Copy PHP landing site to root
cp -r UI-UX/* deployment/

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
        <rewrite>
            <rules>
                <rule name="Internet Banking Route" stopProcessing="true">
                    <match url="^internet-banking(.*)$" />
                    <action type="Rewrite" url="/internet-banking/server.js" />
                </rule>
            </rules>
        </rewrite>
    </system.webServer>
</configuration>
EOF

# Deploy to Azure
scripts/create-azure-zip.sh

az webapp deploy \
    --resource-group horizon-rg-uae \
    --name horizon-banking-uae \
    --src-path horizon-internet-banking.zip \
    --type zip

echo "🧹 Cleaning up..."
rm -f horizon-internet-banking.zip

echo "✅ Deployment completed!"
echo "🌐 Landing Site: https://horizonbank.ae"
echo "🏦 Internet Banking: https://horizon-banking-uae.azurewebsites.net/internet-banking/"
```

## 🔗 Navigation Updates

### **Update Landing Site Navigation**
In `/UI-UX/includes/header.php`, update the Online Banking link:
```php
<a href="/internet-banking" class="btn-online-banking">
    <i class="fas fa-lock"></i> Internet Banking
</a>
```

### **Update Quick Links**
In `/UI-UX/index.php`, update the banking portal link:
```php
<a href="/internet-banking" class="quick-link-item">
    <i class="fas fa-laptop"></i>
    <span>Internet Banking</span>
</a>
```

## 🔧 Environment Variables

### **App Service Application Settings:**
```bash
# PHP Settings
PHP_VERSION=8.1
WEBSITE_LOAD_USER_PROFILE=1

# Node.js Settings for Internet Banking
WEBSITE_NODE_DEFAULT_VERSION=20-lts
NEXT_PUBLIC_SITE_URL=https://horizon-banking-uae.azurewebsites.net/internet-banking/

# Banking App Configuration
NEXT_PUBLIC_APPWRITE_ENDPOINT=https://cloud.appwrite.io/v1
NEXT_PUBLIC_ENABLE_PLAID=true
NEXT_PUBLIC_ENABLE_TRANSFERS=true

# Secrets (store in Key Vault)
APPWRITE_DATABASE_ID=@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/appwrite-db/)
PLAID_CLIENT_ID=@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/plaid-client/)
```

## 🧪 Local Development

### **Development Server Setup:**
```bash
# Terminal 1: Run PHP development server for landing site
cd UI-UX
php -S localhost:8000

# Terminal 2: Run Next.js for banking app
npm run dev
# This will run on localhost:3000

# Access:
# Landing Site: http://localhost:8000
# Banking App: http://localhost:3000
```

### **Development Integration:**
Update the JavaScript for local development:
```javascript
const isDevelopment = window.location.port === '8000';
const bankingUrl = isDevelopment ? 'http://localhost:3000/sign-in' : '/internet-banking/sign-in';
```

## ✅ Testing Checklist

### **Before Deployment:**
- [ ] Landing site loads correctly at root `/`
- [ ] Banking portal redirects to `/internet-banking`
- [ ] All navigation links work properly
- [ ] CSS and JS assets load correctly
- [ ] Forms submit without errors
- [ ] Mobile responsive design works

### **After Deployment:**
- [ ] HTTPS enforced on all pages
- [ ] Landing site accessible at `https://horizonbank.ae`
- [ ] Banking app accessible at `https://horizonbank.ae/internet-banking`
- [ ] Banking portal login redirects properly
- [ ] All static assets serve correctly
- [ ] Database connections work
- [ ] Monitoring and logging active

This structure ensures your professional landing site serves as the main website while your Next.js banking application is properly hosted in the `/internet-banking/` section! 🚀
