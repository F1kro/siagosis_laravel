@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.guru-mapel.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('admin.guru-mapel._form', [
            'guruMapel' => null,
            'gurus' => $gurus,
            'mapelsWithKelas' => $mapelsWithKelas
        ])
    </form>
@endsection