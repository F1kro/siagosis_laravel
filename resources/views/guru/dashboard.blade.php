@extends('layouts.app')

@section('content')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang,{{ $guru->jenis_kelamin === 'Laki-laki' ? ' Pak ' : 'Bu ' }} {{ $name }} 🎉🎉
        </h2>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm font-bold text-gray-600 dark:text-gray-400">
                Mari kita bangun SDM Indonesia lebih unggul dengan SIAGOSIS (Sistem Informasi Akademik Guru,Siswa,OrangTua)
                🔥🔥
            </p>
        </div>

        <!-- Cards -->
        <h2 class="mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Data Guru
        </h2>
        <div class="grid gap-6 mb-4 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card: Total Siswa yang Diajar -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Siswa yang Diajar
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalSiswa }}
                    </p>
                </div>
            </div>

            <!-- Card: Total Kelas yang Diajar -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Kelas Wali
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalKelas }}
                    </p>
                </div>
            </div>

            <!-- Card: Total Mata Pelajaran -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Mata Pelajaran
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalMapel }}
                    </p>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-3 text-base font-semibold text-gray-700 dark:text-gray-200">
                    Jadwal Hari Ini ({{ \Carbon\Carbon::now()->locale('id_ID')->isoFormat('dddd') }})
                </h4>
                @if ($jadwalHariIni && $jadwalHariIni->isNotEmpty())
                    <div class="space-y-3 text-sm">
                        @foreach ($jadwalHariIni as $jadwal)
                            <div class="pb-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                <p class="font-semibold text-gray-800 dark:text-gray-300">
                                    {{ $jadwal->mapel->nama ?? 'Mapel Tidak Tersedia' }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Waktu:</span> {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Kelas:</span> {{ $jadwal->kelas->nama_kelas ?? 'Kelas Tidak Tersedia' }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Ruangan:</span> {{ $jadwal->ruangan ?? '-' }}
                                </p>
                                {{-- <p class="text-xs mt-1 text-gray-500 dark:text-gray-300">
                                    T.A: {{ $jadwal->tahun_ajaran ?? '-' }} | Semester: {{ $jadwal->semester ?? '-' }}
                                </p> --}}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Tidak ada jadwal mengajar untuk hari ini.
                    </p>
                @endif
            </div>

        </div>

        </div>

        <!-- Info Sekolah -->
        <h2 class="mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Info Sekolah & Berita Terbaru
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <!-- Info Sekolah -->
            <div class="min-w-0 p-6 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Info Sekolah</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1 font-medium text-gray-600 dark:text-gray-400">Nama: SMK NEGERI 1 LOPOK</div>
                        <div class="col-span-1 font-medium text-gray-600 dark:text-gray-400">Letak: Jl. Pendidikan No. 1,
                            Jakarta Pusat</div>
                        <div class="col-span-1 font-medium text-gray-600 dark:text-gray-400">Akreditasi: A (Unggul)</div>
                        <div class="col-span-1 font-medium text-gray-600 dark:text-gray-400">Kepala Sekolah: Dr. Surya
                            Wijaya, M.Pd</div>
                        <div class="col-span-1 font-medium text-gray-600 dark:text-gray-400">Telp: (021) 12345678</div>
                        <div class="col-span-1 font-medium text-gray-600 dark:text-gray-400">Email: info@sman1-jkt.sch.id
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <div class="min-w-0 p-6 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Berita Terbaru</h3>
                <div class="space-y-4">
                    @foreach ($recentBerita as $berita)
                        <div class="p-4 border rounded-lg dark:border-gray-700">
                            <div class="flex items-center mb-2">
                                <span
                                    class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-200">
                                    {{ $berita->kategori }}
                                </span>
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $berita->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h5 class="mb-1 font-medium text-gray-800 dark:text-gray-200">{{ $berita->judul }}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($berita->isi, 100) }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('guru.berita.index') }}"
                        class="text-sm font-medium text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300">
                        Lihat semua berita →
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
