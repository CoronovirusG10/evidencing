# Tooling & Pre-commit Guidance

## Linting & Testing

- `npm run lint` runs `next lint --max-warnings=0` to enforce zero-warning ESLint passes.
- `npm run test` executes lightweight CSV formatter and PDF generator smoke tests (see `tests/` directory).

## Suggested pre-commit workflow

To enable automated checks on commit, install Husky & lint-staged in environments with package installation access:

```bash
npm install --save-dev husky lint-staged
npx husky install
```

Add the following to `package.json` once the dependencies are available:

```json
"lint-staged": {
  "*.{ts,tsx,js,jsx}": ["npm run lint -- --file"],
  "tests/**/*.ts": ["npm run test"]
}
```

Create `.husky/pre-commit` with:

```bash
#!/bin/sh
. "$(dirname "$0")/_/husky.sh"
npx lint-staged
```

> **Secured environment note:** This project runs inside a controlled tenant. Secrets must remain in the approved `.env` store; do not commit credentials when configuring hooks or CI pipelines.

## Formatting

Prettier is not yet wired into the toolchain. If formatting becomes a requirement, install `prettier` and add a dedicated script/hook alongside ESLint.
