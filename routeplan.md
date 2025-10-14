# 🗺️ Route and Access Control Plan

## Goal:
Implement strict role-based access control to prevent unauthorized users from accessing dashboards or routes not assigned to their role, both in central and tenant contexts.

## Steps:

### 1. Review Current Route Definitions
- [x] **1.1. Examine `routes/web.php`:** Understand how central routes (especially for Developer and general dashboard) are defined and middleware applied.
- [x] **1.2. Examine `routes/tenant.php`:** Understand how tenant-specific routes are defined and middleware applied.

### 2. Enhance Role Middleware Logic
- [x] **2.1. Refine `app/Http/Middleware/RoleMiddleware.php`:** Ensure the middleware correctly handles scenarios where a user might be authenticated but attempts to access a route outside their assigned role(s).
  - [x] Consider adding a check for the current domain context (central vs. tenant) within the middleware if necessary to differentiate access.

### 3. Implement Strict Route Grouping and Protection
- [x] **3.1. Central Developer Routes (`routes/web.php`):
  - [x] Ensure all developer-specific routes are within a dedicated group with `auth` and `role:Developer` middleware.
  - [x] Prevent access to these routes if the user is in a tenant context.
- [x] **3.2. Central SuperAdmin/Admin Routes (`routes/web.php`):
  - [x] Ensure central dashboard routes are protected by `auth` and appropriate `role` middleware (e.g., `role:SuperAdmin`).
- [x] **3.3. Tenant Routes (`routes/tenant.php`):
  - [x] Ensure all tenant-specific routes are within a group that initializes tenancy and applies `auth` middleware.
  - [x] Apply specific `role` middleware (e.g., `role:SuperAdmin`, `role:Admin`) to tenant routes as required.
  - [x] Prevent access to tenant routes if the user is a central user (e.g., Developer) and not associated with the current tenant.

### 4. Unauthorized Access Redirection
- [x] **4.1. Modify `RoleMiddleware` or `Exception Handler`:** Implement a clear redirection strategy for unauthorized access attempts.
  - [x] If a Developer tries to access a tenant dashboard, redirect them to their developer dashboard or a 403 page.
  - [x] If a Tenant user tries to access a central dashboard (like `/developer/dashboard`), redirect them to their tenant dashboard or a 403 page.
  - [x] Ensure the `abort(403)` calls are handled gracefully.

### 5. Verification & Testing
- [ ] **5.1. Test Developer Access:**
  - [ ] Log in as Developer. Verify access to `/developer/dashboard` and `/developer/tenants`.
  - [ ] Attempt to access `/dashboard` (central SuperAdmin dashboard). Verify redirection or 403.
  - [ ] Attempt to access a tenant dashboard (e.g., `tenant1.localhost/dashboard`). Verify redirection or 403.
- [ ] **5.2. Test Tenant SuperAdmin Access:**
  - [ ] Log in as a Tenant SuperAdmin. Verify access to `tenant_domain/dashboard`.
  - [ ] Attempt to access `/developer/dashboard`. Verify redirection or 403.
  - [ ] Attempt to access another tenant's dashboard (if possible). Verify redirection or 403.
- [ ] **5.3. Test Tenant Admin Access:**
  - [ ] Log in as a Tenant Admin. Verify access to `tenant_domain/admin/dashboard`.
  - [ ] Attempt to access `tenant_domain/dashboard` (SuperAdmin dashboard). Verify redirection or 403.
  - [ ] Attempt to access `/developer/dashboard`. Verify redirection or 403.

## Checkpoints:
- [ ] Current route definitions reviewed.
- [ ] Role middleware logic enhanced.
- [ ] Strict route grouping and protection implemented.
- [ ] Unauthorized access redirection handled.
- [ ] All verification tests passed.
