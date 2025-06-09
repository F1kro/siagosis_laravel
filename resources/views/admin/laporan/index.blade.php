@extends('layouts.app')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Menu Laporan
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Data Siswa
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Melihat daftar semua siswa terdaftar.
                    </p>
                    <a href="{{ route('admin.laporan.siswa') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Data Guru
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Melihat daftar semua guru yang diampu.
                    </p>
                    <a href="{{ route('admin.laporan.guru') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Data Orang Tua
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Melihat daftar orang tua siswa.
                    </p>
                    <a href="{{ route('admin.laporan.orangtua') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Nilai
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Rekap nilai siswa per mata pelajaran.
                    </p>
                    <a href="{{ route('admin.laporan.nilai') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Absensi
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Rekap absensi siswa per kelas.
                    </p>
                    <a href="{{ route('admin.laporan.absensi') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Jadwal Pelajaran
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Melihat jadwal pelajaran per kelas.
                    </p>
                    <a href="{{ route('admin.laporan.jadwal') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Peringkat Siswa
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Peringkat siswa berdasarkan nilai rata-rata.
                    </p>
                    <a href="{{ route('admin.laporan.ranking') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-blue">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Data Mata Pelajaran
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Daftar semua mata pelajaran tersedia.
                    </p>
                    <a href="{{ route('admin.laporan.mapel') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-blue">
                        Lihat Laporan
                    </a>
                </div>
            </div>

            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div>
                    <p class="mb-2 font-semibold text-gray-600 dark:text-gray-400">
                        Laporan Data User
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Manajemen pengguna sistem.
                    </p>
                    <a href="{{ route('admin.laporan.user') }}" class="inline-block px-3 py-1 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-blue">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection