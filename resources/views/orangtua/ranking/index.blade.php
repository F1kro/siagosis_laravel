@extends('layouts.app')
@section('title', 'Peringkat Akademik Anak')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Peringkat Akademik: {{ $siswa->nama }}
    </h2>

    <div class="grid w-full gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($riwayatRanking as $ranking)
            <div class="flex flex-col p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="mb-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tahun Ajaran {{ $ranking->tahun_ajaran }}</p>
                    <h3 class="text-xl font-bold text-purple-600 capitalize dark:text-purple-400">
                        Semester {{ $ranking->semester }}
                    </h3>
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                        Kelas: {{ $ranking->kelas->nama_kelas ?? 'N/A' }}
                    </p>
                </div>

                <div class="flex-grow space-y-4">
                    <div class="flex items-baseline justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Peringkat di Kelas</span>
                        <div class="text-right">
                             <span class="text-2xl font-extrabold text-gray-800 dark:text-gray-100">#{{ $ranking->ranking_kelas }}</span>
                             <span class="text-sm text-gray-500 dark:text-gray-400">/ {{ $ranking->total_siswa_di_kelas }} siswa</span>
                        </div>
                    </div>
                    @if($ranking->ranking_angkatan)
                    <div class="flex items-baseline justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Peringkat di Angkatan</span>
                        <span class="text-lg font-bold text-gray-700 dark:text-gray-200">#{{ $ranking->ranking_angkatan }}</span>
                    </div>
                    @endif
                </div>

                <div class="pt-4 mt-4 text-sm border-t dark:border-gray-700">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Total Nilai:</span>
                        <span class="font-semibold text-gray-700 dark:text-gray-200">{{ number_format($ranking->total_nilai, 2) }}</span>
                    </div>
                     <div class="flex justify-between mt-1">
                        <span class="text-gray-500 dark:text-gray-400">Rata-rata:</span>
                        <span class="font-semibold text-gray-700 dark:text-gray-200">{{ number_format($ranking->rata_rata_nilai, 2) }}</span>
                    </div>
                </div>
            </div>
        @empty
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                Peringkat Ananda belum tersedia saat ini, silahkan cek lagi setelah pembagian raport.
            </p>
        </div>
        @endforelse
    </div>
</div>
@endsection