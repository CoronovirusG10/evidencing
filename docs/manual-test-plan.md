# Manual Test Plan — Horizon Private Banking

This plan covers high-value scenarios across manual transactions, exports, and access control. Execute after significant changes or before releases.

## 1. Authentication & Access Control
- [ ] Sign up with an allowed email and verify redirect to Plaid linking or manual fallback.
- [ ] Attempt sign in with a non-allowed email and confirm rejection message.
- [ ] Sign out via sidebar footer and verify session cleared.

## 2. Manual Transactions
- [ ] From dashboard, open "Manual transaction" sheet and create a debit entry (e.g., $45 Dining).
- [ ] Verify new entry appears in recent transactions, statements view, and transaction history with correct direction badge.
- [ ] Create a credit entry (e.g., $500 Salary) and ensure balances and summaries update accordingly.

## 3. Transfers & Feature Flags
- [ ] With `NEXT_PUBLIC_ENABLE_TRANSFERS=true`, visit `/payment-transfer` and submit a transfer using sandbox accounts; validate success path and manual transaction logging.
- [ ] Flip flag to `false`, reload `/payment-transfer`, and confirm the notice replaces the form.
- [ ] With `NEXT_PUBLIC_ENABLE_PLAID=false`, verify Plaid linking is hidden and manual guidance appears during onboarding.

## 4. Statements & Exports
- [ ] On `/statements`, adjust filters (date range, direction) and confirm totals/guidance refresh.
- [ ] Trigger CSV export; ensure headers reflect filter context and download works.
- [ ] Trigger PDF statement download; confirm PDF opens with summary lines and transaction entries.
- [ ] Attempt more than 5 exports within a minute and confirm 429 response with `Retry-After` header.

## 5. Transaction History
- [ ] Apply date and direction filters; ensure pagination updates and `Export CSV` respects filters.
- [ ] Verify manual transaction sheet is accessible from history view.

## 6. Legal & Compliance
- [ ] Confirm legal banner appears on dashboard and statements page with working link to `/legal/disclaimer`.
- [ ] Review disclaimer content for jurisdictional coverage (UAE + US) before release.

## 7. Deployment Review (UAE Focus)
- [ ] Ensure `.env` and deployment settings use UAE regional services (App Service in UAE North, region-specific endpoints).
- [ ] Validate security headers via browser DevTools (CSP, HSTS, frame options).
- [ ] Run `npm run lint` and `npm run test` prior to deployment.

---
Document results for each checkbox and file in `logs/daily/` for traceability.
