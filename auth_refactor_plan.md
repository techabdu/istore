# 🔐 Authentication & Multi-Tenancy Refactor Plan

This plan outlines the steps to refactor the authentication and multi-tenancy architecture according to the provided PRD, ensuring strict separation between central (developer) and tenant users/data.

---

### ✅ Plan & Progress

- [x] **Step 1: Define New Domain Structure & DNS**
- [x] **Step 2: Separate User Models & Migrations**
- [x] **Step 3: Implement Central Authentication**
- [x] **Step 4: Implement Tenant Authentication**
- [ ] **Step 5: Refactor Tenant Registration Flow**
- [ ] **Step 6: Refactor Dashboard Redirections**
- [ ] **Step 7: Update Seeders and Factories**
- [ ] **Step 8: Clean Up & Verification**

---

### 📖 Step Details

---

### **Step 1: Define New Domain Structure & DNS**

**Goal:** Establish `app.salsabeelistore.shop` as the dedicated central domain and `*.salsabeelistore.shop` for tenants.

**Actions Required:**
1.  **Update `config/tenancy.php`:**
    -   Add `'app.salsabeelistore.shop'` to the `central_domains` array.
    -   Ensure `'salsabeelistore.shop'` is *not* in `central_domains` (it should already be removed from previous steps).
2.  **User Action: Update DNS (Hostinger):**
    -   Create an `A` record for `app.salsabeelistore.shop` pointing to your Kamatera server's IP.
    -   Ensure the wildcard `A` record (`*`) for `salsabeelistore.shop` is still in place, pointing to your Kamatera server's IP.
3.  **Update Nginx Configuration:**
    -   Modify `/etc/nginx/sites-available/istore` to create a separate `server` block for `app.salsabeelistore.shop`.
    -   The existing wildcard `server` block (`.salsabeelistore.shop`) will handle tenant domains.
    -   Ensure both blocks have correct SSL configuration.
4.  **Re-run Certbot (if necessary):**
    -   If `app.salsabeelistore.shop` is not covered by the existing wildcard certificate, obtain a new certificate for it.

**Explanation:** This step sets up the foundational network and server configuration to distinguish between central and tenant requests.

---

### **Step 2: Separate User Models & Migrations**

**Goal:** Create distinct `User` models and tables for central (Developer) and tenant users, as per the PRD.

**Actions Required:**
1.  **Rename Central User Model:** Rename `app/Models/User.php` to `app/Models/CentralUser.php`.
2.  **Update Central User Migration:** Rename `database/migrations/0001_01_01_000000_create_users_table.php` to `..._create_central_users_table.php` and modify it to create a `central_users` table.
3.  **Create Tenant User Model:** Create a new `app/Models/User.php` (this will be the tenant user model).
4.  **Create Tenant User Migration:** Create a new tenant migration (`php artisan make:migration create_users_table --tenant`) to create a `users` table in each tenant's database.
5.  **Adjust Relationships:** Update any existing models that reference `App\Models\User` to either `App\Models\CentralUser` or the new `App\Models\User` based on context.

**Explanation:** This is a fundamental architectural change, ensuring that developer accounts are stored separately from tenant accounts, preventing cross-database authentication issues.

---

### **Step 3: Implement Central Authentication**

**Goal:** Set up a dedicated authentication system for Developer users on `app.salsabeelistore.shop`.

**Actions Required:**
1.  **Update `config/auth.php`:**
    -   Define a new authentication guard (e.g., `central_web`) and provider (e.g., `central_users`) that uses the `App\Models\CentralUser` model.
    -   Set `defaults.guard` to `central_web` for central routes.
2.  **Create Central Auth Routes:** Create a new `routes/central_auth.php` file for login/logout/register routes specific to `app.salsabeelistore.shop`.
3.  **Create Central Auth Controller:** Create `app/Http/Controllers/CentralAuthController.php` to handle central user login/logout.
4.  **Update `App\Models\CentralUser`:** Implement `Authenticatable` contract.

