# Azure Deployment Guide (UAE North)

This guide outlines how to deploy Horizon to Azure App Service in the UAE North region using Appwrite Cloud and existing feature flags.

## 1. Prerequisites
- Azure subscription with access to UAE North region.
- Appwrite Cloud project + API key (see `docs/appwrite-cloud-setup.md`).
- Plaid/Dwolla credentials stored securely; rotate before production deployment.
- GitHub repository (or Azure DevOps) with access to project source.

## 2. Resource Provisioning (Azure CLI)

```bash
RESOURCE_GROUP="horizon-rg-uae"
LOCATION="uaenorth"
APP_SERVICE_PLAN="horizon-asp-uae"
WEB_APP_NAME="horizon-banking-uae"
KEY_VAULT_NAME="horizon-kv-uae"

az group create --name $RESOURCE_GROUP --location $LOCATION
az appservice plan create --name $APP_SERVICE_PLAN --resource-group $RESOURCE_GROUP --location $LOCATION --sku P1v3 --is-linux
az webapp create --resource-group $RESOURCE_GROUP --plan $APP_SERVICE_PLAN --name $WEB_APP_NAME --runtime "NODE|20-lts"
az keyvault create --name $KEY_VAULT_NAME --resource-group $RESOURCE_GROUP --location $LOCATION
```

Optional: create Azure Container Registry if using custom container builds.

## 3. Secrets Management
Store Appwrite, Plaid, Dwolla, and feature flag values in Key Vault. Use Azure CLI or portal to set secrets:

```bash
az keyvault secret set --vault-name $KEY_VAULT_NAME --name "NEXT-APPWRITE-KEY" --value "<APPWRITE_KEY>"
# Repeat for other secrets
```

Link Key Vault to your Web App (Access Policy or Managed Identity recommended):
1. Enable System Assigned Managed Identity on the Web App.
2. Add Key Vault access policy allowing `Get`/`List` for secrets.
3. Configure App Settings to reference Key Vault secrets (`@Microsoft.KeyVault(SecretUri=...)`).

Environment variables required (see `.env.example` + feature flags):
- `NEXT_PUBLIC_APPWRITE_ENDPOINT`
- `NEXT_PUBLIC_APPWRITE_PROJECT`
- `APPWRITE_DATABASE_ID`, `APPWRITE_USER_COLLECTION_ID`, `APPWRITE_BANK_COLLECTION_ID`, `APPWRITE_TRANSACTION_COLLECTION_ID`
- `NEXT_APPWRITE_KEY`
- `NEXT_PUBLIC_ENABLE_PLAID`, `NEXT_PUBLIC_ENABLE_TRANSFERS`
- Plaid & Dwolla credentials

## 4. Deployment Pipeline (GitHub Actions example)

Create `.github/workflows/azure-deploy.yml`:

```yaml
name: Deploy Horizon (UAE)

on:
  push:
    branches: [ main ]

jobs:
  build-and-deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: 20
      - run: npm install
      - run: npm run lint
      - run: npm run test
      - run: npm run build
      - name: 'Deploy to Azure Web App'
        uses: azure/webapps-deploy@v3
        with:
          app-name: ${{ secrets.AZURE_WEBAPP_NAME }}
          publish-profile: ${{ secrets.AZURE_PUBLISH_PROFILE }}
```

Set `AZURE_PUBLISH_PROFILE` via `az webapp deployment list-publishing-profiles` or use OIDC-based deployment for enhanced security.

## 5. Post-Deploy Verification Checklist
- [ ] Access `https://<WEB_APP_NAME>.azurewebsites.net` (force HTTPS) and complete manual smoketest.
- [ ] Run `npm run lint`/`npm run test` locally prior to deployment and note results in `logs/daily/`.
- [ ] Confirm rate-limited endpoints respond with security headers (CSP, HSTS) via browser dev tools or `curl -I`.
- [ ] Validate Appwrite connectivity with `curl` to `/api` routes (expect authentication prompts).
- [ ] Monitor App Service logs via `az webapp log tail` or Application Insights if configured.
- [ ] For UAE deployments, ensure data residency requirements are met (Appwrite + Azure resources within UAE zones).

---
Keep this guide updated as infrastructure or CI/CD processes evolve.
