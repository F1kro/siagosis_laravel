@extends('layouts.app')

@section('content')

        <form action="{{ route('admin.mapel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.mapel._form', ['mapel' => null])
        </form>
@endsection