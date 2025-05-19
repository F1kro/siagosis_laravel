@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.guru._form', ['guru' => $guru])

    </form>
@endsection
