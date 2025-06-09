@extends('layouts.app')
@section('title', 'Hubungi Orang Tua')

@section('content')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Hubungi Orang Tua Siswa
        </h2>

        <div class="mb-4">
            <form action="{{ route('guru.hubungi.ortu') }}" method="GET">
                <div class="relative w-full max-w-full focus-within:text-purple-500">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Cari Nama Orangtua / Nama Siswa</span>
                        <input name="search" value="{{ request('search') }}"
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </label>
                    <button type="submit"
                        class="px-4 py-2 mt-2 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Cari Orangtua
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Nama Orang Tua</th>
                            <th class="px-4 py-3">Nama Siswa</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($orang_tua as $ortu)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $ortu->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ortu->siswa->nama ?? 'Siswa tidak ditemukan' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <a href="https://wa.me/{{ $ortu->telepon }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-block px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                        Hubungi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10 text-center dark:text-gray-300">
                                    @if (request('search'))
                                        Data dengan kata kunci "{{ request('search') }}" tidak ditemukan.
                                    @else
                                        Data orang tua tidak ditemukan.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="flex flex-col items-center justify-between px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 sm:flex-row bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                    Menampilkan {{ $orang_tua->firstItem() ?? 0 }}-{{ $orang_tua->lastItem() ?? 0 }} dari
                    {{ $orang_tua->total() }} data
                </span>
                <span class="col-span-2"></span>
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    {{ $orang_tua->links() }}
                </span>
            </div>
        </div>
    </div>
@endsection
