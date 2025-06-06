@extends('layouts.app')

@section('title', 'SIAGOSIS | MASTER NILAI')

@section('content')
<div class="w-full overflow-hidden rounded-lg">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
        Selamat Datang🎓, {{ $name }}
    </h2>

    <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Dashboard > Data Nilai
        </p>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">

        {{-- Filter Form --}}
        <form action="{{ route('admin.nilai.index') }}" method="GET" class="flex flex-wrap items-center flex-grow gap-4">
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

            <select name="mapel_id" class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200">
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapel as $m)
                    <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama }}
                    </option>
                @endforeach
            </select>

            <select name="guru_id" class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200">
                <option value="">-- Pilih Guru --</option>
                @foreach ($guru as $g)
                    <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama ?? ($g->user->name ?? '-') }}
                    </option>
                @endforeach
            </select>

            <select name="semester" class="px-3 py-2 border rounded-md dark:border-none dark:bg-gray-700 dark:text-gray-200">
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>

            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Filter
            </button>
        </form>

        {{-- Action Buttons --}}
        <div class="flex gap-3">

            {{-- Download Excel --}}
            <a href="{{ route('admin.nilai.laporan', request()->query()) }}"
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
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Mata Pelajaran</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Guru</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Jenis Nilai</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Nilai</th>
                    <th class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">Semester</th>
                    <th class="px-4 py-3">Tahun Ajaran</th>
                </tr>
            </thead>
            <tbody
                class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800"
            >
                @forelse($nilai as $index => $n)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $nilai->firstItem() + $index }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $n->siswa->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $n->mapel->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $n->guru->nama ?? ($n->guru->user->name ?? '-') }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $n->jenis_nilai }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ number_format($n->nilai, 2) }}
                    </td>
                    <td class="px-4 py-3 text-sm border-r border-gray-200 dark:border-gray-700">
                        {{ $n->semester }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $n->tahun_ajaran }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-6 text-center text-gray-500">
                        <i class="mb-2 text-3xl fas fa-times-circle"></i>
                        <p class="mb-2">Tidak ada data nilai ditemukan | Data nilai belum di Input</p>
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
            {{ $nilai->appends(request()->query())->links('pagination::tailwind') }}
        </div>
        <div
            class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0"
        >
            Halaman {{ $nilai->currentPage() }} dari {{ $nilai->lastPage() }} |
            Menampilkan {{ $nilai->firstItem() }} - {{ $nilai->lastItem() }} dari total {{ $nilai->total() }} data
        </div>
    </div>
</div>
@endsection
