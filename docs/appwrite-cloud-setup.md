# Appwrite Cloud Setup Guide

This guide explains how to provision the Appwrite Cloud resources required by the Horizon banking portal and how each resource maps to the environment variables consumed by the Next.js application.

## 1. Prerequisites
- An Appwrite Cloud organization with permissions to create projects and API keys.
- Email/password auth enabled in your Appwrite project (used by Horizon sign-up/sign-in flows).
- Access to manage Plaid and Dwolla credentials (needed later in the deployment flow).

## 2. Create the Horizon project
1. Sign in to [Appwrite Cloud](https://cloud.appwrite.io/), click **Create Project**, and name it (e.g., `horizon-banking`).
2. Under **Settings → Platforms**, add a **Web App** platform and register your local URL (`http://localhost:3000`) plus any production domains.
3. Copy the generated **Project ID** and **Endpoint**; they populate `NEXT_PUBLIC_APPWRITE_PROJECT` and `NEXT_PUBLIC_APPWRITE_ENDPOINT`.

## 3. Provision API key for server actions
Horizon executes privileged operations (creating users, managing documents) via server actions that call the Appwrite Admin SDK.

1. Navigate to **Settings → API Keys** and create a new key named `horizon-admin`.
2. Grant the following scopes:
   - `databases.read`, `databases.write`
   - `collections.read`, `collections.write`
   - `documents.read`, `documents.write`
   - `users.read`, `users.write`
   - `account.read`, `account.write` (needed for email/password session management)
3. Copy the key value and store it as `NEXT_APPWRITE_KEY` in your environment.

> Horizon stores the Appwrite session secret in an HTTP-only cookie named `appwrite-session`. Ensure **Email/Password** auth is enabled under **Authentication → Settings** so account sessions can be created.

## 4. Configure database and collections
Create a single database (recommended name: `banking`) to hold user, bank, and transaction documents.

1. Go to **Database → Create** and name the database `banking`.
2. Record the database ID as `APPWRITE_DATABASE_ID`.
3. Inside the database, create the following collections and attributes:

### 4.1 Users collection
- **Collection name**: `users`
- **Security**: enable document-level permissions; allow only the owning user to read/write. The server uses the API key to bypass restrictions.
- **Attributes** (all `string`, unless noted):
  - `userId` (required, 36 chars) — Appwrite Auth user ID; mark as **unique**.
  - `email` (required)
  - `firstName`, `lastName`, `address1`, `city`, `state` (2 chars), `postalCode`, `dateOfBirth`, `ssn`, `password`
  - `dwollaCustomerId`, `dwollaCustomerUrl`
- **Indexes**:
  - `idx_user_userId` on `userId` (type: key).

Record the collection ID in `APPWRITE_USER_COLLECTION_ID`.

### 4.2 Banks collection
- **Collection name**: `banks`
- **Security**: restrict read/write to the owning user.
- **Attributes**:
  - `userId` (string, required) — references `users.$id` (the document ID).
  - `bankId` (string, required) — Plaid item ID.
  - `accountId` (string, required)
  - `accessToken` (string, required)
  - `fundingSourceUrl` (string, required)
  - `shareableId` (string, required) — base64-encoded Plaid account ID.
- **Indexes**:
  - `idx_banks_userId` on `userId` for dashboard queries.
  - `idx_banks_accountId` on `accountId` for `getBankByAccountId` lookups.

Store the collection ID in `APPWRITE_BANK_COLLECTION_ID`.

### 4.3 Transactions collection
- **Collection name**: `transactions`
- **Security**: limit read access to the sender and receiver users; allow server writes.
- **Attributes**:
  - `bankId` (string, required) — Appwrite document ID of the associated bank.
  - `userId` (string) — owning user document ID (optional but recommended for auditing).
  - `name` (string)
  - `email` (string, optional)
  - `amount` (float)
  - `direction` (string enum: `credit` or `debit`)
  - `source` (string enum: `plaid`, `manual`, `transfer`)
  - `status` (string enum: `posted`, `pending`)
  - `paymentChannel` (string)
  - `category` (string)
  - `date` (string, ISO timestamp)
  - `senderId`, `receiverId` (string) — legacy transfer references.
  - `senderBankId`, `receiverBankId` (string) — legacy transfer references.
  - `externalId` (string, optional) — Plaid transaction ID for idempotent syncs.
  - `notes` (string, optional)
  - `metadata` (JSON, optional) for future enrichment.
- **Indexes**:
  - `idx_transactions_bankId` on `bankId` (key).
  - `idx_transactions_externalId` on `externalId` (unique) for Plaid upserts.
  - (Legacy) keep `idx_transactions_senderBankId` and `idx_transactions_receiverBankId` until old data is migrated.

Save the collection ID as `APPWRITE_TRANSACTION_COLLECTION_ID`.

## 5. Environment variable mapping
Create a `.env.local` (or configure Azure App Service settings) with the following variables:

| Env var | Source | Purpose |
| --- | --- | --- |
| `NEXT_PUBLIC_APPWRITE_ENDPOINT` | Project settings → API endpoint | Used by both session and admin clients.
| `NEXT_PUBLIC_APPWRITE_PROJECT` | Project settings → Project ID | Identifies the Appwrite project.
| `NEXT_APPWRITE_KEY` | API key value | Grants server actions privileged access.
| `APPWRITE_DATABASE_ID` | Database → `banking` → ID | Target database for documents.
| `APPWRITE_USER_COLLECTION_ID` | Database → `users` collection ID | Stores user profiles.
| `APPWRITE_BANK_COLLECTION_ID` | Database → `banks` collection ID | Stores Plaid/Dwolla linkage data.
| `APPWRITE_TRANSACTION_COLLECTION_ID` | Database → `transactions` collection ID | Stores manual and Dwolla transactions.
| `ALLOWED_EMAILS` | Deployment configuration | Comma-separated allowlist of user emails for Horizon access. Leave blank to allow all emails.
| `NEXT_PUBLIC_ENABLE_PLAID` | Deployment configuration | Toggle to disable Plaid integration (defaults to `true`).
| `NEXT_PUBLIC_ENABLE_TRANSFERS` | Deployment configuration | Toggle to disable Dwolla transfers/UI (defaults to `true`).

## 6. Client usage patterns in Horizon
- `lib/appwrite.ts` exports `createAdminClient` (uses the API key for server-side mutations) and `createSessionClient` (uses the `appwrite-session` cookie for per-user actions).
- `lib/actions/user.actions.ts` creates Appwrite Auth users via the admin client, persists profile metadata to the `users` collection, and stores Dwolla metadata.
- `lib/actions/user.actions.ts#getBanks` and `lib/actions/bank.actions.ts#getAccounts` rely on the `banks` collection to fetch Plaid access tokens and display balances.
- `lib/actions/transaction.actions.ts` writes to and queries the `transactions` collection with `senderBankId`/`receiverBankId` filters—for performance, the indexes above are required.

Ensure the API key remains server-only (`NEXT_APPWRITE_KEY` must **not** be prefixed with `NEXT_PUBLIC_`).

## 7. Next steps
- Verify the new collection IDs and key are added to your deployment environment.
- Update the project README to reflect the correct variable names (`NEXT_APPWRITE_KEY` instead of `APPWRITE_SECRET`).
- Proceed to configure Plaid and Dwolla integrations once Appwrite is operational.
