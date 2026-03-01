#!/bin/bash
cd /home/site/wwwroot

# Buat folder yang diperlukan
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/logs
chmod -R 775 storage
chmod -R 775 bootstrap/cache

composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache

# Konfigurasi nginx
cat > /etc/nginx/sites-enabled/default << 'EOF'
server {
    listen 8080;
    root /home/site/wwwroot/public;
    index index.php index.html;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF
service nginx restart