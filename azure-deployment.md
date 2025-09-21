# Azure Deployment Guide: Horizon Banking App

## 🌐 Current Azure Setup: horizon-rg-uae

This guide covers deploying your professional banking landing page alongside your existing Next.js banking application in the **horizon-rg-uae** Azure Resource Group.

## 📋 Deployment Architecture

### **Resource Group: horizon-rg-uae**
```
├── 🌐 App Service Plan (Linux Premium)
│   ├── horizon-landing-uae     # PHP 8.1+ App Service (UI-UX folder)
│   └── horizon-banking-uae     # Node.js 20+ App Service (Next.js)
├── 🗄️ Azure Database for PostgreSQL
├── 🔒 Azure Key Vault
├── 📊 Application Insights
├── 🌍 Azure CDN Profile
└── 💾 Storage Account (Static Assets)
```

## 🚀 Landing Page Deployment Strategy

### **Option 1: Separate App Services (Recommended)**

Deploy the PHP landing site and Next.js app as separate Azure App Services:

#### **Landing Site Configuration:**
- **App Service Name**: `horizon-landing-uae`
- **Runtime**: PHP 8.1
- **Domain**: `horizonbank.ae` (root domain)
- **Source**: `/UI-UX` folder

#### **Banking App Configuration:**
- **App Service Name**: `horizon-banking-uae`
- **Runtime**: Node.js 20 LTS
- **Domain**: `app.horizonbank.ae` (subdomain)
- **Source**: Root directory (Next.js app)

## 📁 Azure App Service Configuration Files

### **1. Landing Site: web.config (PHP)**
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
                <rule name="Redirect to HTTPS" stopProcessing="true">
                    <match url=".*" />
                    <conditions>
                        <add input="{HTTPS}" pattern="off" ignoreCase="true" />
                    </conditions>
                    <action type="Redirect" url="https://{HTTP_HOST}/{R:0}"
                            redirectType="Permanent" />
                </rule>
                <rule name="Banking Portal Redirect" stopProcessing="true">
                    <match url="^portal/?$" />
                    <action type="Redirect" url="https://app.horizonbank.ae/"
                            redirectType="Permanent" />
                </rule>
            </rules>
        </rewrite>
        <staticContent>
            <mimeMap fileExtension=".woff" mimeType="application/font-woff" />
            <mimeMap fileExtension=".woff2" mimeType="application/font-woff2" />
        </staticContent>
    </system.webServer>
</configuration>
```

### **2. Banking App: next.config.mjs Update**
```javascript
/** @type {import('next').NextConfig} */
const nextConfig = {
  experimental: {
    serverComponentsExternalPackages: ["node-appwrite"],
  },
  // Azure App Service configuration
  output: 'standalone',
  distDir: '.next',

  async redirects() {
    return [
      {
        source: '/',
        destination: 'https://horizonbank.ae',
        permanent: false,
        has: [
          {
            type: 'header',
            key: 'referer',
            value: '(.*?)(?<!app\\.horizonbank\\.ae).*',
          },
        ],
      },
    ]
  },

  async headers() {
    return [
      {
        source: '/(.*)',
        headers: [
          {
            key: 'X-Frame-Options',
            value: 'SAMEORIGIN',
          },
          {
            key: 'X-Content-Type-Options',
            value: 'nosniff',
          },
        ],
      },
    ]
  },
}

