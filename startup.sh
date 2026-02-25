#!/bin/bash

cd /home/site/wwwroot

composer install --no-dev --optimize-autoloader

php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache