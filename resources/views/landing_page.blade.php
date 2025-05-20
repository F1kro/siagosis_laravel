<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAGOSIS - Sistem Informasi Akademik Sekolah</title>
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
    <!-- Navbar -->
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
                    <a href="{{ Auth::check()
                    ? (Auth::user()->role === 'admin'
                        ? route('admin.dashboard')
                        : (Auth::user()->role === 'guru'
                            ? route('guru.dashboard')
                            : (Auth::user()->role === 'siswa'
                                ? route('siswa.dashboard')
                                : route('default.dashboard'))))
                    : route('login') }}"
                    class="px-4 py-2 text-white transition rounded-md bg-primary hover:bg-secondary">{{ Auth::check() ? 'Dashboard' : 'Login' }}</a>
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

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden px-4 pb-3 transition-colors duration-300 bg-white md:hidden dark:bg-gray-800">
            <a href="#features" class="block py-2 text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Fitur</a>
            <a href="#about" class="block py-2 text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Tentang</a>
            <a href="#testimoni" class="block py-2 text-gray-700 transition dark:text-gray-300 hover:text-primary dark:hover:text-primary-dark">Testimoni</a>
            <a href="{{ Auth::check()
                    ? (Auth::user()->role === 'admin'
                        ? route('admin.dashboard')
                        : (Auth::user()->role === 'guru'
                            ? route('guru.dashboard')
                            : (Auth::user()->role === 'siswa'
                                ? route('siswa.dashboard')
                                : route('default.dashboard'))))
                    : route('login') }}" class="block px-4 py-2 mt-2 text-center text-white transition rounded-md bg-primary dark:bg-primary-dark hover:bg-secondary dark:hover:bg-secondary-dark">{{ Auth::check() ? 'Dashboard' : 'Login' }}</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-20 overflow-hidden text-white hero-gradient md:pt-32 md:pb-28">
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute w-64 h-64 bg-blue-300 rounded-full blob dark:bg-blue-900 -top-20 -left-20"></div>
            <div class="absolute bg-blue-400 rounded-full blob dark:bg-blue-800 w-80 h-80 bottom-10 right-10"></div>
        </div>

        <div class="relative z-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 md:grid-cols-2">
                <div class="animate-fade-in">
                    <h1 class="mb-6 text-4xl font-bold leading-tight md:text-5xl">
                        Sistem Informasi Akademik <span class="text-yellow-300">Modern</span> untuk Sekolah
                    </h1>
                    <p class="mb-8 text-lg md:text-xl opacity-90">
                        Kelola data siswa, guru, nilai, dan administrasi sekolah dengan mudah dan efisien.
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('login') }}" class="px-6 py-3 font-semibold text-center transition bg-white rounded-lg shadow-lg text-primary dark:text-primary-dark hover:bg-gray-100 dark:hover:bg-gray-200">
                            Mulai Sekarang
                        </a>
                        <a href="#features" class="px-6 py-3 font-semibold text-center text-white transition border-2 border-white rounded-lg hover:bg-white hover:bg-opacity-10">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <img src="{{ asset('storage/Assets/siswa_belajar.jpg') }}" alt="Siswa Belajar" class="w-full h-auto max-w-md mx-auto rounded-lg animation-float">
                    <div class="absolute w-24 h-24 bg-yellow-300 rounded-full -bottom-8 -left-8 dark:bg-yellow-600 opacity-20"></div>
                    <div class="absolute w-20 h-20 bg-blue-200 rounded-full -top-8 -right-8 dark:bg-blue-700 opacity-20"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 transition-colors duration-300 bg-white dark:bg-gray-800">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Fitur Unggulan SIAGOSIS</h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">Solusi lengkap untuk manajemen sekolah modern</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-lg dark:bg-blue-900 text-primary dark:text-primary-dark">
                        <i class="text-2xl fas fa-users"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Manajemen Siswa</h3>
                    <p class="text-gray-600 dark:text-gray-300">Kelola data siswa, presensi, dan perkembangan akademik secara terpusat dan real-time.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-green-600 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-400">
                        <i class="text-2xl fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Manajemen Guru</h3>
                    <p class="text-gray-600 dark:text-gray-300">Pantau jadwal mengajar, beban kerja, dan kinerja guru dengan sistem terintegrasi.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-purple-600 bg-purple-100 rounded-lg dark:bg-purple-900 dark:text-purple-400">
                        <i class="text-2xl fas fa-book"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Nilai & Rapor Digital</h3>
                    <p class="text-gray-600 dark:text-gray-300">Input nilai, generate rapor, dan analisis perkembangan siswa secara otomatis.</p>
                </div>

                <!-- Feature 4 -->
                <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-yellow-600 bg-yellow-100 rounded-lg dark:bg-yellow-900 dark:text-yellow-400">
                        <i class="text-2xl fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Jadwal Pelajaran</h3>
                    <p class="text-gray-600 dark:text-gray-300">Buat dan kelola jadwal pelajaran dengan sistem yang fleksibel dan mudah disesuaikan.</p>
                </div>

                <!-- Feature 5 -->
                <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-red-600 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-400">
                        <i class="text-2xl fas fa-chart-line"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Analisis Data</h3>
                    <p class="text-gray-600 dark:text-gray-300">Laporan statistik dan visualisasi data untuk pengambilan keputusan berbasis data.</p>
                </div>

                <!-- Feature 6 -->
                <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center justify-center w-16 h-16 mb-6 text-indigo-600 bg-indigo-100 rounded-lg dark:bg-indigo-900 dark:text-indigo-400">
                        <i class="text-2xl fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Akses Mobile</h3>
                    <p class="text-gray-600 dark:text-gray-300">Akses sistem melalui smartphone kapan saja dan di mana saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 transition-colors duration-300 bg-gray-50 dark:bg-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 md:grid-cols-2">
                <div class="relative">
                    <img src="{{ asset('storage/Assets/guru_mengajar.jpg') }}" alt="Guru Mengajar" class="w-full h-auto max-w-md mx-auto rounded-lg animation-float-reverse">
                    <div class="absolute w-24 h-24 bg-blue-100 rounded-full -bottom-8 -left-8 dark:bg-blue-800 opacity-20"></div>
                    <div class="absolute w-20 h-20 bg-yellow-200 rounded-full -top-8 -right-8 dark:bg-yellow-600 opacity-20"></div>
                </div>
                <div>
                    <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Tentang SIAGOSIS</h2>
                    <p class="mb-6 text-lg text-gray-600 dark:text-gray-300">
                        SIAGOSIS adalah Sistem Informasi Akademik Sekolah yang dikembangkan untuk memenuhi kebutuhan manajemen sekolah di era digital.
                    </p>
                    <p class="mb-8 text-lg text-gray-600 dark:text-gray-300">
                        Dengan antarmuka yang intuitif dan fitur lengkap, SIAGOSIS membantu sekolah meningkatkan efisiensi administrasi dan kualitas pembelajaran.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <i class="mr-2 text-green-500 fas fa-check-circle"></i>
                            <span class="text-gray-700 dark:text-gray-300">User Friendly</span>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-green-500 fas fa-check-circle"></i>
                            <span class="text-gray-700 dark:text-gray-300">Cloud Based</span>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-green-500 fas fa-check-circle"></i>
                            <span class="text-gray-700 dark:text-gray-300">Real-time Data</span>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-green-500 fas fa-check-circle"></i>
                            <span class="text-gray-700 dark:text-gray-300">Multi-user</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section id="testimoni" class="py-20 transition-colors duration-300 bg-white dark:bg-gray-800">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Apa Kata Mereka?</h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">Testimoni dari pengguna SIAGOSIS</p>
            </div>

            <div class="grid gap-8 md:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="p-8 transition-colors duration-300 border border-gray-100 bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-12 h-12 mr-4 text-blue-600 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-400">
                            <i class="text-xl fas fa-user-tie"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Dr. Budi Santoso</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Kepala Sekolah SMA N 1 Jakarta</p>
                        </div>
                    </div>
                    <p class="italic text-gray-600 dark:text-gray-300">
                        "SIAGOSIS sangat membantu kami dalam manajemen data akademik. Sistemnya mudah digunakan dan fiturnya sangat lengkap."
                    </p>
                    <div class="mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="p-8 transition-colors duration-300 border border-gray-100 bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-12 h-12 mr-4 text-purple-600 bg-purple-100 rounded-full dark:bg-purple-900 dark:text-purple-400">
                            <i class="text-xl fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Siti Aminah</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Guru Matematika</p>
                        </div>
                    </div>
                    <p class="italic text-gray-600 dark:text-gray-300">
                        "Input nilai jadi lebih mudah dan cepat. Saya bisa fokus mengajar tanpa terbebani administrasi yang rumit."
                    </p>
                    <div class="mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="p-8 transition-colors duration-300 border border-gray-100 bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-12 h-12 mr-4 text-green-600 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-400">
                            <i class="text-xl fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Andi Wijaya</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Orang Tua Siswa</p>
                        </div>
                    </div>
                    <p class="italic text-gray-600 dark:text-gray-300">
                        "Sekarang saya bisa memantau perkembangan anak saya secara real-time melalui portal orang tua. Sangat membantu!"
                    </p>
                    <div class="mt-4 text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 text-white transition-colors duration-300 bg-primary dark:bg-primary-dark">
        <div class="px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
            <h2 class="mb-6 text-3xl font-bold md:text-4xl">Siap Mengubah Manajemen Sekolah Anda?</h2>
            <p class="max-w-3xl mx-auto mb-8 text-xl opacity-90">
                Daftarkan sekolah Anda sekarang dan rasakan kemudahan mengelola akademik dengan SIAGOSIS.
            </p>
            <a href="{{ route('register') }}" class="inline-block px-8 py-3 text-lg font-semibold transition bg-white rounded-lg shadow-lg text-primary dark:text-primary-dark hover:bg-gray-100 dark:hover:bg-gray-200">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 text-gray-300 transition-colors duration-300 bg-gray-900">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-4">
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-white">SIAGOSIS</h3>
                    <p class="mb-4">
                        Sistem Informasi Akademik Sekolah modern untuk manajemen pendidikan yang lebih baik.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 transition hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 transition hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
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
                        <li class="flex items-center">
                            <i class="mr-2 fas fa-map-marker-alt"></i>
                            <span>Jl. Pendidikan No. 1, Jakarta</span>
                        </li>
                        <li class="flex items-center">
                            <i class="mr-2 fas fa-phone-alt"></i>
                            <span>(021) 12345678</span>
                        </li>
                        <li class="flex items-center">
                            <i class="mr-2 fas fa-envelope"></i>
                            <span>info@siagosis.sch.id</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 text-lg font-semibold text-white">Newsletter</h3>
                    <p class="mb-4">Dapatkan update terbaru tentang SIAGOSIS</p>
                    <form class="flex">
                        <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 text-gray-900 rounded-l-lg">
                        <button type="submit" class="px-4 py-2 bg-blue-600 rounded-r-lg hover:bg-blue-700">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="pt-8 mt-8 text-center border-t border-gray-800">
                <p>&copy; 2023 SIAGOSIS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed items-center justify-center hidden w-12 h-12 text-white transition-colors duration-300 rounded-full shadow-lg bottom-8 right-8 bg-primary dark:bg-primary-dark">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Mobile Menu Script -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Back to top button
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

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Dark mode toggle
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