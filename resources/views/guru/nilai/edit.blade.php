@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.nilai.update', $nilai->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        @include('admin.nilai._form', ['nilai' => $nilai])
    </form>
@endsection
