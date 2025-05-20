@extends('layouts.app')

@section('title', 'Edit Berita')

@section('content')
    {{-- <div class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800"> --}}
        {{-- <h2 class="mb-6 text-2xl font-semibold text-gray-700 dark:text-white">Edit Berita</h2> --}}
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.berita.form')
        </form>
    {{-- </div> --}}

    @push('scripts')
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('konten');
        </script>
    @endpush
@endsection
