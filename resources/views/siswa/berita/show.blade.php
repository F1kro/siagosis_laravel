@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 py-8 mx-auto">



        <div class="py-2 mt-8 mb-6 rounded-lg my dark:bg-gray-800">
            <a href="{{ route('siswa.berita.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-500 border border-transparent rounded-lg hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Berita
            </a>
        </div>

        {{-- KONTEN LAMA (TIDAK BERUBAH) --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="w-full p-6 bg-white rounded-lg shadow-md md:p-8 dark:bg-gray-800">
                    <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">
                        {{ $berita->judul }}
                    </h1>
                    <div class="mt-2 mb-6 text-sm text-gray-500 dark:text-gray-400">
                        <span>Penulis: {{ $berita->user->name ?? 'Admin Sekolah' }}</span>
                        <span class="mx-2">•</span>
                        <span>Diterbitkan pada {{ $berita->created_at->format('d F Y') }}</span>
                    </div>
                    @if($berita->foto)
                        <img class="object-cover w-full h-auto mb-6 rounded-lg max-h-96" src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}">
                    @endif
                    <div class="prose text-gray-700 max-w-none dark:prose-invert dark:text-gray-300">
                        {!! $berita->konten !!}
                    </div>
                </div>
            </div>

            <aside class="space-y-8">
                @if($beritaTerkait->isNotEmpty())
                    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Berita Terkait</h3>
                        <ul class="mt-4 space-y-4">
                            @foreach ($beritaTerkait as $terkait)
                                <li>
                                    <a href="{{ route('siswa.berita.show', $terkait->id) }}" class="block group">
                                        <h4 class="font-semibold text-purple-600 group-hover:underline dark:text-purple-400">{{ $terkait->judul }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $terkait->created_at->format('d M Y') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</main>
@endsection