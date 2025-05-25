@extends('layouts.app')

@section('content')
    <form action="{{ route('guru.nilai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('guru.nilai._form', ['nilai' => null, 'siswa' => $siswa, 'mapel' => $mapel])
    </form>
@endsection
