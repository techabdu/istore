# 🧭 iStore Build Plan — planning.md

## 🤖 LLM USAGE GUIDE

### Rules/Notes for LLM Agents:
- Always review this file before starting any coding session.
- Update progress by marking `[x]` when a step is completed.
- Follow the commit message instructions after each checkpoint.
- Maintain consistent code style and folder structure.
- Push commits regularly to ensure sync between models and humans.
- limit code changes to minimum.

---

### How to Use
1. **Always begin by reading this file.**
   - Check which steps are completed (`[x]`) and which remain (`[ ]`).
2. **Continue from the first incomplete step.**
   - Follow all substeps and checkpoints carefully.
3. **After completing a step:**
   - Mark it as `[x]`.
   - Add the corresponding commit message from the checkpoint section.
4. **Never skip a checkpoint.**
   - Every checkpoint corresponds to a Git commit stage.
5. **If you switch to another LLM,**
   - Ask it to read this file and continue from the last unchecked step.

---

### Purpose
This file serves as a **persistent build plan** for the iStore multi-tenant web app.  
It allows any LLM (ChatGPT, Gemini, Claude, etc.) to:
- Understand the entire project’s architecture and progress.
- Resume development **exactly where the previous session stopped**.
- Follow structured checklists and checkpoints for Git commits.

---

## 📘 PROJECT OVERVIEW

**App Name:** iStore  
**Tech Stack:** Laravel + Livewire + Alpine.js + TailwindCSS  
**Multi-Tenancy:** `stancl/tenancy`  
**Hosting:** Hostinger  
**DB:** MySQL  
**Pattern:** MVC  
**Purpose:** Multi-tenant store management system for phone shops (inventory, sales, finance, users).  

---

## 🏁 PROJECT INITIALIZATION

### 1. Setup Project Environment
- [x] Initialize Git repository (`git init`).
- [x] Push initial commit to GitHub.

**Checkpoint #1:**  
Commit → `chore: initialize laravel project and setup git`

---

### 2. Install Core Dependencies
- [x] Install `livewire/livewire`.
- [x] Install `alpinejs` via CDN or Vite.
- [x] Install and configure TailwindCSS.
- [x] Install `stancl/tenancy` for multi-tenancy.
- [x] Install `barryvdh/laravel-dompdf` for PDF invoices.
- [x] Install `laravel/breeze` or `laravel/fortify` for authentication.
- [x] Run all migrations successfully.

**Checkpoint #2:**  
Commit → `feat: installed dependencies and verified setup`

---

### 3. Setup Multi-Tenancy
- [x] Configure `stancl/tenancy` according to docs.
- [x] Create **central database** for global tables (tenants, users, etc.).
- [x] Setup **tenant database** creation logic.
- [x] Update `.env` and `config/tenancy.php` for dynamic DB connections.
- [x] Create migration for `tenants` table in the central DB.
- [x] Test tenant creation manually via tinker.

**Checkpoint #3:**  
Commit → `feat: setup stancl/tenancy and tenant db isolation`

---

## ⚙️ SYSTEM ARCHITECTURE SETUP

### 4. Define Models & Migrations (Central)
- [x] Model: `Tenant` (full_name, business_name, business_capital, address, phone_number, status).
- [x] Model: `User` (name, email, password, role, tenant_id nullable).
- [x] Add seeders for Developer Super Admin.
- [x] Setup default `SuperAdmin`, `Admin`, and `Developer` roles.

**Checkpoint #4:**  
Commit → `feat: defined central models and roles`

---

### 5. Define Models & Migrations (Tenant)
Each tenant DB contains:
- [x] `products` — id, name, category, ram, imei, storage, condition, purchase_price, selling_price, status, date.
- [x] `sales` — id, product_id, total_price, date.
- [x] `expenses` — id, title, description, amount, date.
- [x] `finances` — id, total_asset, total_expenses, total_debt, total_cash, capital, profit.
- [x] `invoices` — id, sale_id, invoice_number.

**Checkpoint #5:**  
Commit → `feat: added tenant models and migrations`

---

### 6. Authentication Flow
- [x] Configure Laravel Breeze/Fortify.
- [x] Setup login/register routes for developer and tenants.
- [x] Implement middleware for role-based access.
- [x] Create route guards for Developer Dashboard and Tenant Dashboards.

**Checkpoint #6:**  
Commit → `feat: authentication flow and role middleware`

---

## 🏗️ CORE FUNCTIONAL MODULES

