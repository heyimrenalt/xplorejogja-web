#!/bin/bash
set -e

# Populate volume dengan gambar dari backup kalau volume kosong (first deploy)
if [ -d /tmp/images-backup ] && [ ! -f /var/www/html/public/images/.volume-populated ]; then
    echo "Populating volume with backup images..."
    cp -rn /tmp/images-backup/* /var/www/html/public/images/ 2>/dev/null || true
    touch /var/www/html/public/images/.volume-populated
    chown -R www-data:www-data /var/www/html/public/images
    chmod -R 775 /var/www/html/public/images
fi

# Generate APP_KEY kalau belum ada
if [ -z "$APP_KEY" ]; then
    echo "Warning: APP_KEY not set"
fi

# Cache config & routes (production optimization)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Storage symlink
php artisan storage:link || true

# Run migrations (kalau auto-migrate diinginkan)
php artisan migrate --force || true

# Start supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
