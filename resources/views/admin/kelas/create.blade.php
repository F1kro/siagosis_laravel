@extends('layouts.app')

@section('content')

        <form action="{{ route('admin.kelas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.kelas._form', ['kelas' => null])
        </form>
@endsection