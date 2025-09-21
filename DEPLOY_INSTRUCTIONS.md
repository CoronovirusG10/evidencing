# 🚀 Horizon Banking — Azure Deployment Runbook

Follow this checklist to deploy the banking portal to **horizon-banking-uae** on Azure App Service. The Next.js app is published under `/internet-banking/` using the standalone output.

---

## 1. Build & Package

```bash
npm install
npm run lint
npm run test
scripts/create-azure-zip.sh          # Produces horizon-internet-banking.zip
```

What gets packaged:
- `internet-banking/.next/standalone` and `internet-banking/.next/static`
- `internet-banking/public/`
- `internet-banking/package.json`, `internet-banking/package-lock.json`
- `startup.sh` at the archive root (runs `node .next/standalone/server.js` from `/home/site/wwwroot/internet-banking`)

Verify `internet-banking/.next/standalone/server.js` exists before continuing.

---

## 2. Deploy to Azure (UAE North)

```bash
./deploy-to-azure.sh
```

The script performs:
1. Confirms Azure CLI context (subscription + login).
2. Ensures `horizon-rg-uae`, `horizon-asp-uae`, and `horizon-banking-uae` exist.
3. Sets runtime to `NODE|20-lts` and startup command `./startup.sh`.
4. Assigns the Web App system-managed identity and grants **Key Vault Secrets User** on `horizon-kv-uae`.
5. Deploys `horizon-internet-banking.zip` via `az webapp deploy`.
6. Prints Key Vault-referenced settings via `az webapp config appsettings list`.

If a failure occurs, re-run after resolving the issue. The script is idempotent.

---

## 3. Post-Deploy Validation

1. Browse `https://horizon-banking-uae.azurewebsites.net/internet-banking/`.
2. Execute the manual test plan (`docs/manual-test-plan.md`) and log outcomes in `logs/daily/2025-09-20.md`.
3. Confirm `appCommandLine` / startup command is `./startup.sh` under **App Service → Configuration → General settings**.
4. Confirm `linuxFxVersion` is `NODE|20-lts`.
5. Validate Key Vault-backed app settings resolve correctly (no `***` masking in Portal).
6. Tail deployment logs if needed:
   ```bash
   az webapp log deployment show --resource-group horizon-rg-uae --name horizon-banking-uae
   az webapp log tail --resource-group horizon-rg-uae --name horizon-banking-uae
   ```

---

## 4. Environment & Secrets

- System-assigned managed identity is required for Key Vault references.
- App settings should be stored as `@Microsoft.KeyVault(SecretUri=https://horizon-kv-uae.vault.azure.net/secrets/<NAME>/<VERSION>)`.
- Required secrets are listed in `.env.example` and `README.md`.

---

## 5. Rollback / Redeploy

- Re-run `scripts/create-azure-zip.sh` after any code change, then execute `deploy-to-azure.sh`.
- To redeploy a previous package, use `az webapp deploy --resource-group horizon-rg-uae --name horizon-banking-uae --src-path <package>.zip --type zip`.
- Restart the Web App if traffic is routed before the package settles: `az webapp restart --resource-group horizon-rg-uae --name horizon-banking-uae`.

---

## 6. Support Notes

- All navigation is relative; the Next.js `basePath` and `assetPrefix` are locked to `/internet-banking/` in production.
- For CI/CD, replicate the packaging command then call `az webapp deploy` with the same zip artifact.
- Keep `PROJECT_PLAN.md`, `AGENTS.md`, and task logs updated whenever deployment steps are executed.

✅ Deployment is complete when the `/internet-banking/` app loads successfully on Azure and manual tests pass.
