@extends('layouts.app')

@section('content')
    <form action="{{ route('guru.nilai.update', $nilai->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        {{-- Di sini kamu sudah mengirim $nilai, $siswa, $mapel ke _form --}}
        @include('guru.nilai._form', ['nilai' => $nilai, 'siswa' => $siswa, 'mapel' => $mapel])
    </form>
@endsection