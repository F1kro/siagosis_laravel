@extends('layouts.app')

@section('title', 'GURU | BERITA')


@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 py-8 mx-auto">
        {{-- BAGIAN BARU: SAPAAN SELAMAT DATANG --}}
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang🎓, {{ $name }}
        </h2>

        {{-- BAGIAN BARU: BREADCRUMBS --}}
        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('guru.dashboard') }}" class="hover:underline">Dashboard</a>
                <span class="mx-2">> </span>
                <span class="font-semibold">Portal Berita</span>
            </p>
        </div>

        {{-- KONTEN LAMA (TIDAK BERUBAH) --}}
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($beritas as $berita)
                <div class="flex flex-col justify-between p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-gray-700">
                                {{ $berita->kategori ?? 'Umum' }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $berita->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <h4 class="mb-2 text-xl font-semibold leading-tight text-gray-700 dark:text-gray-200">
                            {{ $berita->judul }}
                        </h4>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('guru.berita.show', $berita->id) }}"
                           class="w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @empty
                <div class="w-full p-6 text-center bg-white rounded-lg shadow-md dark:bg-gray-800 md:col-span-2 xl:col-span-3">
                    <p class="text-gray-600 dark:text-gray-400">Belum ada berita yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $beritas->links() }}
        </div>
    </div>
</main>
@endsection