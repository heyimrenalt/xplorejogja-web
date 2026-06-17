#!/bin/bash
set -e

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
