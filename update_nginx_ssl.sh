#!/bin/bash
# This script updates the Nginx configuration for SSL using a robust heredoc.

# 1. Overwrite the existing configuration file using a "here document"
sudo tee /etc/nginx/sites-available/istore > /dev/null <<'EOF'
# Redirect all HTTP traffic to HTTPS
server {
    listen 80;
    server_name .salsabeelistore.shop;
    return 301 https://$host$request_uri;
}

# Main HTTPS server block
server {
    listen 443 ssl http2;
    server_name .salsabeelistore.shop;
    root /var/www/istore/public;

    # SSL Configuration - using the new wildcard certificate
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

# 2. Test the new configuration
echo "Testing new Nginx configuration..."
sudo nginx -t

# 3. Restart Nginx if the test is successful
if [ $? -eq 0 ]; then
    echo "Configuration test passed. Restarting Nginx..."
    sudo systemctl restart nginx
    echo "Nginx has been updated successfully for HTTPS."
else
    echo "Nginx configuration test failed. Please review the errors."
fi