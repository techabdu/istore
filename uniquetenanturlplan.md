# 🚀 Unique Tenant URL Implementation Plan

This document outlines the steps required to configure the iStore application to use unique subdomains for each tenant (e.g., `tenant1.istore.com`).

---

### ✅ Plan & Progress

- [x] **Step 1: Configure Wildcard DNS Record**
- [x] **Step 2: Update Nginx Configuration**
- [x] **Step 3: Update Tenancy Middleware**
- [x] **Step 4: Update Tenant Registration Logic**
- [x] **Step 5: Obtain Wildcard SSL Certificate**

---

### 📖 Step Details

---

### **Step 1: Configure Wildcard DNS Record (Manual Task)**

**Goal:** To direct traffic for *any* subdomain of `salsabeelistore.shop` to our server.

**Action Required (by You):**
1. Log in to your **Hostinger** account.
2. Go to the **DNS / Zone Editor** for `salsabeelistore.shop`.
3. Create a new **`A` Record** with the following details:
    - **Type:** `A`
    - **Name / Host:** `*` (an asterisk)
    - **Value / Points to:** Your Kamatera server's public IP address.

**Explanation:** The `*` is a wildcard that matches any subdomain. This single record tells the internet that `tenant1.salsabeelistore.shop`, `tenant2.salsabeelistore.shop`, etc., should all point to your server.

---

### **Step 2: Update Nginx Configuration**

**Goal:** To configure the web server to accept requests for any subdomain.

**Action Required (by Me):**
1. Read the Nginx config file: `/etc/nginx/sites-available/istore`.
2. Modify the `server_name` directive to accept wildcards.
   - **From:** `server_name salsabeelistore.shop www.salsabeelistore.shop;`
   - **To:** `server_name .salsabeelistore.shop;` (The leading dot handles the root domain and all subdomains).
3. Restart the Nginx service to apply the changes.

**Explanation:** This tells Nginx that this server block is responsible for handling traffic for the main domain and all its subdomains.

---

### **Step 3: Update Tenancy Middleware**

**Goal:** To enable the application to identify tenants based on the subdomain in the URL.

**Action Required (by Me):**
1. Read the `config/tenancy.php` file.
2. Add the `InitializeTenancyByDomain` middleware to the `tenant_middleware` array.

**Explanation:** The `stancl/tenancy` package needs this middleware to look at the URL (`tenant1.salsabeelistore.shop`) and automatically load the correct tenant's database and settings.

---

### **Step 4: Update Tenant Registration Logic**

**Goal:** To automatically create and assign a unique subdomain to each new tenant upon registration.

**Action Required (by Me):**
1. Read the `app/Http/Controllers/TenantRegistrationController.php` file.
2. After the `Tenant::create()` call, add logic to create a corresponding domain for the tenant.
   - Example: `$tenant->createDomain(['domain' => $subdomain . '.salsabeelistore.shop']);`

**Explanation:** This step links the tenant created in the database with their unique URL. Without this, the application wouldn't know which tenant belongs to which subdomain.

---

### **Step 5: Obtain Wildcard SSL Certificate**

**Goal:** To secure all tenant subdomains with HTTPS.

**Action Required (by Me & You):**
1. Run `certbot` to request a new wildcard certificate.
   - Command: `sudo certbot --nginx -d salsabeelistore.shop -d *.salsabeelistore.shop`
2. **Manual Verification:** Certbot will require you to add a `TXT` record to your DNS (at Hostinger) to prove you own the domain. It will pause and give you the exact record to add.
3. Once you add the `TXT` record, we will confirm in the Certbot prompt, and it will issue the certificate.

**Explanation:** A standard SSL certificate only covers specific domains. A wildcard certificate is needed to cover all potential subdomains we create for tenants.