**Explanation:** This creates a completely separate login flow for developers, ensuring they authenticate against the central database.

---

### **Step 4: Implement Tenant Authentication**

**Goal:** Ensure tenant users authenticate against their respective tenant databases, accessed via `tenantX.salsabeelistore.shop`.

**Actions Required:**
1.  **Update `config/auth.php`:**
    -   Define a new authentication guard (e.g., `tenant_web`) and provider (e.g., `tenant_users`) that uses the `App\Models\User` (tenant user) model.
    -   Set `defaults.guard` to `tenant_web` for tenant routes.
2.  **Update `App\Models\User` (Tenant User):** Implement `Authenticatable` contract.
3.  **Modify `routes/tenant.php`:** Ensure all tenant-specific authentication routes (from `auth.php`) use the `tenant_web` guard.

**Explanation:** This ensures that when a user logs into a tenant subdomain, Laravel uses the correct guard and provider to authenticate them against that tenant's database.

---

### **Step 5: Refactor Tenant Registration Flow**

**Goal:** Align the tenant registration process with the new domain structure and user separation.

**Actions Required:**
1.  **Update `TenantRegistrationController.php`:**
    -   Ensure it's accessible only on `app.salsabeelistore.shop`.
    -   Modify user creation to use the new `App\Models\User` (tenant user) model within the tenant context.
    -   Ensure the redirect after registration is to `https://tenantX.salsabeelistore.shop/login`.

**Explanation:** This ensures that new tenants are correctly created, their databases are set up, and their initial Super Admin user is created in the correct tenant database, with the correct redirect.

---

### **Step 6: Refactor Dashboard Redirections**

**Goal:** Redirect users to the correct dashboard based on their role and the domain they logged in from.

**Actions Required:**
1.  **Update `LoginController` (or equivalent):**
    -   For central login, redirect developers to `app.salsabeelistore.shop/developer/dashboard`.
    -   For tenant login, redirect Super Admins to `tenantX.salsabeelistore.shop/dashboard`.
    -   For tenant Admins/Staff, redirect to `tenantX.salsabeelistore.shop/admin/dashboard`.
2.  **Update `navigation.blade.php`:** Adjust links and role checks to match the new dashboard structure and user roles.

**Explanation:** This ensures a seamless user experience, directing each user to their appropriate starting point after authentication.

---

### **Step 7: Update Seeders and Factories**

**Goal:** Ensure all seeders and factories create users in the correct context (central vs. tenant) and with correct roles.

**Actions Required:**
1.  **Update `DatabaseSeeder.php`:**
    -   Ensure it only calls seeders relevant to the central database (e.g., `RoleSeeder`, `DeveloperSuperAdminSeeder` for `CentralUser`).
2.  **Update `DeveloperSuperAdminSeeder.php`:**
    -   Modify to create `App\Models\CentralUser` instead of `App\Models\User`.
3.  **Create Tenant Seeders:** Create new seeders (e.g., `TenantDatabaseSeeder.php`) to be run within the tenant context, creating default roles and users for each tenant.
4.  **Adjust Factories:** Update `UserFactory.php` to work with `App\Models\User` (tenant user) and create a `CentralUserFactory.php` for central users.

**Explanation:** This ensures that test data and initial users are created in the correct databases and with the appropriate models.

---

### **Step 8: Clean Up & Verification**

**Goal:** Remove temporary code and thoroughly test the entire system.

**Actions Required:**
1.  Remove `TenantTestController.php` and the `/verify-tenancy` route from `routes/tenant.php`.
2.  Thoroughly test:
    -   Central Developer login/dashboard.
    -   Tenant registration.
    -   Tenant Super Admin login/dashboard.
    -   Tenant Admin/Staff login/dashboard.
    -   Data isolation between tenants.

**Explanation:** This final step ensures the system is clean, functional, and meets all PRD requirements.
