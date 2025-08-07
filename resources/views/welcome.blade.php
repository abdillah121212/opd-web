<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* CSS Tailwind yang ada tetap dipertahankan */
                /* ... [CSS Tailwind yang ada] ... */
            </style>
        @endif

        <!-- Style tambahan untuk landing page -->
        <style>
            .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://source.unsplash.com/random/1600x900/?technology');
                background-size: cover;
                background-position: center;
            }
            .dark .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://source.unsplash.com/random/1600x900/?technology,dark');
            }
            .feature-card {
                transition: all 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .dark .feature-card {
                background-color: #1e293b;
            }
            .dark .feature-card:hover {
                box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- Dark Mode Toggle -->
        <button id="theme-toggle" type="button" class="fixed top-4 right-4 z-50 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center">
                            <i class="fas fa-rocket text-blue-600 dark:text-blue-400 text-2xl mr-2"></i>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">{{ config('app.name', 'MyApp') }}</span>
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Welcome to {{ config('app.name', 'Our Application') }}</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">A simple and powerful solution for your business needs. Get started today and experience the difference.</p>
                <div class="space-x-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg inline-block">Get Started</a>
                    @endif
                    <a href="#features" class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-600 dark:text-white font-bold py-3 px-6 rounded-lg text-lg inline-block">Learn More</a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-white dark:bg-gray-800 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Key Features</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="feature-card bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                        <div class="text-blue-600 dark:text-blue-400 text-4xl mb-4">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Fast Performance</h3>
                        <p class="text-gray-600 dark:text-gray-300">Optimized for speed and efficiency to give you the best user experience.</p>
                    </div>
                    <div class="feature-card bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                        <div class="text-blue-600 dark:text-blue-400 text-4xl mb-4">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Secure & Reliable</h3>
                        <p class="text-gray-600 dark:text-gray-300">Built with security in mind to protect your data and privacy.</p>
                    </div>
                    <div class="feature-card bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                        <div class="text-blue-600 dark:text-blue-400 text-4xl mb-4">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900 dark:text-white">Easy to Use</h3>
                        <p class="text-gray-600 dark:text-gray-300">Intuitive interface designed for users of all skill levels.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 bg-gray-100 dark:bg-gray-700 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Ready to get started?</h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto text-gray-700 dark:text-gray-300">Join thousands of satisfied users today.</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg text-lg inline-block">Sign Up for Free</a>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 dark:bg-gray-900 text-white py-8 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">{{ config('app.name', 'MyApp') }}</h3>
                        <p class="text-gray-400">The best solution for your business needs.</p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-white">Features</a></li>
                            @if (Route::has('login'))
                                <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white">Login</a></li>
                            @endif
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Legal</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Connect With Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'MyApp') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

        <!-- Dark Mode Script -->
        <script>
            // Check for saved theme preference or use system preference
            const userTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Initial theme check
            const themeCheck = () => {
                if (userTheme === 'dark' || (!userTheme && systemTheme)) {
                    document.documentElement.classList.add('dark');
                    document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
                    document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.getElementById('theme-toggle-light-icon').classList.add('hidden');
                    document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
                }
            };
            
            // Manual theme switch
            const themeSwitch = () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    document.getElementById('theme-toggle-light-icon').classList.add('hidden');
                    document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
                    document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
                }
            };
            
            // Call theme check on initial load
            themeCheck();
            
            // Event listener for theme toggle button
            document.getElementById('theme-toggle').addEventListener('click', themeSwitch);
            
            // Watch for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    if (e.matches) {
                        document.documentElement.classList.add('dark');
                        document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
                        document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
                    } else {
                        document.documentElement.classList.remove('dark');
                        document.getElementById('theme-toggle-light-icon').classList.add('hidden');
                        document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
                    }
                }
            });
        </script>
    </body>
</html>