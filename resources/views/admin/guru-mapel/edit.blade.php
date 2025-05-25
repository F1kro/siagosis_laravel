@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.guru-mapel.update', $guruMapel->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.guru-mapel._form', [
            'guruMapel' => $guruMapel,
            'gurus' => $gurus,
            'mapelsWithKelas' => $mapelsWithKelas,
            'currentCombinedId' => $currentCombinedId
        ])
    </form>
@endsection