@extends('layouts.app')
@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
        Selamat Datang, {{ $orangtua->nama }}
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="flex items-center justify-center p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <i class="w-5 h-5 fas fa-user-graduate"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Anak Terhubung
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $siswa->nama }} (Kelas: {{ $siswa->kelas->nama_kelas ?? 'N/A' }})
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="flex items-center justify-center p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <i class="w-5 h-5 fas fa-chart-pie"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Persentase Kehadiran
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $persentaseHadir }}%
                </p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 mb-8 lg:grid-cols-2">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <i class="mr-2 fas fa-calendar-check"></i> Absensi Ananda Hari Ini
            </h3>
            <div class="p-4 bg-white dark:bg-gray-800">
                <ul class="space-y-3">
                    @forelse ($absensiHariIni as $absen)
                        <li class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="mr-3 font-mono text-sm text-gray-500 dark:text-gray-400">{{ $absen->waktu ? \Carbon\Carbon::parse($absen->waktu)->format('H:i') : '' }}</span>
                                <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $absen->mapel->nama ?? 'N/A' }}</span>
                            </div>
                            @if(strtolower($absen->status) == 'hadir')
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Hadir</span>
                            @elseif(strtolower($absen->status) == 'sakit')
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">Sakit</span>
                            @elseif(strtolower($absen->status) == 'izin')
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:text-white dark:bg-blue-600">Izin</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">Alpa</span>
                            @endif
                        </li>
                    @empty
                        <li class="text-center text-gray-500">Belum ada data absensi untuk hari ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <i class="mr-2 fas fa-star"></i> 5 Nilai Terbaru Ananda
            </h3>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Jenis Nilai</th>
                            <th class="px-4 py-3 text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                         @forelse ($nilaiTerbaru as $nilai)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm font-semibold">{{ $nilai->mapel->nama ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $nilai->jenis_nilai }}</td>
                            <td class="px-4 py-3 text-lg font-semibold text-center">
                                <span class="px-3 py-1 rounded-full {{ $nilai->nilai >= 75 ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100' : 'text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700' }}">
                                    {{ $nilai->nilai }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-10 text-center text-gray-500">Belum ada nilai yang diinput.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="w-full mb-6 overflow-hidden rounded-lg shadow-xs">
        <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
           <i class="mr-2 fas fa-newspaper"></i> Berita & Info Sekolah
       </h3>
       <div class="p-4 bg-white dark:bg-gray-800">
           <div class="space-y-4">
               @forelse ($beritaTerbaru as $berita)
                   <div class="pb-2 border-b dark:border-gray-700">
                       <p class="mb-1 font-semibold text-gray-800 dark:text-gray-200">{{ $berita->judul }}</p>
                       <p class="text-xs text-gray-500 dark:text-gray-400">{{ $berita->waktu_relatif }}</p>
                   </div>
               @empty
                   <div class="text-center text-gray-500">Tidak ada berita terbaru.</div>
               @endforelse
           </div>
       </div>
   </div>
</div>
@endsection