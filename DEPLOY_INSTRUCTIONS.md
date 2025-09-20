# 🚀 DEPLOYMENT INSTRUCTIONS - Horizon Banking

## ✅ **READY TO DEPLOY**

Your integrated banking website is packaged and ready for Azure deployment!

## 📦 **Package Details**
- **File**: `horizon-banking-integrated.zip` (6.1MB)
- **Contains**: PHP landing site + Next.js banking app
- **Structure**: Landing at root, banking at `/internet-banking/`

## 🎯 **Quick Deployment (Recommended)**

### **Option 1: Automated Script**
```bash
./deploy-now.sh
```

This script will:
1. Login to Azure
2. Create/update resources in horizon-rg-uae
3. Deploy the integrated package
4. Configure all settings
5. Open your website in browser

### **Option 2: Manual Azure CLI**
```bash
# 1. Login to Azure
az login

# 2. Set subscription (replace with your ID)
az account set --subscription "your-subscription-id"

# 3. Create resource group (if needed)
az group create --name horizon-rg-uae --location "UAE North"

# 4. Create App Service Plan
az appservice plan create \
    --name horizonbank-plan \
    --resource-group horizon-rg-uae \
    --location "UAE North" \
    --sku P1V2 \
    --is-linux

# 5. Create Web App
az webapp create \
    --name horizonbank \
    --resource-group horizon-rg-uae \
    --plan horizonbank-plan \
    --runtime "PHP|8.2"

# 6. Configure settings
az webapp config appsettings set \
    --resource-group horizon-rg-uae \
    --name horizonbank \
    --settings \
        WEBSITE_NODE_DEFAULT_VERSION="18.17.0" \
        PHP_VERSION="8.2" \
        NODE_ENV="production"

# 7. Deploy the package
az webapp deploy \
    --resource-group horizon-rg-uae \
    --name horizonbank \
    --src-path horizon-banking-integrated.zip \
    --type zip

# 8. Enable HTTPS
az webapp update \
    --resource-group horizon-rg-uae \
    --name horizonbank \
    --https-only true
```

## 🌐 **After Deployment - URLs**

Your website will be accessible at:
```
🏠 Homepage:           https://horizonbank.azurewebsites.net/
🏦 Internet Banking:   https://horizonbank.azurewebsites.net/internet-banking/
ℹ️ About:              https://horizonbank.azurewebsites.net/pages/about/
📞 Contact:            https://horizonbank.azurewebsites.net/pages/contact.php
```

## ⚙️ **Required Environment Variables**

After deployment, add these in Azure Portal > App Service > Configuration:

### **Banking App Credentials**
```bash
# Appwrite
NEXT_PUBLIC_APPWRITE_ENDPOINT=https://cloud.appwrite.io/v1
NEXT_PUBLIC_APPWRITE_PROJECT=your-project-id
APPWRITE_DATABASE_ID=your-database-id
APPWRITE_USER_COLLECTION_ID=your-collection-id
APPWRITE_BANK_COLLECTION_ID=your-collection-id
APPWRITE_TRANSACTION_COLLECTION_ID=your-collection-id
NEXT_APPWRITE_KEY=your-api-key

# Plaid (for bank connections)
PLAID_CLIENT_ID=your-plaid-client-id
PLAID_SECRET=your-plaid-secret
PLAID_ENV=sandbox  # or development/production
PLAID_PRODUCTS=transactions
PLAID_COUNTRY_CODES=US

# Dwolla (for transfers)
DWOLLA_KEY=your-dwolla-key
DWOLLA_SECRET=your-dwolla-secret
DWOLLA_BASE_URL=https://api-sandbox.dwolla.com
DWOLLA_ENV=sandbox  # or production

# Feature Flags
NEXT_PUBLIC_ENABLE_PLAID=true
NEXT_PUBLIC_ENABLE_TRANSFERS=true
```

## 🧪 **Testing After Deployment**

### **1. Test Landing Site**
- [ ] Visit homepage: `https://horizonbank.azurewebsites.net/`
- [ ] Check responsive design on mobile
- [ ] Verify all CSS/JS loads properly
- [ ] Test navigation menu

### **2. Test Banking Portal**
- [ ] Click "Internet Banking" button
- [ ] Should redirect to `/internet-banking/sign-in`
- [ ] Test login form (if credentials configured)
- [ ] Verify Personal/Business tabs work

### **3. Test Other Pages**
- [ ] About page loads correctly
- [ ] Contact form displays properly
- [ ] FAQ accordion works
- [ ] All links function correctly

## 🔧 **Troubleshooting**

### **If deployment fails:**
```bash
# Check deployment logs
az webapp log deployment show \
    --resource-group horizon-rg-uae \
    --name horizonbank

# View application logs
az webapp log tail \
    --resource-group horizon-rg-uae \
    --name horizonbank
```

### **If pages don't load:**
1. Check App Service is running in Azure Portal
2. Verify web.config is properly configured
3. Check application logs for errors
4. Restart the App Service:
```bash
az webapp restart --resource-group horizon-rg-uae --name horizonbank
```

### **If banking app doesn't work:**
1. Verify environment variables are set
2. Check Node.js version is 18.17.0
3. Review application logs
4. Ensure database connections are configured

## 📊 **Monitoring**

### **Enable Application Insights:**
```bash
az monitor app-insights component create \
    --app horizonbank-insights \
    --location "UAE North" \
    --resource-group horizon-rg-uae \
    --application-type web
```

### **View Metrics:**
- CPU Usage
- Memory Usage
- HTTP Request rates
- Response times
- Error rates

## 🎯 **Success Indicators**

✅ **Deployment is successful when:**
- Homepage loads with professional design
- Banking portal button redirects correctly
- All navigation links work
- Contact form displays properly
- Mobile responsive design functions
- HTTPS is enforced

## 🚦 **Current Status**

| Component | Status | Notes |
|-----------|--------|-------|
| Build | ✅ Complete | Next.js built successfully |
| Package | ✅ Ready | 6.1MB ZIP file created |
| Landing Site | ✅ Ready | PHP files configured |
| Banking App | ✅ Ready | Standalone build prepared |
| Deployment | 🔄 **Ready to Execute** | Run `./deploy-now.sh` |

---

## 🎉 **READY TO DEPLOY!**

**Execute:** `./deploy-now.sh`

Your professional banking website will be live on Azure in minutes! 🚀