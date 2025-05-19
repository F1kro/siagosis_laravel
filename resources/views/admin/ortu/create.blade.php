@extends('layouts.app')

@section('content')

        <form action="{{ route('admin.ortu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.ortu._form', ['orangtua' => null])
        </form>
@endsection