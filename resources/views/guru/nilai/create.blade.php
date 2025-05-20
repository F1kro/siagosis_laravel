@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.nilai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.nilai._form', ['nilai' => null])
    </form>
@endsection
