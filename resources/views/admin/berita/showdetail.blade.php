@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
    <div class="w-full overflow-hidden rounded-lg">

        <div class="mb-6">
            <a href="{{ route('admin.berita.index') }}"
                class="inline-block px-4 py-2 text-sm text-white bg-gray-600 rounded hover:bg-gray-700">
                ← Kembali ke daftar berita
            </a>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @if ($berita->foto)
                <img src="{{ asset('storage/' . $berita->foto) }}" alt="Foto Berita" class="w-full rounded-lg shadow">
            @endif

            <h1 class="mb-4 text-3xl font-bold text-gray-800 capitalize dark:text-white">
                {{ $berita->judul }}
            </h1>

            <div class="flex items-center justify-between mb-4 text-sm text-gray-500 dark:text-gray-400">
                <span>Kategori: <strong>{{ $berita->kategori }}</strong></span>
                <span>Penulis: {{ $berita->user->name ?? '-' }}</span>
                <span>{{ $berita->created_at->format('d M Y') }}</span>
            </div>

            <hr class="my-4 border-gray-300 dark:border-gray-700">

            <article class="prose prose-lg max-w-none dark:prose-invert">
                {!! $berita->konten !!}
            </article>

            @if ($berita->status !== 'Dipublikasikan')
                <div class="p-4 mt-6 text-sm text-yellow-800 bg-yellow-100 rounded dark:bg-yellow-900 dark:text-yellow-300">
                    <strong>Catatan:</strong> Berita ini belum dipublikasikan.
                </div>
            @endif
        </div>
    </div>
@endsection
