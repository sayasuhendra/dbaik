#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# Configuration
DOMAIN="new.dbaik.com"
APP_DIR="/var/www/dbaik"
PHP_VERSION="8.2" # Laravel 12 requires PHP 8.2+

echo "========================================================="
echo " Deploying Laravel + Caddy Server Setup Script"
echo " Domain: $DOMAIN"
echo " Application Directory: $APP_DIR"
echo " Note: Run this script as root (sudo)"
echo "========================================================="

# Ensure script is run as root
if [ "$EUID" -ne 0 ]; then
  echo "Please run as root (e.g. sudo bash new-setup.sh)"
  exit
fi

# 1. Update system & install dependencies
echo ">> Updating system packages..."
apt-get update && apt-get upgrade -y
apt-get install -y curl zip unzip git software-properties-common

# 2. Install PHP
echo ">> Installing PHP $PHP_VERSION..."
add-apt-repository ppa:ondrej/php -y
apt-get update
apt-get install -y php$PHP_VERSION-fpm php$PHP_VERSION-cli php$PHP_VERSION-mbstring \
    php$PHP_VERSION-xml php$PHP_VERSION-bcmath php$PHP_VERSION-curl \
    php$PHP_VERSION-zip php$PHP_VERSION-intl php$PHP_VERSION-sqlite3 php$PHP_VERSION-mysql

# 3. Install Composer
echo ">> Installing Composer..."
if ! command -v composer &> /dev/null; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
else
    echo "Composer already installed."
fi

# 4. Install Node.js (v20 for frontend assets like Tailwind v4 & Vite)
echo ">> Installing Node.js..."
if ! command -v node &> /dev/null; then
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
    apt-get install -y nodejs
else
    echo "Node.js already installed."
fi

# 5. Install Caddy
echo ">> Installing Caddy..."
if ! command -v caddy &> /dev/null; then
    apt-get install -y debian-keyring debian-archive-keyring apt-transport-https
    curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
    curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-stable.list
    apt-get update
    apt-get install -y caddy
else
    echo "Caddy already installed."
fi

# 6. Prepare Application Directory
echo ">> Setting up application directory..."
mkdir -p $APP_DIR

echo "---------------------------------------------------------"
echo "ATTENTION:"
echo "This script assumes your project code is already in $APP_DIR"
echo "If it is NOT, you should clone it now, for example:"
echo "  git clone <your-repo-url> $APP_DIR"
echo ""
echo "Or if you are uploading files via SFTP/rsync, put them there."
echo "---------------------------------------------------------"
read -p "Press Enter to continue AFTER your code is in $APP_DIR..."

# Move to app directory
cd $APP_DIR

# 7. Laravel Environment
if [ ! -f .env ]; then
    echo ">> Creating .env file from .env.example..."
    if [ -f .env.example ]; then
        cp .env.example .env
        sed -i "s|APP_URL=.*|APP_URL=https://$DOMAIN|g" .env
        sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=sqlite|g" .env
    else
        echo "WARNING: .env.example not found!"
    fi
fi

# 8. Install Dependencies and Build
echo ">> Installing PHP dependencies..."
export COMPOSER_ALLOW_SUPERUSER=1
composer install --optimize-autoloader --no-dev

echo ">> Installing Node dependencies and building assets..."
npm install
npm run build

# 9. Laravel Configurations
echo ">> Running Laravel deployment commands..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

php artisan key:generate --force
php artisan migrate --force
php artisan storage:link || true
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

# 10. Set Permissions
echo ">> Setting permissions..."
chown -R www-data:www-data $APP_DIR
find $APP_DIR -type f -exec chmod 644 {} \;
find $APP_DIR -type d -exec chmod 755 {} \;
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache
if [ -f database/database.sqlite ]; then
    chmod 664 database/database.sqlite
fi

# 11. Configure Caddyfile
echo ">> Configuring Caddy..."
cat > /etc/caddy/Caddyfile <<EOF
$DOMAIN {
    root * $APP_DIR/public
    encode gzip zstd
    php_fastcgi unix//run/php/php$PHP_VERSION-fpm.sock
    file_server
}
EOF

# 12. Restart Services
echo ">> Restarting services..."
systemctl restart php$PHP_VERSION-fpm
systemctl restart caddy
systemctl enable caddy

echo "========================================================="
echo " Setup Complete!"
echo " Your site should now be live at https://$DOMAIN"
echo " (Caddy will automatically provision the SSL certificate)"
echo " Make sure your DNS records (A/AAAA) point to this server's IP."
echo "========================================================="
