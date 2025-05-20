@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('admin.users._form', ['user' => $user])

    </form>
@endsection
