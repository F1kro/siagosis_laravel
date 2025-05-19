@extends('layouts.app')

@section('content')

        <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.guru._form', ['guru' => null])
        </form>
@endsection