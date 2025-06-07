@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<main class="h-full overflow-y-auto">
    <div class="max-w-4xl px-6 py-8 mx-auto">

        <div class="py-2 mt-4 mb-6">
            <a href="{{ route('orangtua.berita.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <i class="w-5 h-5 mr-2 fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

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
            @else
                <img class="object-cover w-full h-auto mb-6 rounded-lg max-h-96" src="{{ asset('placeholder.png') }}" alt="{{ $berita->judul }}">
            @endif
            <div class="prose text-gray-700 prose-p:text-justify max-w-none dark:prose-invert dark:text-gray-300">
                {!! $berita->konten !!}
            </div>
        </div>

        @if($beritaTerkait->isNotEmpty())
            <div class="w-full p-6 mt-8 bg-white rounded-lg shadow-md md:p-8 dark:bg-gray-800">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Berita Terkait</h3>
                <ul class="mt-4 space-y-4">
                    @foreach ($beritaTerkait as $terkait)
                        <li>
                            <a href="{{ route('orangtua.berita.show', $terkait->id) }}" class="block group">
                                <h4 class="font-semibold text-purple-600 group-hover:underline dark:text-purple-400">{{ $terkait->judul }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $terkait->created_at->format('d M Y') }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</main>
@endsection