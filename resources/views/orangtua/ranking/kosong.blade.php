@extends('layouts.app')
@section('title', 'Peringkat Akademik')

@section('content')
<div class="container grid px-6 mx-auto">
     <div class="flex items-center justify-center h-screen -mt-16">
        <div class="p-6 text-center bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <i class="mb-4 text-5xl text-purple-600 fas fa-link-slash"></i>
            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Akun Belum Terhubung
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Akun orang tua Anda belum terhubung dengan data siswa manapun. <br>
                Silakan hubungi admin sekolah untuk melakukan penautan data.
            </p>
        </div>
    </div>
</div>
@endsection