export default nextConfig
```

## 🔧 Azure DevOps Pipeline Configuration

### **Landing Site Deployment (azure-pipelines-landing.yml)**
```yaml
trigger:
  branches:
    include:
    - main
  paths:
    include:
    - UI-UX/*

pool:
  vmImage: 'ubuntu-latest'

variables:
  azureSubscription: 'horizon-azure-connection'
  appName: 'horizon-landing-uae'
  resourceGroup: 'horizon-rg-uae'

stages:
- stage: Build
  jobs:
  - job: BuildLanding
    steps:
    - task: ArchiveFiles@2
      inputs:
        rootFolderOrFile: 'UI-UX'
        includeRootFolder: false
        archiveType: 'zip'
        archiveFile: '$(Build.ArtifactStagingDirectory)/landing.zip'

    - task: PublishBuildArtifacts@1
      inputs:
        pathToPublish: '$(Build.ArtifactStagingDirectory)'
        artifactName: 'landing'

- stage: Deploy
  dependsOn: Build
  jobs:
  - deployment: DeployLanding
    environment: 'production'
    strategy:
      runOnce:
        deploy:
          steps:
          - task: AzureWebApp@1
            inputs:
              azureSubscription: '$(azureSubscription)'
              appType: 'webApp'
              appName: '$(appName)'
              resourceGroupName: '$(resourceGroup)'
              package: '$(Pipeline.Workspace)/landing/landing.zip'
              runtimeStack: 'PHP|8.1'
```

### **Banking App Deployment (azure-pipelines-app.yml)**
```yaml
trigger:
  branches:
    include:
    - main
  paths:
    exclude:
    - UI-UX/*

pool:
  vmImage: 'ubuntu-latest'

variables:
  azureSubscription: 'horizon-azure-connection'
  appName: 'horizon-banking-uae'
  resourceGroup: 'horizon-rg-uae'

stages:
- stage: Build
  jobs:
  - job: BuildApp
    steps:
    - task: NodeTool@0
      inputs:
        versionSpec: '20.x'

    - script: |
        npm ci
        npm run build
      displayName: 'Build Next.js App'

    - task: ArchiveFiles@2
      inputs:
        rootFolderOrFile: '.'
        includeRootFolder: false
        archiveType: 'zip'
        archiveFile: '$(Build.ArtifactStagingDirectory)/app.zip'
        excludePaths: |
          node_modules
          .git
          UI-UX

    - task: PublishBuildArtifacts@1
      inputs:
        pathToPublish: '$(Build.ArtifactStagingDirectory)'
        artifactName: 'app'

- stage: Deploy
  dependsOn: Build
  jobs:
  - deployment: DeployApp
    environment: 'production'
    strategy:
      runOnce:
        deploy:
          steps:
          - task: AzureWebApp@1
            inputs:
              azureSubscription: '$(azureSubscription)'
              appType: 'webApp'
              appName: '$(appName)'
              resourceGroupName: '$(resourceGroup)'
              package: '$(Pipeline.Workspace)/app/app.zip'
              runtimeStack: 'NODE|20-lts'
```

## 🌍 Domain Configuration

### **Azure DNS Zone Setup**
```
horizonbank.ae                    A Record    → Landing App Service IP
app.horizonbank.ae                CNAME       → horizon-banking-uae.azurewebsites.net
www.horizonbank.ae                CNAME       → horizon-landing-uae.azurewebsites.net
```

### **SSL Certificates**
- Enable **Free Managed Certificates** for both app services
- Or use **Azure Key Vault** for custom certificates

## 🔐 Environment Variables

### **Landing Site App Settings**
```
PHP_VERSION=8.1
WEBSITE_LOAD_USER_PROFILE=1
WEBSITE_DYNAMIC_CACHE=0
BANKING_APP_URL=https://app.horizonbank.ae
```

### **Banking App Environment Variables**
```bash
# Next.js Configuration
NEXT_PUBLIC_SITE_URL=https://app.horizonbank.ae
WEBSITE_NODE_DEFAULT_VERSION=20-lts

# Appwrite Configuration
NEXT_PUBLIC_APPWRITE_ENDPOINT=https://cloud.appwrite.io/v1
NEXT_PUBLIC_APPWRITE_PROJECT=your-project-id
APPWRITE_DATABASE_ID=your-database-id
# ... other Appwrite settings

# Feature Flags
NEXT_PUBLIC_ENABLE_PLAID=true
NEXT_PUBLIC_ENABLE_TRANSFERS=true

# External APIs (store in Key Vault)
PLAID_CLIENT_ID=@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/plaid-client-id/)
PLAID_SECRET=@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/plaid-secret/)
DWOLLA_KEY=@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/dwolla-key/)
DWOLLA_SECRET=@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/dwolla-secret/)
```

## 📊 Monitoring & Analytics

### **Application Insights Configuration**
```javascript
// In next.config.mjs
const nextConfig = {
  // ... other config
  env: {
    APPINSIGHTS_INSTRUMENTATIONKEY: process.env.APPINSIGHTS_INSTRUMENTATIONKEY,
  },
}
```

### **Health Checks**
- **Landing Site**: `/health.php` endpoint
- **Banking App**: `/api/health` endpoint

## 🚀 Deployment Commands

### **Manual Deployment via Azure CLI**
```bash
# Login to Azure
az login

# Set subscription
az account set --subscription "your-subscription-id"

# Deploy Landing Site
az webapp deploy \
  --resource-group horizon-rg-uae \
  --name horizon-landing-uae \
  --src-path ./UI-UX \
  --type zip

# Deploy Banking App
scripts/create-azure-zip.sh
az webapp deploy \
  --resource-group horizon-rg-uae \
  --name horizon-banking-uae \
  --src-path horizon-internet-banking.zip \
  --type zip

echo "Archive nests Next.js build under /internet-banking to avoid clobbering root assets."
```

## 🔄 Integration Points

### **Banking Portal Redirect**
Update `/UI-UX/assets/js/banking-portal.js`:
```javascript
// Replace this line:
const bankingAppUrl = '../';

// With:
const bankingAppUrl = 'https://app.horizonbank.ae/sign-in';
```

### **Cross-Origin Configuration**
Ensure both services can communicate:
```javascript
// In banking app next.config.mjs
async headers() {
  return [
    {
      source: '/api/:path*',
      headers: [
        {
          key: 'Access-Control-Allow-Origin',
          value: 'https://horizonbank.ae',
        },
      ],
    },
  ]
}
```

## 📈 Performance Optimization

### **Azure CDN Integration**
- Serve static assets from Azure CDN
- Cache CSS, JS, images for faster loading
- Configure custom rules for banking security

### **Scaling Configuration**
- **Landing Site**: Auto-scale based on CPU/memory
- **Banking App**: Scale out for high availability
- **Database**: Configure read replicas if needed

## 🛡️ Security Best Practices

1. **Always use HTTPS** for both services
2. **Store secrets in Azure Key Vault**
3. **Enable Application Gateway** for advanced security
4. **Configure Web Application Firewall (WAF)**
5. **Regular security updates** for PHP and Node.js runtimes
6. **Monitor with Azure Security Center**

---

This configuration will give you a professional banking website with seamless integration between your marketing site and banking application, all hosted securely in Azure! 🚀
