@extends('layouts.app')

@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Laporan Absensi Siswa
            </h2>

            <div class="px-4 py-4 mb-4 bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
                <i class="fa fa-backward-step" aria-hidden="true"></i>
                <a href="{{ route('admin.laporan.index') }}">Kembali ke menu laporan</a>
            </div>


            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Filter Laporan</h4>
                    @if ($absensiList->isNotEmpty())
                        <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                            class="px-3 py-1 text-sm font-bold leading-5 text-black duration-150 bg-green-600 border border-transparent rounded-md translate-x-1ansition-colors dark:text-white active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                            <i class="mr-2 fas fa-file-excel"></i>
                            <span>Export to Excel</span>
                        </a>
                    @endif
                </div>
                <form action="{{ route('admin.laporan.absensi') }}" method="GET">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                            <select name="kelas_id" required
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Dari Tanggal</span>
                            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Sampai Tanggal</span>
                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
                            <select name="status"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">Semua</option>
                                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                            </select>
                        </label>
                        <div class="flex items-end mt-4">
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="w-full mb-6 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Nama Siswa</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($absensiList as $absensi)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm">
                                        {{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('D MMM Y') }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $absensi->siswa->nama ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-xs">
                                        @if ($absensi->status == 'Hadir')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{ $absensi->status }}</span>
                                        @elseif($absensi->status == 'Sakit')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-gray-900 dark:text-white">{{ $absensi->status }}</span>
                                        @elseif($absensi->status == 'Izin')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-gray-900 dark:text-white">{{ $absensi->status }}</span>
                                        @elseif($absensi->status == 'Alpa')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">{{ $absensi->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $absensi->keterangan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center dark:text-gray-300">
                                        @if (request()->has('kelas_id'))
                                            Belum ada Data Absensi
                                        @else
                                            Pilih Kelas Untuk Untuk Melihat Absensi
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div
                    class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">
                        Showing {{ $absensiList->firstItem() }}-{{ $absensiList->lastItem() }} of
                        {{ $absensiList->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        {{ $absensiList->links() }}
                    </span>
                </div>
            </div>
        </div>
    </main>
@endsection
