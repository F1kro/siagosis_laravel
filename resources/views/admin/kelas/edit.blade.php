@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.kelas._form', ['kelas' => $kelas])

    </form>
@endsection
