@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.mapel._form', ['mapel' => $mapel])

    </form>
@endsection
