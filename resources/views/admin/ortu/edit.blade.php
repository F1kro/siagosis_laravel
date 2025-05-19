@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.ortu.update', $orangtua->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.ortu._form', ['orangtua' => $orangtua])

    </form>
@endsection
