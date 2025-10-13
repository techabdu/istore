# ⚛️ React/Next.js Frontend Integration Plan

## Goal:
Rebuild the iStore landing page using React with Next.js, and integrate authentication (login and tenant registration) with the existing Laravel backend API.

## Steps:

### 1. Next.js Project Setup
- [ ] **1.1. Initialize Next.js Application:** Create a new Next.js project within the Laravel root directory (e.g., `istore/frontend`).
  ```bash
  npx create-next-app frontend --typescript --eslint --tailwind --app --src-dir --use-pnpm
  ```
- [ ] **1.2. Configure Laravel for Next.js:**
  - [ ] Update `.env` to define `FRONTEND_URL` (e.g., `http://localhost:3000`).
  - [ ] Configure CORS in `config/cors.php` to allow requests from the Next.js frontend.
  - [ ] Optionally, set up a proxy in Laravel (e.g., using `nginx` or `apache` configuration, or a Laravel package) to serve the Next.js build from a subpath or subdomain, or configure Next.js to proxy API requests to Laravel.

### 2. Landing Page Development (React Components)
- [ ] **2.1. Translate Design to React Components:** Convert the `welcome.blade.php` design into reusable React components.
  - [ ] `components/Navbar.tsx`
  - [ ] `components/HeroSection.tsx`
  - [ ] `components/FeaturesSection.tsx`
  - [ ] `components/ShowcaseSection.tsx`
  - [ ] `components/PricingSection.tsx`
  - [ ] `components/TestimonialsSection.tsx`
  - [ ] `components/CtaSection.tsx`
  - [ ] `components/Footer.tsx`
- [ ] **2.2. Main Page (`app/page.tsx`):** Assemble all components into the main landing page.
- [ ] **2.3. Styling:** Ensure Tailwind CSS is correctly configured and used for all styling, maintaining the premium, clean, and mobile-responsive design.
- [ ] **2.4. Interactivity:** Implement smooth scrolling and other dynamic elements using React state and props, replacing Alpine.js functionality.

### 3. API Integration (Authentication)
- [ ] **3.1. Laravel API Endpoints:**
  - [ ] Ensure Laravel has API routes for login (e.g., `/api/login`) and tenant registration (e.g., `/api/tenant-register`). These should return JSON responses.
  - [ ] Modify `app/Http/Controllers/Auth/AuthenticatedSessionController.php` and `app/Http/Controllers/TenantRegistrationController.php` to return JSON responses for API requests.
- [ ] **3.2. React Login Page (`app/login/page.tsx`):
  - [ ] Create a login form component.
  - [ ] Handle form submission: send `email` and `password` to Laravel's `/api/login` endpoint.
  - [ ] On successful login: Store authentication token (e.g., in `localStorage` or `cookies`), redirect to the appropriate dashboard based on user role.
  - [ ] On login failure: Display error messages.
- [ ] **3.3. React Tenant Registration Page (`app/register-tenant/page.tsx`):
  - [ ] Create a tenant registration form component.
  - [ ] Handle form submission: send all required fields (full_name, business_name, email, password, etc.) to Laravel's `/api/tenant-register` endpoint.
  - [ ] On successful registration: Redirect to the tenant's specific login page (e.g., `http://[subdomain].localhost/login`).
  - [ ] On registration failure: Display error messages.

### 4. Routing
- [ ] **4.1. Next.js Routing:** Configure `next.config.js` for any necessary rewrites or redirects, especially for API calls to Laravel.
- [ ] **4.2. Laravel Web Routes:** Ensure Laravel's web routes (`routes/web.php`) are configured to serve the Next.js application for the root (`/`) and other relevant frontend routes.

### 5. Deployment Considerations
- [ ] **5.1. Build Process:** Document the process to build the Next.js application (`pnpm build`).
- [ ] **5.2. Serving:** Explain how to serve the Next.js build (e.g., using `serve` package, or integrating into Laravel's public directory and configuring web server).

## Checkpoints:
- [ ] Next.js project initialized and basic setup complete.
- [ ] Landing page components created and assembled.
- [ ] Login functionality integrated with Laravel API.
- [ ] Tenant registration functionality integrated with Laravel API.
- [ ] All routing configured.
- [ ] Deployment strategy outlined.
