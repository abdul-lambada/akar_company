#!/bin/bash
# Plesk Git: Run script after deployment
# Purpose: Automate Laravel deploy steps on Plesk hosting
# Usage (Plesk > Git > Run script):
#   bash ./deploy/plesk-post-deploy.sh

set -euo pipefail
IFS=$'\n\t'

PROJECT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$PROJECT_DIR"

# --- Clear stale cache before any Artisan command (prevent boot errors) ---
rm -f bootstrap/cache/services.php bootstrap/cache/packages.php || true

# --- Detect PHP binary ---
if command -v php >/dev/null 2>&1; then
  PHP_BIN="php"
elif [ -x "/opt/plesk/php/8.2/bin/php" ]; then
  PHP_BIN="/opt/plesk/php/8.2/bin/php"
else
  # Fallback common path
  PHP_BIN="/usr/bin/php"
fi

echo "Using PHP: $(which "$PHP_BIN" || echo "$PHP_BIN")"

# --- Detect Composer ---
if command -v composer >/dev/null 2>&1; then
  COMPOSER_BIN="composer"
elif [ -f "/usr/lib/plesk-9.0/composer.phar" ]; then
  COMPOSER_BIN="$PHP_BIN /usr/lib/plesk-9.0/composer.phar"
elif [ -f "$PROJECT_DIR/composer.phar" ]; then
  COMPOSER_BIN="$PHP_BIN $PROJECT_DIR/composer.phar"
else
  echo "Composer not found. Upload composer.phar or enable Plesk Composer extension." >&2
  exit 1
fi

echo "Using Composer: $COMPOSER_BIN"

export COMPOSER_ALLOW_SUPERUSER=1

# --- Refresh optimized autoload before running Artisan ---
$COMPOSER_BIN dump-autoload -o

# --- Maintenance mode (optional) ---
$PHP_BIN artisan down || true

# --- Install/update dependencies ---
$COMPOSER_BIN install --no-dev --optimize-autoloader --prefer-dist

# --- Database migrations ---
$PHP_BIN artisan migrate --force

# --- Ensure storage symlink exists ---
if [ ! -L "public/storage" ]; then
  $PHP_BIN artisan storage:link || true
fi

# --- Optimize / rebuild caches ---
$PHP_BIN artisan optimize:clear
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# --- Restart queue workers if any ---
$PHP_BIN artisan queue:restart || true

# --- Basic permissions (optional; adjust user/group if needed) ---
# find storage -type d -exec chmod 775 {} \; || true
# find storage -type f -exec chmod 664 {} \; || true
# chmod -R 775 bootstrap/cache || true

$PHP_BIN artisan up || true

echo "[Plesk Deploy] Completed successfully."
