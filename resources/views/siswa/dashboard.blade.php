@extends('layouts.app')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
        Selamat Datang, {{ $siswa->nama }} 🎉
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="flex items-center justify-center p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <i class=" fas fa-check-circle"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Kehadiran
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $persentase['hadir'] }}%
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                        (dari {{ $totalAbsensi }} hari)
                    </span>
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="flex items-center justify-center p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <i class="w-4 fas fa-band-aid"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Sakit
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                     {{ $persentase['sakit'] }}%
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                        (dari {{ $totalAbsensi }} hari)
                    </span>
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="flex items-center justify-center p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <i class="w-4 fas fa-file-alt"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Izin
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                     {{ $persentase['izin'] }}%
                     <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                        (dari {{ $totalAbsensi }} hari)
                    </span>
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 rounded-lg shadow-xs dark:bg-gray-800">
            <div class="flex items-center justify-center p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:bg-red-500">
                <i class=" fas fa-heart-crack dark:text-black"></i>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Alpa
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                     {{ $persentase['alpa'] }}%
                     <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                        (dari {{ $totalAbsensi }} hari)
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
                Jadwal Pelajaran Hari Ini
            </h3>
            <div class="w-full overflow-x-auto bg-white dark:bg-gray-800">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Jam</th>
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Guru</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($jadwalHariIni as $jadwal)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold">
                                {{ $jadwal->mapel->nama ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $jadwal->guru->nama ?? 'N/A' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-center">Tidak ada jadwal pelajaran hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
             <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
                Nilai Terbaru
            </h3>
            <div class="w-full overflow-x-auto bg-white dark:bg-gray-800">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Jenis Ujian</th>
                            <th class="px-4 py-3">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                         @forelse ($nilaiTerbaru as $nilai)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm font-semibold">
                                {{ $nilai->mapel->nama ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $nilai->jenis_ujian }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $nilai->nilai }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-center dark:text-gray-300">Belum ada nilai yang diinput.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
            Tugas / To-Do List Terbaru
        </h3>
        <div class="p-4 bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                @forelse ($todoList as $todo)
                    <li>
                        <a href="{{ route('siswa.todolist.index') }}" class="flex items-start p-4 transition-colors duration-150 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-900 dark:border-gray-700">
                            <div class="flex items-center h-5 mt-1">
                                @if ($todo->selesai)
                                    <i class="w-5 h-5 text-green-500 fas fa-check-circle"></i>
                                @else
                                    <i class="w-5 h-5 text-purple-600 fas fa-circle"></i>
                                @endif
                            </div>
                            <div class="w-full ml-3 text-sm">
                                <div class="flex items-center justify-between">
                                     <h4 class="font-semibold {{ $todo->selesai ? 'text-gray-500 line-through dark:text-gray-400' : 'text-gray-800 dark:text-gray-200' }}">
                                        {{ $todo->judul ?? 'Judul Tugas' }}
                                    </h4>
                                    <span class="px-2 py-1 text-xs font-medium leading-none text-purple-600 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-600">
                                        {{ $todo->mapel->nama ?? 'Umum' }}
                                    </span>
                                </div>

                                <p class="mt-1 text-gray-600 dark:text-gray-400 {{ $todo->selesai ? 'line-through' : '' }}">
                                    {{ Str::limit($todo->deskripsi ?? $todo->tugas, 150) }}
                                </p>

                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Dibuat: {{ $todo->created_at->format('d M Y') }}</span>
                                    @if($todo->deadline)
                                        <span class="mx-1">·</span>
                                        <span>Deadline: <span class="font-medium text-red-500">{{ \Carbon\Carbon::parse($todo->deadline)->format('d M Y') }}</span></span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada tugas saat ini. Selamat!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection