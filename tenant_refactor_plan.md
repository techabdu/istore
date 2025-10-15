# 📝 Tenant Dashboard & Data Isolation Refactor Plan

This document outlines the steps to verify tenant data isolation and build the specified tenant dashboard structure.

---

### ✅ Plan & Progress

- [ ] **Step 1: Verify Tenancy Initialization**
- [ ] **Step 2: Create Placeholder Pages & Routes**
- [ ] **Step 3: Update Tenant Navigation Bar**
- [ ] **Step 4: Final Cleanup**

---

### 📖 Step Details

---

### **Step 1: Verify Tenancy Initialization**

**Goal:** To prove that when a user visits a tenant's subdomain, the application automatically connects to that tenant's specific database, ensuring data is always separate.

**Action Required (by Me):**
1.  Create a temporary test route `/verify-tenancy` in `routes/tenant.php`.
2.  Create a new `TenantTestController` with a method that returns the current `tenant()->id` and the name of the current database connection (`DB::connection()->getDatabaseName()`).

**Explanation:** By visiting `tenant1.salsabeelistore.shop/verify-tenancy`, we expect to see a response showing Tenant 1's ID and the name of Tenant 1's database (e.g., `tenant1`). This will give us 100% confidence that data isolation is working as designed before we build the UI.

---

### **Step 2: Create Placeholder Pages & Routes**

**Goal:** To create the basic files for the pages you requested: Manage Users, Manage Finance, and Activity Log.

**Action Required (by Me):**
1.  Create three new Blade view files with simple placeholder content (e.g., `<h1>Manage Users</h1>`):
    - `resources/views/tenant/users/index.blade.php`
    - `resources/views/tenant/finance/index.blade.php`
    - `resources/views/tenant/activity_log/index.blade.php`
2.  Update the `routes/tenant.php` file to add new routes (`/users`, `/finance`, `/activity-log`) that point to these new views.

**Explanation:** This step builds the empty pages that we will link to from the main navigation.

---

### **Step 3: Update Tenant Navigation Bar**

**Goal:** To change the main navigation bar to show only the links you specified.

**Action Required (by Me):**
1.  Read the `resources/views/layouts/navigation.blade.php` file.
2.  Remove the existing tenant navigation links.
3.  Add the new set of links using the `<x-nav-link>` component:
    - `Dashboard`
    - `Manage Users`
    - `Manage Finance`
    - `Activity Log`

**Explanation:** This will update the user interface to match your exact requirements for the tenant dashboard.

---

### **Step 4: Final Cleanup**

**Goal:** To remove the temporary test route and controller created in Step 1.

**Action Required (by Me):**
1.  Remove the `/verify-tenancy` route from `routes/tenant.php`.
2.  Delete the `app/Http/Controllers/TenantTestController.php` file.

**Explanation:** This keeps the codebase clean and removes our temporary test code after we have confirmed everything works.
