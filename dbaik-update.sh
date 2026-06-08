#!/bin/bash

# ==============================================================================
# dbaik-update.sh
# Update Script for dbaik.com
# ==============================================================================

# Exit immediately if a command exits with a non-zero status
set -e

# Configuration
PHP_CMD="php8.2" # Change to php8.3 if preferred
COMPOSER_CMD="composer"
NPM_CMD="npm"

echo "========================================"
echo "Starting dbaik.com Update..."
echo "========================================"

# 1. Put application in maintenance mode
echo "Putting application in maintenance mode..."
$PHP_CMD artisan down || true

# 2. Pull latest code
echo "Pulling latest code from Git..."
git pull origin main

# 3. Install/Update Composer Dependencies
echo "Updating Composer dependencies..."
$PHP_CMD $COMPOSER_CMD install --optimize-autoloader --no-dev

# 4. Run Migrations
echo "Running database migrations..."
$PHP_CMD artisan migrate --force

# 5. Build Frontend Assets
echo "Building frontend assets..."
$NPM_CMD install
$NPM_CMD run build

# 6. Optimize Laravel
echo "Clearing and optimizing application cache..."
$PHP_CMD artisan optimize:clear
$PHP_CMD artisan optimize
$PHP_CMD artisan view:cache

# 7. Restart Queue Worker (If using database/redis queues)
echo "Restarting queue workers..."
$PHP_CMD artisan queue:restart || true

# 8. Set Permissions (to ensure no permission issues after git pull/npm)
echo "Fixing file permissions..."
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

# 9. Bring application back up
echo "Bringing application out of maintenance mode..."
$PHP_CMD artisan up

echo "========================================"
echo "Update Complete! Application is live."
echo "========================================"
