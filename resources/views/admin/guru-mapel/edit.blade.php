@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.guru_mapel.update', $guruMapel->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.guru_mapel._form', ['guruMapel' => $guruMapel, 'gurus' => $gurus, 'mapels' => $mapels, 'kelas' => $kelas])
    </form>
@endsection
