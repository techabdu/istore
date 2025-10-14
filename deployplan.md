# Laravel LEMP Stack Deployment Plan

This guide provides step-by-step instructions to deploy the iStore Laravel application on a fresh Ubuntu 24.04 server.

**Placeholders:**
*   `your_server_ip`: The public IP address of your server.
*   `your_domain.com`: The domain name pointing to your server's IP.
*   `your_new_user`: The non-root user you will create.
*   `your_git_repo_url`: The URL of your Git repository.

---

### Step 1: Initial Server Connection (as root)

Connect to your server for the first time using the `root` user and the password provided by Kamatera.

```bash
ssh root@your_server_ip
```
When prompted about the host authenticity, type `yes`.

---

### Step 2: Initial Server Security

#### 1. Create a New Sudo User

Operating as `root` is risky. We will create a new user and give it `sudo` (administrator) privileges.

```bash
# Replace your_new_user with a username of your choice
adduser your_new_user

# Add the new user to the sudo group
usermod -aG sudo your_new_user
```

#### 2. Set Up UFW (Uncomplicated Firewall)

We will configure the server's internal firewall to only allow SSH, HTTP, and HTTPS traffic.

```bash
# Allow SSH
ufw allow OpenSSH

# Allow HTTP and HTTPS
ufw allow "Nginx Full"

# Enable the firewall
ufw enable
```

#### 3. Log in as the New User

Open a **new** terminal window and log in as your new user to ensure it works before we disable root login.

```bash
ssh your_new_user@your_server_ip
```

#### 4. Disable Root SSH Login (Optional, but Recommended)

Once you've confirmed you can log in with your new user, go back to your `root` session (or use `sudo` in your new user session) to disable root login for better security.

```bash
# Open the SSH configuration file
sudo nano /etc/ssh/sshd_config

# Find the line 'PermitRootLogin yes' and change it to:
PermitRootLogin no

# Save the file (Ctrl+O, Enter) and exit (Ctrl+X). Then, restart the SSH service.
sudo systemctl restart ssh
```
**From now on, all commands assume you are logged in as `your_new_user`.**

---

### Step 3: Install the LEMP Stack (Nginx, MySQL, PHP)

#### 1. Update Package List

```bash
sudo apt update && sudo apt upgrade -y
```

#### 2. Install Nginx

```bash
sudo apt install nginx -y
```

#### 3. Install MySQL

```bash
sudo apt install mysql-server -y
```

#### 4. Install PHP and Required Extensions

We'll install PHP 8.3 and the extensions Laravel needs.

```bash
sudo apt install php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-bcmath -y
```

---

### Step 4: Configure the LEMP Stack

#### 1. Secure MySQL

Run the security script and follow the prompts. You'll set a root password and remove insecure defaults.

```bash
sudo mysql_secure_installation
```

#### 2. Create a Database and User for the App

```bash
# Log into MySQL
sudo mysql

# Inside the MySQL prompt, run these commands:
CREATE DATABASE istore;
CREATE USER 'istore_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON istore.* TO 'istore_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

### Step 5: Deploy the Laravel Application

#### 1. Install Composer and Git

```bash
sudo apt install git -y
# Install Composer globally
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

#### 2. Clone the Project

```bash
# Navigate to the web root and clone your project
cd /var/www
sudo git clone your_git_repo_url istore

# Navigate into the project directory
cd istore
```

#### 3. Set Permissions

The `www-data` user (which Nginx runs as) needs to own the project files.

```bash
sudo chown -R $USER:www-data /var/www/istore
sudo chmod -R 775 /var/www/istore/storage
sudo chmod -R 775 /var/www/istore/bootstrap/cache
```

#### 4. Configure Environment and Install Dependencies

```bash
# Copy the example .env file
cp .env.example .env

# Open the .env file to edit it
nano .env
```

**In the `.env` file, update these values:**
*   `APP_NAME="iStore"
*   `APP_ENV=production
*   `APP_DEBUG=false
*   `APP_URL=http://your_domain.com
*   `DB_DATABASE=istore
*   `DB_USERNAME=istore_user
*   `DB_PASSWORD=your_strong_password

Save and close the file. Now, install dependencies and prepare the app.

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Generate a new app key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Link the storage directory
php artisan storage:link

# Cache configuration and routes for production speed
php artisan config:cache
php artisan route:cache
```

---

### Step 6: Configure Nginx Server Block

Create a new Nginx configuration file for your site.

```bash
sudo nano /etc/nginx/sites-available/istore
```

Paste the following configuration into the file. **Replace `your_domain.com` with your actual domain.**

```nginx
server {
    listen 80;
    server_name your_domain.com www.your_domain.com;
    root /var/www/istore/public;

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
```

Save and close the file. Now, enable the site and restart Nginx.

```bash
# Create a symbolic link to enable the site
sudo ln -s /etc/nginx/sites-available/istore /etc/nginx/sites-enabled/

# Test the Nginx configuration for errors
sudo nginx -t

# If no errors, restart Nginx to apply the changes
sudo systemctl restart nginx
```
At this point, your site should be live on HTTP.

---

### Step 7: Build Frontend Assets

```bash
# Install Node.js (we'll use nvm to manage versions)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
source ~/.bashrc

# Install a recent LTS version of Node
nvm install --lts

# Install npm dependencies
npm install

# Build assets for production
npm run build
```

---

### Step 8: Secure Your Site with SSL (Let's Encrypt)

This final step will configure HTTPS for your domain.

```bash
# Install Certbot, the Let's Encrypt client
sudo apt install certbot python3-certbot-nginx -y

# Obtain and install the SSL certificate
sudo certbot --nginx -d your_domain.com -d www.your_domain.com
```

Certbot will ask a few questions (email, terms of service). It will then automatically obtain a certificate and update your Nginx configuration to handle HTTPS and redirect HTTP traffic to HTTPS.

Your deployment is now complete and secure!

* SSL Auto-Renewal: The Certbot tool automatically configured your server to renew the SSL certificate on its own before
     it expires. You don't need to do anything to maintain it.

   * Future Updates: When you make changes to your application code in the future, your deployment process will be much
     simpler. You'll just need to:
       1. ssh into your server.
       2. Navigate to the project directory: cd /var/www/istore
       3. Pull your latest code: git pull
       4. Run any necessary update commands, like composer install or php artisan migrate.
