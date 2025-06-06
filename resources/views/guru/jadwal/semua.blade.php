@extends('layouts.app')

@push('styles')
<style>
    @media screen and (max-width: 767px) {
        .responsive-table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        .responsive-table {
            white-space: normal !important;
        }

        .responsive-table tr {
            display: block;
            margin-bottom: 1rem;
        }
        .responsive-table tbody.divide-y > :not([hidden]) ~ :not([hidden]) {
            border-top-width: 0px !important;
            border-bottom-width: 0px !important;
        }

        .responsive-table td {
            display: block;
            text-align: right;
            position: relative;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            padding-right: 1rem;
            padding-left: 48%;
            border-bottom-width: 1px;
        }

        .responsive-table td {
             border-color: #e5e7eb;
        }
        .dark .responsive-table td {
             border-color: #374151;
        }

        .responsive-table td:last-of-type {
            border-bottom-width: 0;
        }

        .responsive-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            top: 0.75rem;
            width: calc(48% - 1.5rem);
            padding-right: 0.5rem;
            white-space: normal;
            text-align: left;
            font-weight: 600;
        }
    }
</style>
@endpush

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Daftar Semua Jadwal Mengajar Anda
    </h2>

    @if ($semuaJadwalGuru && $semuaJadwalGuru->isNotEmpty())
        @foreach ($semuaJadwalGuru as $hari => $jadwalsPadaHariIni)
            <div class="mb-8">
                <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300">
                    {{ $hari }}
                </h3>
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div>
                        <table class="w-full whitespace-no-wrap responsive-table">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Waktu</th>
                                    <th class="px-4 py-3">Mata Pelajaran</th>
                                    <th class="px-4 py-3">Kelas</th>
                                    <th class="px-4 py-3">Ruangan</th>
                                    <th class="px-4 py-3">T.A./Semester</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($jadwalsPadaHariIni->sortBy('jam_mulai') as $jadwal)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td data-label="Waktu" class="px-4 py-3 text-sm">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td data-label="Mata Pelajaran" class="px-4 py-3 text-sm">
                                        {{ $jadwal->mapel->nama ?? 'N/A' }}
                                    </td>
                                    <td data-label="Kelas" class="px-4 py-3 text-sm">
                                        {{ $jadwal->kelas->nama_kelas ?? 'N/A' }}
                                    </td>
                                    <td data-label="Ruangan" class="px-4 py-3 text-sm">
                                        {{ $jadwal->ruangan ?? '-' }}
                                    </td>
                                    <td data-label="T.A./Semester" class="px-4 py-3 text-sm">
                                        {{ $jadwal->tahun_ajaran ?? '-' }} / {{ $jadwal->semester ?? '-' }}
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
                Anda belum memiliki jadwal mengajar yang tersimpan.
            </p>
        </div>
    @endif
</div>
@endsection