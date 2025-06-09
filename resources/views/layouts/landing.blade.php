<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAGOSIS - Sistem Informasi Akademik Sekolah')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#2563eb',
                            dark: '#3b82f6'
                        },
                        secondary: {
                            DEFAULT: '#1e40af',
                            dark: '#1e3a8a'
                        },
                        accent: '#3b82f6',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-reverse': 'float-reverse 5s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        'float-reverse': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        .dark .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .dark .feature-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .blob {
            filter: blur(60px);
            opacity: 0.2;
        }
        .dark .blob {
            opacity: 0.15;
        }
    </style>
</head>
<body class="transition-colors duration-300 font-poppins bg-gray-50 dark:bg-gray-900">
    <nav class="fixed z-50 w-full transition-colors duration-300 bg-white shadow-sm dark:bg-gray-800">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex items-center flex-shrink-0">
                        <i class="mr-2 text-2xl fas fa-graduation-cap text-primary dark:text-primary-dark"></i>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">SIAGOSIS</span>
                    </div>
                </div>
                <div class="items-center hidden space-x-8 md:flex">
                    <a href="#features" class="text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Fitur</a>
                    <a href="#about" class="text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Tentang</a>
                    <a href="#testimoni" class="text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Testimoni</a>
                    <button id="theme-toggle" class="text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="hidden fas fa-sun dark:block"></i>
                    </button>
                    <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'guru' ? route('guru.dashboard') : (Auth::user()->role === 'siswa' ? route('siswa.dashboard') : route('default.dashboard')))) : route('login') }}" class="px-4 py-2 text-white transition rounded-md bg-primary hover:bg-secondary">{{ Auth::check() ? 'Dashboard' : 'Login' }}</a>
                </div>
                <div class="flex items-center space-x-4 md:hidden">
                    <button id="theme-toggle-mobile" class="text-gray-700 dark:text-gray-300">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="hidden fas fa-sun dark:block"></i>
                    </button>
                    <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-300">
                        <i class="text-xl fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden px-4 pb-3 transition-colors duration-300 bg-white md:hidden dark:bg-gray-800">
            <a href="#features" class="block py-2 text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Fitur</a>
            <a href="#about" class="block py-2 text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Tentang</a>
            <a href="#testimoni" class="block py-2 text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Testimoni</a>
            <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'guru' ? route('guru.dashboard') : (Auth::user()->role === 'siswa' ? route('siswa.dashboard') : route('default.dashboard')))) : route('login') }}" class="block px-4 py-2 mt-2 text-center text-white transition rounded-md bg-primary dark:bg-primary-dark hover:bg-secondary dark:hover:bg-secondary-dark">{{ Auth::check() ? 'Dashboard' : 'Login' }}</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-12 text-gray-300 transition-colors duration-300 bg-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-4">
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-white">SIAGOSIS</h3>
                    <p class="mb-4">
                        Sistem Informasi Akademik Sekolah modern untuk manajemen pendidikan yang lebih baik.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 transition hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 transition hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 transition hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-white">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="transition hover:text-white">Fitur</a></li>
                        <li><a href="#about" class="transition hover:text-white">Tentang</a></li>
                        <li><a href="#testimoni" class="transition hover:text-white">Testimoni</a></li>
                        <li><a href="{{ route('login') }}" class="transition hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-white">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center"><i class="mr-2 fas fa-map-marker-alt"></i><span>Jl. Pendidikan No. 1, Jakarta</span></li>
                        <li class="flex items-center"><i class="mr-2 fas fa-phone-alt"></i><span>(021) 12345678</span></li>
                        <li class="flex items-center"><i class="mr-2 fas fa-envelope"></i><span>info@siagosis.sch.id</span></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-white">Newsletter</h3>
                    <p class="mb-4">Dapatkan update terbaru tentang SIAGOSIS</p>
                    <form class="flex">
                        <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 text-gray-900 rounded-l-lg">
                        <button type="submit" class="px-4 py-2 bg-blue-600 rounded-r-lg hover:bg-blue-700"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            <div class="pt-8 mt-8 text-center border-t border-gray-800">
                <p>&copy; 2025 SIAGOSIS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <button id="back-to-top" class="fixed items-center justify-center hidden w-12 h-12 text-white transition-colors duration-300 rounded-full shadow-lg bottom-8 right-8 bg-primary dark:bg-primary-dark">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
                backToTopButton.classList.add('flex');
            } else {
                backToTopButton.classList.add('hidden');
                backToTopButton.classList.remove('flex');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        const themeToggle = document.getElementById('theme-toggle');
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', toggleTheme);
        }

        if (themeToggleMobile) {
            themeToggleMobile.addEventListener('click', toggleTheme);
        }
    </script>
</body>
</html>