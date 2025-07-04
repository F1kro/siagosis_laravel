@extends('layouts.app')
@section('title', 'Riwayat Absensi Anak')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Riwayat Absensi Anak: {{ $siswa->nama }}
    </h2>

    <div class="p-4 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('orangtua.absensi.index') }}" method="GET" class="flex flex-col space-y-4 md:flex-row md:items-end md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="bulan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bulan</label>
                <select name="bulan" id="bulan" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Semua</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="flex-1">
                <label for="tahun" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                <select name="tahun" id="tahun" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Semua</option>
                    @foreach ($daftarTahun as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Semua</option>
                    @foreach ($daftarMapel as $mapel)
                        <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Jam</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Guru</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($absensiSiswa as $absen)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d F Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $absen->waktu ? \Carbon\Carbon::parse($absen->waktu)->format('H:i') : '-' }}</td>
                        <td class="px-4 py-3 text-sm font-semibold">{{ $absen->mapel->nama ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $guruLookup[$absen->mapel_id] ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if(strtolower($absen->status) == 'hadir')
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Hadir</span>
                            @elseif(strtolower($absen->status) == 'sakit')
                                <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">Sakit</span>
                            @elseif(strtolower($absen->status) == 'izin')
                                <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:text-white dark:bg-blue-600">Izin</span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">Alpa</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                            Tidak ada data absensi yang cocok dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between px-4 py-3 border-t dark:border-gray-700 md:flex-row bg-gray-50 dark:bg-gray-800">
            <div>
                {{ $absensiSiswa->links() }}
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $absensiSiswa->currentPage() }} dari {{ $absensiSiswa->lastPage() }} |
                Menampilkan {{ $absensiSiswa->firstItem() ?? 0 }} - {{ $absensiSiswa->lastItem() ?? 0 }} dari total {{ $absensiSiswa->total() }} data
            </div>
        </div>
    </div>
</div>
@endsection