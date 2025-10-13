<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iStore - Run Your Phone Shop Like a Pro.</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8faff; /* Clean white background with subtle blue tint */
        }
        .navbar-sticky {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .fade-in-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300" x-data="{ scrolled: false }" x-init="document.addEventListener('scroll', () => { scrolled = (window.scrollY > 50); })" :class="{ 'navbar-sticky': scrolled }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-3xl font-extrabold text-indigo-600 font-mono">iStore</a>
                </div>
                <div class="flex items-center">
                    <a href="#features" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Features</a>
                    <a href="#pricing" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Pricing</a>
                    <a href="{{ route('login') }}" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Login</a>
                    <a href="{{ route('tenant.register') }}" class="ml-4 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">Get Started</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <main>
        <!-- Hero Section -->
        <section class="relative flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-20 overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-30" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTMyIDY0QzUwLjgyMjkgNjQgNjQgNDkuODIyOSA2NCAzMkM2NCAxMy4xNzcxIDQ5LjgyMjkgMCAzMiAwQzEzLjE3NzEgMCAwIDEzLjE3NzEgMCAzMkMwIDQ5LjgyMjkgMTMuMTc3MSA2NCAzMiA2NFoiIGZpbGw9InVybCgjcGFpbnQwX2xpbmVhcl8xXzI2KSIvPgo8ZGVmcy1wYWludCBpZD0icGFpbnQwX2xpbmVhcl8xXzI2Ij4KPHN0b3Agc3RvcC1jb2xvcj0iI0Q5RUZGRiIvPgo8c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNFNkYwRkYiLz4KPC9kZWZzPgo8L3N2Zz4='); background-size: 30px; opacity: 0.5;"></div>
            <div class="relative z-10 max-w-4xl mx-auto text-center px-4">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight mb-6 text-gray-900">
                    Run Your Phone Shop <span class="text-indigo-600">Like a Pro.</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-700 mb-10 max-w-2xl mx-auto">
                    Manage inventory, sales, and finances — all in one intuitive dashboard. iStore simplifies your business operations.
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('tenant.register') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-full shadow-lg transition ease-in-out duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                        Get Started Free
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white hover:bg-gray-100 text-indigo-600 border border-indigo-600 font-bold rounded-full shadow-lg transition ease-in-out duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                        Watch Demo
                    </a>
                </div>
                <!-- Mockup Placeholder -->
                <div class="mt-16">
                    <img src="https://via.placeholder.com/1000x600/E0E7FF/4F46E5?text=iStore+Dashboard+Mockup" alt="iStore Dashboard Mockup" class="rounded-lg shadow-2xl mx-auto border border-gray-200">
                </div>
            </div>
        </section>
        <!-- End Hero Section -->

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-12">Features Designed for Your Success</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="p-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M17 16l4-4m-4 0l-4 4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Inventory Tracking</h3>
                        <p class="text-gray-600">Keep precise tabs on all your phone models, accessories, and stock levels.</p>
                    </div>
                    <!-- Feature Card 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="p-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Smart Sales & Invoicing</h3>
                        <p class="text-gray-600">Streamline your sales process and generate professional invoices effortlessly.</p>
                    </div>
                    <!-- Feature Card 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="p-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Profit Analytics</h3>
                        <p class="text-gray-600">Gain insights into your store's performance with detailed profit and loss analytics.</p>
                    </div>
                    <!-- Feature Card 4 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="p-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Multi-Shop Management</h3>
                        <p class="text-gray-600">Manage multiple phone shop locations from a single, centralized iStore account.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Features Section -->

        <!-- Showcase Section -->
        <section class="py-20 bg-gray-50" x-data="{ visible: false }" x-intersect.once="visible = true">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-12">See iStore in Action</h2>
                <div class="relative w-full max-w-5xl mx-auto fade-in-on-scroll" :class="{ 'is-visible': visible }">
                    <img src="https://via.placeholder.com/1200x700/C3DAFE/1A202C?text=iStore+Dashboard+Preview" alt="iStore Dashboard Preview" class="rounded-lg shadow-2xl border border-gray-200">
                    <div class="absolute inset-0 rounded-lg ring-4 ring-indigo-500 ring-opacity-50 pointer-events-none"></div>
                </div>
            </div>
        </section>
        <!-- End Showcase Section -->

        <!-- Pricing Section -->
        <section id="pricing" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-12">Simple & Transparent Pricing</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Pricing Card 1: Starter -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 transform hover:scale-105 transition-transform duration-300">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Starter</h3>
                        <p class="text-gray-600 mb-6">Perfect for new phone shops.</p>
                        <div class="text-5xl font-extrabold text-indigo-600 mb-6">$29<span class="text-xl font-medium text-gray-500">/month</span></div>
                        <ul class="text-gray-700 mb-8 space-y-3">
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>1 Store Location</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Basic Inventory</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Sales Tracking</li>
                        </ul>
                        <a href="{{ route('tenant.register') }}" class="block w-full px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-full shadow-md transition ease-in-out duration-300">Start Free Trial</a>
                    </div>
                    <!-- Pricing Card 2: Pro (Highlighted) -->
                    <div class="bg-indigo-600 p-8 rounded-xl shadow-2xl border-4 border-indigo-400 transform scale-105 transition-transform duration-300 relative z-10">
                        <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-md">Most Popular</span>
                        <h3 class="text-2xl font-bold text-white mb-4">Pro</h3>
                        <p class="text-indigo-100 mb-6">For growing phone shop businesses.</p>
                        <div class="text-5xl font-extrabold text-white mb-6">$59<span class="text-xl font-medium text-indigo-200">/month</span></div>
                        <ul class="text-white mb-8 space-y-3">
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-yellow-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Up to 5 Store Locations</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-yellow-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Advanced Inventory</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-yellow-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Profit Analytics</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-yellow-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Priority Support</li>
                        </ul>
                        <a href="{{ route('tenant.register') }}" class="block w-full px-8 py-3 bg-white hover:bg-indigo-100 text-indigo-600 font-bold rounded-full shadow-md transition ease-in-out duration-300">Start Free Trial</a>
                    </div>
                    <!-- Pricing Card 3: Business -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 transform hover:scale-105 transition-transform duration-300">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Business</h3>
                        <p class="text-gray-600 mb-6">Enterprise-grade solution for large chains.</p>
                        <div class="text-5xl font-extrabold text-indigo-600 mb-6">$99<span class="text-xl font-medium text-gray-500">/month</span></div>
                        <ul class="text-gray-700 mb-8 space-y-3">
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Unlimited Locations</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Custom Integrations</li>
                            <li class="flex items-center justify-center"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>Dedicated Support</li>
                        </ul>
                        <a href="{{ route('tenant.register') }}" class="block w-full px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-full shadow-md transition ease-in-out duration-300">Start Free Trial</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Pricing Section -->

        <!-- Testimonials Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-12">What Our Users Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial Card 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/80x80" alt="Avatar" class="w-20 h-20 rounded-full mb-4 border-4 border-indigo-200">
                        <p class="text-gray-700 italic mb-4">"iStore transformed how we manage our inventory. It's incredibly intuitive and powerful!"</p>
                        <p class="font-semibold text-indigo-600">Jane Doe, <span class="text-gray-500">Doe's Phones</span></p>
                    </div>
                    <!-- Testimonial Card 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/80x80" alt="Avatar" class="w-20 h-20 rounded-full mb-4 border-4 border-indigo-200">
                        <p class="text-gray-700 italic mb-4">"Sales tracking and invoicing used to be a nightmare. iStore made it a breeze!"</p>
                        <p class="font-semibold text-indigo-600">John Smith, <span class="text-gray-500">Smith Mobile</span></p>
                    </div>
                    <!-- Testimonial Card 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/80x80" alt="Avatar" class="w-20 h-20 rounded-full mb-4 border-4 border-indigo-200">
                        <p class="text-gray-700 italic mb-4">"Managing multiple shops is now seamless. iStore is a game-changer for our business."</p>
                        <p class="font-semibold text-indigo-600">Emily White, <span class="text-gray-500">Global Gadgets</span></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Testimonials Section -->

        <!-- CTA Section -->
        <section class="py-20 bg-indigo-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-white mb-8">
                    Join hundreds of phone stores growing with iStore.
                </h2>
                <a href="{{ route('tenant.register') }}" class="inline-flex items-center justify-center px-12 py-4 border border-transparent text-base font-bold rounded-full shadow-sm text-indigo-600 bg-white hover:bg-indigo-50 transition ease-in-out duration-300 transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50">
                    Create Your Free Account
                </a>
            </div>
        </section>
        <!-- End CTA Section -->
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-4 mb-4">
                <a href="#" class="hover:text-white transition-colors duration-200">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors duration-200">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors duration-200">Contact Us</a>
            </div>
            <p>&copy; 2025 techabdu. All rights reserved.</p>
        </div>
    </footer>
    <!-- End Footer -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-on-scroll').forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html>
