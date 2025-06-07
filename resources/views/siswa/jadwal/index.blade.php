@extends('layouts.app')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Jadwal Pelajaran Kelas {{ $siswa->kelas->nama_kelas ?? '' }}
    </h2>

    @if ($jadwalSiswa->isNotEmpty())
        @foreach ($jadwalSiswa as $hari => $jadwalsPadaHariIni)
            <div class="mb-8">
                <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300">
                    {{ $hari }}
                </h3>

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead class="hidden md:table-header-group">
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Waktu</th>
                                    <th class="px-4 py-3">Mata Pelajaran</th>
                                    <th class="px-4 py-3">Guru Pengajar</th>
                                    <th class="px-4 py-3">Ruangan</th>
                                    <th class="px-4 py-3">T.A./Semester</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($jadwalsPadaHariIni->sortBy('jam_mulai') as $jadwal)
                                <tr class="flex flex-col px-4 py-3 text-gray-700 border-b md:table-row dark:border-gray-700 dark:text-gray-400">
                                    <td class="flex justify-between py-1 md:table-cell md:py-3 md:px-4 md:text-sm">
                                        <span class="font-semibold md:hidden">Waktu</span>
                                        <span>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                                    </td>
                                    <td class="flex justify-between py-1 md:table-cell md:py-3 md:px-4 md:text-sm">
                                        <span class="font-semibold md:hidden">Mata Pelajaran</span>
                                        <span>{{ $jadwal->mapel->nama ?? 'N/A' }}</span>
                                    </td>
                                    <td class="flex justify-between py-1 md:table-cell md:py-3 md:px-4 md:text-sm">
                                        <span class="font-semibold md:hidden">Guru Pengajar</span>
                                        <span>{{ $jadwal->guru->nama ?? 'N/A' }}</span>
                                    </td>
                                    <td class="flex justify-between py-1 md:table-cell md:py-3 md:px-4 md:text-sm">
                                        <span class="font-semibold md:hidden">Ruangan</span>
                                        <span>{{ $jadwal->ruangan ?? '-' }}</span>
                                    </td>
                                    <td class="flex justify-between py-1 md:table-cell md:py-3 md:px-4 md:text-sm">
                                        <span class="font-semibold md:hidden">T.A./Semester</span>
                                        <span>{{ $jadwal->tahun_ajaran ?? '-' }} / <span class="capitalize">{{ $jadwal->semester ?? '-' }}</span></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                Tidak ada jadwal pelajaran yang tersedia untuk kelas Anda.
            </p>
        </div>
    @endif
</div>
@endsection