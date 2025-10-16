#!/bin/bash
# This script updates the Nginx configuration for central and tenant domains.

sudo tee /etc/nginx/sites-available/istore > /dev/null <<'EOF'
# Redirect HTTP to HTTPS for app.salsabeelistore.shop
server {
    listen 80;
    server_name app.salsabeelistore.shop;
    return 301 https://$host$request_uri;
}

# Central HTTPS server block for app.salsabeelistore.shop
server {
    listen 443 ssl http2;
    server_name app.salsabeelistore.shop;
    root /var/www/istore/public;

    ssl_certificate /etc/letsencrypt/live/salsabeelistore.shop-0001/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/salsabeelistore.shop-0001/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}

# Redirect HTTP to HTTPS for tenant subdomains
server {
    listen 80;
    server_name .salsabeelistore.shop;
    return 301 https://$host$request_uri;
}

# Tenant HTTPS server block for *.salsabeelistore.shop
server {
    listen 443 ssl http2;
    server_name .salsabeelistore.shop;
    root /var/www/istore/public;

    ssl_certificate /etc/letsencrypt/live/salsabeelistore.shop-0001/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/salsabeelistore.shop-0001/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Test the new configuration
echo "Testing new Nginx configuration..."
sudo nginx -t

# Restart Nginx if the test is successful
if [ $? -eq 0 ]; then
    echo "Configuration test passed. Restarting Nginx..."
    sudo systemctl restart nginx
    echo "Nginx has been updated successfully for central and tenant domains."
else
    echo "Nginx configuration test failed. Please review the errors."
fi
