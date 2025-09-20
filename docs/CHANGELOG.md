# Change Log

All notable changes to this project will be documented in this file.

> For each release, use ISO dates (`YYYY-MM-DD`) and link to related tasks/log entries.

## Unreleased
- Added Plaid/Dwolla feature flags with manual fallbacks (2025-09-20 — TASK-20250920-009).
- Hardened export endpoints with rate limits and security headers (2025-09-20 — TASK-20250920-010).
- Added CSV/PDF smoke tests and tooling documentation (2025-09-20 — TASK-20250920-011).

## PR Checklist
- [ ] Update `README.md` with any new environment variables or scripts.
- [ ] Add/change manual test steps in `docs/manual-test-plan.md` if user flows shift.
- [ ] Confirm `npm run lint` and `npm run test` succeed locally.
- [ ] Note feature flag defaults in PR description when toggles change behaviour.
- [ ] Reference relevant task IDs/log entries when adding change log notes.

## 2025-09-20
- Initial private banking plan, logging structure, Appwrite setup, theming, feature flags, security hardening, and tooling updates.
