# Private Bank Portal Implementation Plan

This plan captures the work required to deliver the private banking portal experience, Azure deployment guidance, and supporting documentation. Update the status checkboxes as tasks progress.

## Legend
- [ ] Not started
- [~] In progress (replace the checkbox text)
- [x] Complete

---

## Phase 1 — Discovery & Environment
- [x] Audit repository structure, dependencies, and existing Plaid/Dwolla implementations *(see logs/tasks/TASK-20250920-003.md)*
- [x] Capture current env variables, secrets usage, and runtime expectations *(2025-09-20)*
- [x] Identify gaps against new requirements (manual txns, exports, theming, access control) *(documented in TASK-20250920-003.md)*

## Phase 2 — Appwrite Cloud Configuration
- [x] Draft Appwrite Cloud setup instructions (project, database, collection, permissions, indexes) *(docs/appwrite-cloud-setup.md)*
- [x] Produce mapping between Appwrite resources and env vars *(docs/appwrite-cloud-setup.md §5)*
- [x] Document API key/session client usage patterns *(docs/appwrite-cloud-setup.md §6)*

## Phase 3 — Auth & Access Control
- [x] Implement `lib/auth-guard.ts` server action tied to `ALLOWED_EMAILS` *(logs/tasks/TASK-20250920-005.md)*
- [x] Enforce guard in middleware for protected routes and `/api/*` *(middleware.ts)*
- [x] Update sign-up/sign-in flows to reject non-whitelisted emails with UX messaging *(components/AuthForm.tsx)*

## Phase 4 — Transactions Data Model & Sync
- [x] Wire Appwrite session client into data fetching utilities *(lib/appwrite.ts, lib/actions/user.actions.ts, lib/actions/transaction.actions.ts)*
- [x] Ensure Plaid sync (if invoked) persists transactions into Appwrite *(lib/actions/bank.actions.ts, lib/actions/transaction.actions.ts)*
- [x] Implement manual transaction server action with validation *(lib/actions/transaction.actions.ts)*
- [x] Add client modal/form for manual transaction creation with list revalidation *(components/ManualTransactionSheet.tsx, components/RecentTransactions.tsx)*

## Phase 5 — Export Features
- [x] Build CSV export endpoint with filters and streaming response *(app/api/transactions/export/route.ts)*
- [x] Add UI trigger(s) for CSV export respecting active filters *(components/TransactionFilters.tsx, components/StatementFilters.tsx)*
- [x] Build statements page with opening/closing balances, running totals *(app/(root)/statements/page.tsx)*
- [x] Implement PDF export route using lightweight generator *(app/api/statements/pdf/route.ts, lib/pdf.ts)*
- [x] Connect statement UI to PDF export action/button *(components/StatementFilters.tsx)*

## Phase 6 — UI, Theming & Legal
- [x] Define Tailwind theme extensions (palette, typography) *(tailwind.config.ts, app/globals.css, app/layout.tsx)*
- [x] Apply bank-style shell (nav, account selector, transaction table badges) *(components/TransactionsTable.tsx, constants/index.ts)*
- [x] Insert legal disclaimer banner component on dashboard and statements view *(components/LegalBanner.tsx, app/(root)/page.tsx, app/(root)/statements/page.tsx)*
- [x] Create `/legal/disclaimer` page with full wording *(app/(root)/legal/disclaimer/page.tsx)*
- [x] Prepare guide for rebranding (colors, logos, typography) *(docs/theming-guide.md)*

## Phase 7 — Feature Flags & Integrations
- [x] Introduce `ENABLE_TRANSFERS` and hide Dwolla UI when false *(app/(root)/payment-transfer/page.tsx, components/feature filters)*
- [x] Introduce `ENABLE_PLAID` with graceful fallback to manual flow *(components/PlaidLink.tsx, components/Sidebar.tsx)*
- [x] Validate default flag values and documentation *(README.md, .env.example, docs/appwrite-cloud-setup.md)*

## Phase 8 — Security & Reliability
- [x] Add rate limiting middleware for export/PDF routes *(lib/rate-limit.ts, app/api/transactions/export/route.ts, app/api/statements/pdf/route.ts)*
- [x] Ensure API routes filter on session userId and log key events *(app/api/transactions/export/route.ts, app/api/statements/pdf/route.ts)*
- [x] Configure security headers in `next.config.mjs`
- [x] Review for secret exposure and adjust bundling/server actions as needed *(AGENTS.md notes, README security guidance)*

## Phase 9 — Tooling & Tests
- [x] Add CSV formatter unit tests *(tests/csv.test.ts)*
- [x] Add PDF route smoke test (status/header) *(tests/pdf.test.ts)*
- [ ] Configure ESLint/Prettier and lint-staged pre-commit hook
- [x] Update existing scripts/package.json for lint/test commands *(package.json, README.md, docs/tooling.md)*

## Phase 10 — Documentation & Change Log
- [x] Expand README with setup, Appwrite/Azure deployment, export instructions, theming guide *(README.md, docs/theming-guide.md)*
- [x] Add change log / PR checklist summary *(docs/CHANGELOG.md)*
- [x] Include manual test plan (CSV/PDF/manual entry) in documentation *(docs/manual-test-plan.md)*

## Phase 11 — Azure Deployment Enablement
- [x] Document Azure resource provisioning (Resource Group in UAE North, App Service Plan, Web App, Key Vault, optional ACR) *(docs/azure-deployment.md)*
- [x] Provide CI/CD guidance (GitHub Actions → App Service) *(docs/azure-deployment.md)*
- [x] Outline secrets management via Key Vault and app settings *(docs/azure-deployment.md)*
- [x] Detail verification steps post-deploy (health checks, logging, UAE compliance checks) *(docs/manual-test-plan.md, docs/azure-deployment.md)*

## Phase 12 — Validation & Handover
- [x] Run lint/tests locally; capture results in log *(logs/daily/2025-09-20.md)*
- [ ] Perform end-to-end flow verification and note outcomes *(docs/manual-test-plan.md to execute)*
- [x] Update AGENTS.md log with completion summary and follow-up items *(AGENTS.md)*

---

_Last updated: 2025-09-20_