### 7. Developer Dashboard (Root Super Admin)
- [x] Create `DeveloperController` + Livewire components.
- [x] Pages:
  - [x] View all tenants.
  - [x] Approve / suspend tenants.
  - [x] Delete tenants.
  - [ ] Access tenant analytics summary.
- [x] UI: Clean admin layout using TailwindCSS + Livewire.
- [x] Integrate data tables (search, filter, pagination).

**Checkpoint #7:**  
Commit → `feat: developer dashboard with tenant management`

---

### 8. Tenant Registration System
- [x] Create `TenantRegistrationController`.
- [x] Build registration form (Full Name, company name, business capital, address, phone number, admin email, password).
- [x] On registration, system auto-creates:
  - [x] Tenant DB (via `stancl/tenancy`).
  - [x] Tenant Super Admin user.
- [x] Redirect to tenant dashboard after registration.

**Checkpoint #8:**  
Commit → `feat: tenant registration flow with auto db creation`

---

### 9. Tenant Dashboard (Super Admin / Admin)
- [x] Build dashboard layout (company name in navbar).
- [x] Dashboard metrics: total sales, total expenses, stock count, profit summary.
- [x] Create separate navigation menus for:
  - [x] Super Admin (finance, users, reports)
  - [x] Admin (inventory, sales, invoices)
- [x] Add user role-based visibility for menu items.

**Checkpoint #9:**  
Commit → `feat: tenant dashboard layout and metrics`

---

## 🧩 MODULE IMPLEMENTATIONS

### 10. Inventory Management Module
- [x] CRUD for products using Livewire components.
- [x] Include category, price fields.
- [x] Implement low-stock indicator.
- [x] UI: simple data table with search/filter.

**Checkpoint #10:**  
Commit → `feat: inventory management module`

---

### 11. Sales Management Module
- [x] Create Livewire component for new sales.
- [x] Select product, → auto-calculate total.
- [x] Update inventory status after sale.
- [x] Generate PDF invoice via DomPDF.
- [x] Display recent sales list.

**Checkpoint #11:**  
Commit → `feat: sales management with PDF invoice`

---

### 12. Finance Management Module
- [x] Record business capital, total debt, total cash, total expenses, total asset.
- [x] Auto-calculate profit: (total asset + total cash + total debt - total expenses - business capital).
- [x] Display summary dashboard.
- [x] Enable filtering by date range.

**Checkpoint #12:**  
Commit → `feat: finance module with auto profit calculation`

---

### 13. User Management (Tenant Super Admin)
- [x] CRUD for tenant users.
- [x] Assign roles: Admin or Super Admin.
- [x] Option to reset password or deactivate user.
- [x] Use Livewire modals for create/edit.

**Checkpoint #13:**  
Commit → `feat: tenant user management`

---

### 14. Reports Module
- [ ] Generate monthly sales report.
- [ ] Display top-selling products.
- [ ] Export reports as PDF.
- [ ] Finance summary chart (use Livewire chart library).

**Checkpoint #14:**  
Commit → `feat: reports module with charts`

---

## 🧰 INFRASTRUCTURE & DEPLOYMENT

### 15. Testing & QA
- [ ] Create test tenants.
- [ ] Test role-based permissions.
- [ ] Test database isolation.
- [ ] Test invoice generation and finance updates.
- [ ] Test Livewire interactivity.

**Checkpoint #15:**  
Commit → `test: verified core functionalities`

---

### 16. Deployment to Hostinger
- [ ] Upload project files.
- [ ] Configure `.env` for production DB.
- [ ] Run migrations for central DB.
- [ ] Test tenant registration and dashboard live.
- [ ] Secure file permissions and storage link.

**Checkpoint #16:**  
Commit → `deploy: istore MVP to hostinger`

---

## 📦 FINALIZATION

### 17. Documentation
- [ ] update `README.md` (project overview, setup, tech stack).
- [ ] Include this `planning.md` in repo root.
- [ ] Document environment variables.
- [ ] Add contribution and deployment notes.

**Checkpoint #17:**  
Commit → `docs: added readme and planning.md`

---

## 🧩 FUTURE PHASES (Not MVP)
- [ ] Custom domain per tenant (`companyname.istore.com`)
- [ ] CSV import/export for inventory.
- [ ] Email/SMS notifications.
- [ ] Visual analytics dashboard.
- [ ] Automated backups.
- [ ] Audit logs.

---

## ✅ COMPLETION
Once all boxes above are checked and committed to GitHub:
> **Project Status:** MVP Complete  
> **Next Step:** Begin feature expansion or UI polishing phase.

---