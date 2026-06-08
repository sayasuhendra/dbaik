#!/bin/bash

# ==============================================================================
# dbaik-setup.sh
# Initial Setup Script for dbaik.com
# ==============================================================================

# Exit immediately if a command exits with a non-zero status
set -e

# Configuration
PHP_CMD="php8.2" # Change to php8.3 if preferred
COMPOSER_CMD="composer"
NPM_CMD="npm"

echo "========================================"
echo "Starting dbaik.com Deployment Setup..."
echo "========================================"

# 1. Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo "Please update your .env file with correct database and domain settings before continuing."
    echo "Run this script again after updating .env."
    exit 0
fi

# 2. Install Composer Dependencies
echo "Installing Composer dependencies..."
$PHP_CMD $COMPOSER_CMD install --optimize-autoloader --no-dev

# 3. Generate App Key
echo "Generating Application Key..."
$PHP_CMD artisan key:generate --force

# 4. Storage Link
echo "Linking storage..."
$PHP_CMD artisan storage:link

# 5. Run Migrations
echo "Running database migrations..."
$PHP_CMD artisan migrate --force

# 6. Install NPM Dependencies & Build
echo "Building frontend assets..."
$NPM_CMD install
$NPM_CMD run build

# 7. Optimize Laravel
echo "Optimizing application..."
$PHP_CMD artisan optimize:clear
$PHP_CMD artisan optimize
$PHP_CMD artisan view:cache

# 8. Set Permissions (assuming Nginx/PHP-FPM runs as www-data)
echo "Setting file permissions..."
chown -R www-data:www-data .
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

echo "========================================"
echo "Setup Complete! Your application is ready."
echo "========================================"
