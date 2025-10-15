#!/bin/bash
# This script updates the Nginx configuration for wildcard subdomains.

# 1. Define the new configuration content
CONFIG_CONTENT="server {
    listen 80;
    server_name .salsabeelistore.shop;
    root /var/www/istore/public;

    index index.php index.html index.htm;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}"

# 2. Overwrite the existing configuration file
echo "$CONFIG_CONTENT" | sudo tee /etc/nginx/sites-available/istore > /dev/null

# 3. Test the new configuration
sudo nginx -t

# 4. Restart Nginx if the test is successful
if [ $? -eq 0 ]; then
    echo "Configuration test passed. Restarting Nginx..."
    sudo systemctl restart nginx
    echo "Nginx has been updated successfully."
else
    echo "Nginx configuration test failed. Please review the errors."
fi
