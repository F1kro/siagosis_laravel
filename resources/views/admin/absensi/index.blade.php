@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
<div class="w-full overflow-hidden rounded-lg">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
        Selamat Datang🎓, {{ $name }}
    </h2>

    <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Dashboard > Data Absensi
        </p>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">

        {{-- Filter Form --}}
        <form action="{{ route('admin.absensi.index') }}" method="GET" class="flex flex-wrap items-center flex-grow gap-4">

            <input
                type="text"
                name="search"
                placeholder="Cari nama siswa..."
                value="{{ request('search') }}"
                class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200"
            />

            <select name="kelas_id" class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>

            <select name="semester" class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200">
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>

            <input
                type="text"
                name="tahun_ajaran"
                placeholder="Tahun Ajaran (2024/2025)"
                value="{{ request('tahun_ajaran') }}"
                class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200"
            />

            <input
                type="date"
                name="tanggal_awal"
                value="{{ request('tanggal_awal') }}"
                class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200"
                title="Tanggal Awal"
            />

            <input
                type="date"
                name="tanggal_akhir"
                value="{{ request('tanggal_akhir') }}"
                class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200"
                title="Tanggal Akhir"
            />

            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Filter
            </button>
        </form>

        {{-- Action Buttons --}}
        <div class="flex gap-3">

            {{-- Download Excel --}}
            <a href="{{ route('admin.absensi.laporan', request()->query()) }}"
               class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700"
               title="Download Excel">
                <i class="mr-2 fas fa-file-excel"></i> Excel
            </a>

            {{-- Print --}}
            <button
                onclick="window.print()"
                class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700"
                title="Print Laporan"
            >
                <i class="mr-2 fas fa-print"></i> Print
            </button>

        </div>

    </div>

    <div class="w-full overflow-x-auto rounded-lg">
        <table class="w-full whitespace-no-wrap border border-collapse border-gray-200 table-auto dark:border-gray-700">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                >
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">No.</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Nama Siswa</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Kelas</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Tanggal</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Status</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Keterangan</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Semester</th>
                    <th class="px-4 py-3">Tahun Ajaran</th>
                </tr>
            </thead>
            <tbody
                class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800"
            >
                @forelse($absensi as $index => $a)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $absensi->firstItem() + $index }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $a->siswa->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $a->kelas->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $a->status }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $a->keterangan ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $a->semester }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $a->tahun_ajaran }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-6 text-center text-gray-500">
                        <i class="mb-2 text-3xl fas fa-times-circle"></i>
                        <p class="mb-2">Tidak ada data absensi ditemukan | Data belum diinput</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div
        class="flex flex-col items-center justify-between py-4 md:flex-row"
    >
        <div>
            {{ $absensi->appends(request()->query())->links('pagination::tailwind') }}
        </div>
        <div
            class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0"
        >
            Halaman {{ $absensi->currentPage() }} dari {{ $absensi->lastPage() }} |
            Menampilkan {{ $absensi->firstItem() }} - {{ $absensi->lastItem() }} dari total {{ $absensi->total() }} data
        </div>
    </div>
</div>
@endsection
