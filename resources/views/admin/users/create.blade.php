@extends('layouts.app')

@section('content')

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.users._form', ['users' => null])
        </form>
@endsection