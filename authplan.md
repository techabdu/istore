# 🔐 Authentication & Authorization Plan — authplan.md

## 🤖 LLM USAGE GUIDE

### Rules/Notes for LLM Agents:
- Always review this file before starting any coding session related to authentication.
- Update progress by marking `[x]` when a step is completed.
- Follow the commit message instructions after each checkpoint.
- Maintain consistent code style and folder structure.
- Push commits regularly to ensure sync between models and humans.
- Limit code changes to minimum.

---

### How to Use
1. **Always begin by reading this file.**
   - Check which steps are completed (`[x]`) and which remain (`[ ]`).
2. **Continue from the first incomplete step.**
   - Follow all substeps and checkpoints carefully.
3. **After completing a step:**
   - Mark it as `[x]` in this file.
   - Add the corresponding commit message from the checkpoint section.
4. **Never skip a checkpoint.**
   - Every checkpoint corresponds to a Git commit stage.
5. **If you switch to another LLM,**
   - Ask it to read this file and continue from the last unchecked step.

---

## 📘 AUTHENTICATION OVERVIEW

**Goal:** Implement a robust, role-based authentication and redirection system for a multi-tenant Laravel application.

**Key Components:**
- **Central Login:** Single entry point for all users (Developer, SuperAdmin, Admin).
- **Role-Based Redirection:** Users are redirected to specific dashboards based on their assigned role.
- **Tenant Creation Link:** Accessible from the central login/registration area.

**Roles & Dashboards:**
- **Developer Role:** Redirects to `/developer/dashboard`. Manages all tenants.
- **SuperAdmin Role (Tenant-specific):** Redirects to `/tenant/dashboard` (or `tenant_domain/dashboard`). Manages tenant users, shop activities, finances.
- **Admin Role (Tenant-specific):** Redirects to `/tenant/admin/dashboard` (or `tenant_domain/admin/dashboard`). Manages inventory, sales, invoices (shop activity).

---

## 🏁 AUTHENTICATION IMPLEMENTATION PLAN

### 1. Initial Setup & User Creation

- [x] **1.1. Verify Role Existence:** Ensure 'developer', 'superadmin', and 'admin' roles exist in the `roles` table (central DB).
  - [x] *Check:* `SELECT * FROM roles;`
- [x] **1.2. Create Developer User:** Manually insert a user into the central `users` table with the 'developer' role.
  - [x] *Details:* Email: `developer@example.com`, Password: `password` (hashed), `role_id` corresponding to 'developer' role.
  - [x] *Action:* Provide SQL/Tinker command for user to execute.

**Checkpoint #1:**
Commit → `feat: initial auth setup and developer user creation`

---

### 2. Central Registration Page Enhancements

- [x] **2.1. Remove Default Role Assignment:** Remove the 'SuperAdmin' default role assignment from `app/Http/Controllers/Auth/RegisteredUserController.php`. New central registrations should not automatically get a role.
- [x] **2.2. Add Tenant Registration Link:** Add a prominent link on the central login/registration page (`resources/views/auth/login.blade.php` or `resources/views/auth/register.blade.php`) to `route('tenant.register')`.

**Checkpoint #2:**
Commit → `feat: central registration page updated`

---

### 3. Role-Based Login Redirection

- [x] **3.1. Modify `AuthenticatedSessionController`:** Update `app/Http/Controllers/Auth/AuthenticatedSessionController.php` to implement role-based redirection after successful central login.
  - [x] If `userRole->name` is 'developer', redirect to `route('developer.dashboard')`.
  - [x] If `userRole->name` is 'superadmin', redirect to `route('dashboard')` (central SuperAdmin dashboard).
  - [x] If `userRole->name` is 'admin', redirect to `route('dashboard')` (central Admin dashboard - *Note: This will be refined for tenant context later*).
  - [x] Default redirection to `route('dashboard')`.

**Checkpoint #3:**
Commit → `feat: role-based login redirection implemented`

---

### 4. Tenant-Specific Admin Dashboard

- [x] **4.1. Create Tenant Admin Dashboard Route:** Define a new route in `routes/tenant.php` for the tenant admin dashboard.
  - [x] *Route:* `Route::get('/admin/dashboard', function () { return view('tenant.admin.dashboard'); })->middleware(['auth', 'verified', 'role:Admin'])->name('tenant.admin.dashboard');`
- [x] **4.2. Create Tenant Admin Dashboard View:** Create `resources/views/tenant/admin/dashboard.blade.php`.
  - [x] *Content:* A simple view indicating "Welcome to the Tenant Admin Dashboard!".
- [x] **4.3. Update `AuthenticatedSessionController` for Tenant Admin:** Refine the 'admin' role redirection in `app/Http/Controllers/Auth/AuthenticatedSessionController.php` to redirect to `route('tenant.admin.dashboard')` *if* the user is logging into a tenant domain.
  - [x] *Note:* This step requires careful handling of tenant context within the central login controller, or ensuring tenant admins only log in via tenant domains. A simpler approach might be to ensure tenant admins *only* log in via tenant domains, and the central login only handles central users. For now, we'll assume central login handles central users, and tenant login handles tenant users.

**Checkpoint #4:**
Commit → `feat: tenant admin dashboard and redirection`

---

### 5. Verification & Testing

- [x] **5.1. Test Developer Login:**
  - [x] Log in with `developer@example.com`.
  - [x] Verify redirection to `/developer/dashboard` and correct content.
- [x] **5.2. Test Central SuperAdmin Login:**
  - [x] Register a new user (will be SuperAdmin by default).
  - [x] Log in with new SuperAdmin credentials.
  - [x] Verify redirection to `/dashboard` (central SuperAdmin dashboard) and correct content.
- [x] **5.3. Test Tenant Registration & SuperAdmin Login:**
  - [x] Register a new tenant via `route('tenant.register')`.
  - [x] Log in as the tenant SuperAdmin (created during tenant registration).
  - [x] Verify redirection to `tenant_domain/dashboard` and correct content.
- [x] **5.4. Test Tenant Admin Login:**
  - [x] Create an 'admin' user within a tenant (via tenant SuperAdmin dashboard).
  - [x] Log in as the tenant Admin.
  - [x] Verify redirection to `tenant_domain/admin/dashboard` and correct content.

**Checkpoint #5:**
Commit → `test: authentication and redirection flows verified`

---

## ✅ COMPLETION
Once all boxes above are checked and committed to GitHub:
> **Authentication Status:** Implemented and Verified
> **Next Step:** Continue with other project modules or refine existing features.

---
