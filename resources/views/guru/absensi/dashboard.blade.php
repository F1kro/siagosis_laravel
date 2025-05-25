@extends('layouts.app')

@section('title', 'Pilih Kelas Absensi')

@section('content')

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang🎓, {{ Auth::user()->name ?? 'Guru' }}
        </h2>

        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('guru.dashboard') }}" class="hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('guru.absensi.dashboard') }}" class="hover:underline">Pilih Kelas Absensi</a>
            </p>
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">
                Kelas yang Anda Ajar
            </h3>
            @if ($kelasDiajar->isNotEmpty())
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($kelasDiajar as $kelas)
                        <a href="{{ route('guru.absensi.index', ['kelas_id' => $kelas->id]) }}"
                           class="flex items-center p-4 transition-shadow duration-200 rounded-lg shadow-xs bg-gray-50 dark:bg-gray-800 hover:shadow-lg">
                            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-lg dark:text-orange-100 dark:bg-orange-500">
                                <i class="w-5 h-5 fas fa-book fa-fw"></i>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Kelas yang diajar:
                                </p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $kelas->nama_kelas }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Mata Pelajaran: {{ $kelas->pivot->mapel->nama ?? 'N/A' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">Anda tidak mengajar kelas mana pun.</p>
            @endif

            <h3 class="my-4 text-lg font-semibold text-gray-700 dark:text-gray-200">
                Kelas Wali Anda
            </h3>
            @if ($kelasWali->isNotEmpty())
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($kelasWali as $kelas)
                        <a href="{{ route('guru.absensi.index', ['kelas_id' => $kelas->id]) }}"
                           class="flex items-center p-4 transition-shadow duration-200 rounded-lg shadow-xs bg-gray-50 dark:bg-gray-800 hover:shadow-lg">
                            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-lg dark:text-green-100 dark:bg-green-500">
                                <i class="w-5 h-5 fas fa-chalkboard-teacher fa-fw"></i>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                    Kelas Wali:
                                </p>
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $kelas->nama_kelas }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">Anda tidak menjadi wali kelas mana pun.</p>
            @endif
        </div>
    </div>
@endsection