@extends('layouts.app')

@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Laporan Data Guru
            </h2>

            <div class="px-4 py-4 mb-4 bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
                 <i class="fa fa-backward-step" aria-hidden="true"></i>
                <a href="{{ route('admin.laporan.index') }}">Kembali ke menu laporan</a>
            </div>

            <div class="px-4 py-3 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Filter Laporan</h4>
                    <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                        class="px-3 py-1 text-sm font-bold leading-5 text-black duration-150 bg-green-600 border border-transparent rounded-md translate-x-1ansition-colors dark:text-white active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                        <i class="mr-2 fas fa-file-excel"></i>
                        <span>Export to Excel</span>
                    </a>
                </div>
                <form action="{{ route('admin.laporan.guru') }}" method="GET">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <label class="block text-sm md:col-span-2">
                            <span class="text-gray-700 dark:text-gray-400">Cari Nama / NIP</span>
                            <input name="search" value="{{ request('search') }}"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <div class="flex items-end mt-2 space-x-2">
                            <button type="submit"
                                class="px-4 py-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Terapkan
                            </button>
                            <a href="{{ route('admin.laporan.guru') }}"
                                class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-gray-200 border border-transparent rounded-lg shadow-md active:bg-gray-300 hover:bg-gray-300 focus:outline-none focus:shadow-outline-gray dark:bg-gray-700 dark:text-gray-200">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap shadow-md">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">NIP</th>
                                <th class="px-4 py-3">Nama Guru</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Mapel & Kelas Diampu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @forelse ($gurus as $guru)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm">{{ $guru->nip ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $guru->nama }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $guru->user->email ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-xs">
                                        @forelse($guru->guruMapel as $gm)
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-white dark:text-black">
                                                {{ $gm->mapel->nama }} - {{ $gm->kelas->nama_kelas }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500">Belum ada Mapel / Kelas Diampu</span>
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center">Tidak ada data yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div
                    class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">
                        Showing {{ $gurus->firstItem() }}-{{ $gurus->lastItem() }} of {{ $gurus->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        {{ $gurus->links() }}
                    </span>
                </div>
            </div>
        </div>
    </main>
@endsection
