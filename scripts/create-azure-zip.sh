#!/bin/bash
# Build and package the Horizon Next.js app for Azure App Service deployment
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ZIP_NAME="${1:-horizon-internet-banking.zip}"
PACKAGE_DIR="$ROOT_DIR/.azure-deploy"
APP_DIR="$PACKAGE_DIR/internet-banking"

cd "$ROOT_DIR"

echo "[create-azure-zip] Cleaning previous artifacts..."
rm -rf "$PACKAGE_DIR"
rm -f "$ZIP_NAME"

echo "[create-azure-zip] Running production build (standalone output)..."
npm run build

if [ ! -d "$ROOT_DIR/.next/standalone" ]; then
  echo "Standalone build output not found at .next/standalone" >&2
  exit 1
fi

mkdir -p "$APP_DIR/.next"

echo "[create-azure-zip] Copying .next standalone server..."
rsync -a --delete "$ROOT_DIR/.next/standalone/" "$APP_DIR/.next/standalone/"

echo "[create-azure-zip] Copying static assets..."
rsync -a --delete "$ROOT_DIR/.next/static/" "$APP_DIR/.next/static/"

echo "[create-azure-zip] Copying public assets and metadata..."
rsync -a "$ROOT_DIR/public/" "$APP_DIR/public/"
cp "$ROOT_DIR/package.json" "$APP_DIR/"
cp "$ROOT_DIR/package-lock.json" "$APP_DIR/"
cp "$ROOT_DIR/startup.sh" "$PACKAGE_DIR/"
chmod +x "$PACKAGE_DIR/startup.sh"

echo "[create-azure-zip] Creating deployment archive $ZIP_NAME..."
(
  cd "$PACKAGE_DIR" && zip -qr "$ROOT_DIR/$ZIP_NAME" .
)

echo "[create-azure-zip] Cleaning staging directory..."
rm -rf "$PACKAGE_DIR"

echo "[create-azure-zip] Package created: $ROOT_DIR/$ZIP_NAME"
