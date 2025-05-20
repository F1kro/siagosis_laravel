@extends('layouts.app')

@section('title', 'Tambah Berita')

@section('content')
    {{-- <div class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800"> --}}
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
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
