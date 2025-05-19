@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.siswa._form', ['siswa' => $siswa])

    </form>
@endsection
