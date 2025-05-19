@extends('layouts.app')

@section('content')

        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.siswa._form', ['siswa' => null])
        </form>
@endsection