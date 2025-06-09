@extends('layouts.landing')

@section('content')

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

<section id="features" class="py-20 transition-colors duration-300 bg-white dark:bg-gray-800">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-16 text-center">
            <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Fitur Unggulan SIAGOSIS</h2>
            <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">Solusi lengkap untuk manajemen sekolah modern</p>
        </div>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                <div class="flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-lg dark:bg-blue-900 text-primary dark:text-primary-dark">
                    <i class="text-2xl fas fa-users"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Manajemen Siswa</h3>
                <p class="text-gray-600 dark:text-gray-300">Kelola data siswa, presensi, dan perkembangan akademik secara terpusat dan real-time.</p>
            </div>
            <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                <div class="flex items-center justify-center w-16 h-16 mb-6 text-green-600 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-400">
                    <i class="text-2xl fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Manajemen Guru</h3>
                <p class="text-gray-600 dark:text-gray-300">Pantau jadwal mengajar, beban kerja, dan kinerja guru dengan sistem terintegrasi.</p>
            </div>
            <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                <div class="flex items-center justify-center w-16 h-16 mb-6 text-purple-600 bg-purple-100 rounded-lg dark:bg-purple-900 dark:text-purple-400">
                    <i class="text-2xl fas fa-book"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Nilai & Rapor Digital</h3>
                <p class="text-gray-600 dark:text-gray-300">Input nilai, generate rapor, dan analisis perkembangan siswa secara otomatis.</p>
            </div>
            <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                <div class="flex items-center justify-center w-16 h-16 mb-6 text-yellow-600 bg-yellow-100 rounded-lg dark:bg-yellow-900 dark:text-yellow-400">
                    <i class="text-2xl fas fa-calendar-alt"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Jadwal Pelajaran</h3>
                <p class="text-gray-600 dark:text-gray-300">Buat dan kelola jadwal pelajaran dengan sistem yang fleksibel dan mudah disesuaikan.</p>
            </div>
            <div class="p-8 transition-all duration-300 border border-gray-100 feature-card bg-gray-50 dark:bg-gray-700 rounded-xl dark:border-gray-600">
                <div class="flex items-center justify-center w-16 h-16 mb-6 text-red-600 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-400">
                    <i class="text-2xl fas fa-chart-line"></i>
                </div>
                <h3 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">Analisis Data</h3>
                <p class="text-gray-600 dark:text-gray-300">Laporan statistik dan visualisasi data untuk pengambilan keputusan berbasis data.</p>
            </div>
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

<section id="testimoni" class="py-20 transition-colors duration-300 bg-white dark:bg-gray-800">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-16 text-center">
            <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl dark:text-white">Apa Kata Mereka?</h2>
            <p class="max-w-2xl mx-auto text-lg text-gray-600 dark:text-gray-300">Testimoni dari pengguna SIAGOSIS</p>
        </div>
        <div class="grid gap-8 md:grid-cols-3">
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
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
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
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
            </div>
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
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
</section>

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
@endsection