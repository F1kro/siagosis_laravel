@extends('layouts.app')
@section('title', 'Profil Pengguna')

@section('content')
<div class="container grid px-4 mx-auto sm:px-6">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Profil Pengguna
    </h2>

    @if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="flex items-center justify-between p-4 mb-4 text-sm text-white bg-green-500 rounded-lg shadow-md dark:bg-green-400 dark:text-green-200" role="alert">
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif
    @if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="flex items-center justify-between p-4 mb-4 text-sm text-red-800 rounded-lg shadow-md bg-red-50 dark:bg-red-800 dark:text-red-200" role="alert">
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif
    @if ($errors->any())
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <p class="font-medium">Harap perbaiki kesalahan di bawah ini:</p>
        <ul class="mt-1.5 ml-4 list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="w-full p-4 bg-white rounded-lg shadow-xl sm:p-8 dark:bg-gray-800">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 lg:gap-8">
            <div class="flex flex-col items-center space-y-6 lg:col-span-1 lg:items-start">
                <div class="overflow-hidden rounded-lg shadow-lg ">
                    @php
                        $profilePhotoToShow = null;
                        if ($user->isGuru() && $user->guru && $user->guru->foto) {
                            $profilePhotoToShow = $user->guru->foto;
                        } elseif ($user->isSiswa() && $user->siswa && $user->siswa->foto) {
                            $profilePhotoToShow = $user->siswa->foto;
                        }
                    @endphp

                    @if ($profilePhotoToShow)
                        <img src="{{ asset('storage/' . $profilePhotoToShow) }}" alt="{{ $user->name }} Profile Photo" class="object-cover w-48 h-48 rounded-lg">
                    @else
                        <div class="flex items-center justify-center w-48 h-48 bg-gray-200 rounded-lg dark:bg-gray-700">
                            <i class="text-5xl text-gray-400 fas fa-user dark:text-gray-500"></i>
                        </div>
                    @endif
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ $user->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="mt-1 text-sm font-medium text-purple-600 dark:text-purple-400">
                        @if ($user->isGuru()) Guru
                        @elseif($user->isSiswa()) Siswa
                        @elseif($user->isOrangtua()) Orang Tua Murid
                        @else Pengguna
                        @endif
                    </p>
                </div>

                <div class="w-full p-4 text-sm text-gray-700 bg-gray-100 rounded-lg dark:bg-gray-700 dark:text-gray-300">
                    <h4 class="mb-2 font-semibold border-b border-gray-300 dark:border-gray-600">Informasi Terkait</h4>
                    @if ($user->isSiswa() && $user->siswa)
                        <div class="flex justify-between">
                            <span class="font-medium">Kelas:</span>
                            <span>{{ $user->siswa->kelas->nama_kelas ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="font-medium">Wali Kelas:</span>
                            <span>{{ $user->siswa->kelas->waliKelas->nama ?? 'N/A' }}</span>
                        </div>
                    @endif
                    @if ($user->isGuru() && $user->guru)
                        <div class="mt-1">
                            <span class="font-medium">Wali Kelas dari:</span>
                            <ul class="pl-5 mt-1 list-disc">
                                @forelse ($user->guru->kelasWali as $kelas)
                                    <li>{{ $kelas->nama_kelas }}</li>
                                @empty
                                    <li>Bukan Wali Kelas</li>
                                @endforelse
                            </ul>
                        </div>
                    @endif
                    @if ($user->isOrangtua() && $user->orangtua)
                         <div class="flex justify-between">
                            <span class="font-medium">Nama Anak:</span>
                            <span>{{ $user->orangtua->siswa->nama ?? 'N/A' }}</span>
                        </div>
                         <div class="flex justify-between mt-1">
                            <span class="font-medium">Kelas Anak:</span>
                            <span>{{ $user->orangtua->siswa->kelas->nama_kelas ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="font-medium">Wali Kelas Anak:</span>
                            <span>{{ $user->orangtua->siswa->kelas->waliKelas->nama ?? 'N/A' }}</span>
                        </div>
                    @endif
                </div>

                @if ($user->isGuru() || $user->isSiswa())
                <form action="{{ route('user.profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-xs space-y-4">
                    @csrf
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="block w-full p-2 mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-700 dark:file:text-purple-50 dark:hover:file:bg-purple-600">
                        @error('foto')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Upload Foto
                    </button>
                </form>
                @endif
            </div>

            <div class="space-y-8 lg:col-span-2 ">
                @php
                    $roleData = $user->guru ?? $user->siswa ?? $user->orangtua;
                @endphp

                <div class="p-4 rounded-lg shadow-md sm:p-6 bg-gray-50 dark:bg-gray-700">
                    <h3 class="mb-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Informasi Akun
                    </h3>
                    <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Akun</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('email') border-red-500 @enderror">
                            @error('email')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <input type="hidden" name="nama_user" value="{{ $user->name }}">

                        @if($user->isGuru())
                            @include('user.partials.form-guru', ['guru' => $roleData])
                        @elseif($user->isSiswa())
                             @include('user.partials.form-siswa', ['siswa' => $roleData])
                        @elseif($user->isOrangtua())
                            @include('user.partials.form-orangtua', ['orangtua' => $roleData])
                        @endif

                        <div>
                            <button type="submit" class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>

                <div class="p-4 mt-4 rounded-lg shadow-md sm:p-6 bg-gray-50 dark:bg-gray-700">
                    <h3 class="mb-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Ganti Password
                    </h3>
                    <form action="{{ route('user.profile.update-password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('current_password') border-red-500 @enderror" autocomplete="current-password">
                            @error('current_password')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                            <input type="password" name="password" id="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('password') border-red-500 @enderror" autocomplete="new-password">
                            @error('password')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" autocomplete="new-password">
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<style>
    .form-input-tailwind {
        @apply block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input;
    }
    .form-select-tailwind {
        @apply block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray;
    }
    .form-textarea-tailwind {
         @apply block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray;
    }
</style>
