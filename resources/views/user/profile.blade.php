@extends('layouts.app')
@section('title', 'Profil Pengguna')

@section('content')
<div class="container grid px-4 mx-auto sm:px-6">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Profil Pengguna
    </h2>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-md dark:bg-green-700 dark:text-gray-300" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-md dark:bg-red-700 dark:text-red-300" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg shadow-md dark:bg-red-700 dark:text-red-300" role="alert">
            <span class="font-medium">Oops! Ada beberapa kesalahan:</span>
            <ul class="mt-1.5 list-disc list-inside">
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
                        } elseif ($user->isOrangtua() && $user->orangtua && $user->orangtua->foto) {
                            $profilePhotoToShow = $user->orangtua->foto;
                        }
                    @endphp

                    @if($profilePhotoToShow)
                        <img src="{{ asset('storage/' . $profilePhotoToShow) }}" alt="{{ $user->name }} Profile Photo" class="rounded-xl w-50 h-50">
                    @else
                        <div class="rounded-lg default-icon">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                    @endif
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ $user->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="mt-1 text-sm font-medium text-purple-600 dark:text-purple-400">
                        @if($user->isGuru())
                            Guru
                        @elseif($user->isSiswa())
                            Siswa
                        @elseif($user->isOrangtua())
                            Orang Tua Murid
                        @else
                            Pengguna
                        @endif
                    </p>
                </div>

                <form action="{{ route('user.profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-xs space-y-4">
                    @csrf
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Foto Profil</label>
                        <input type="file" name="foto" id="foto"
                               class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-700 dark:file:text-purple-50 dark:hover:file:bg-purple-600">
                        @error('foto') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Upload Foto
                    </button>
                </form>
            </div>
            <div class="space-y-8 lg:col-span-2 ">
                <div class="p-4 rounded-lg shadow-md sm:p-6 bg-gray-50 dark:bg-gray-700">
                    <h3 class="mb-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Informasi Akun
                    </h3>
                    <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('name') border-red-500 @enderror">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('email') border-red-500 @enderror">
                            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        @php
                            $roleData = null;
                            $isGuru = $user->isGuru() && $user->guru;
                            $isSiswa = $user->isSiswa() && $user->siswa;
                            $isOrangtua = $user->isOrangtua() && $user->orangtua;

                            if ($isGuru) $roleData = $user->guru;
                            elseif ($isSiswa) $roleData = $user->siswa;
                            elseif ($isOrangtua) $roleData = $user->orangtua;
                        @endphp

                        @if($roleData)
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $roleData->telepon ?? '') }}"
                                       class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('phone') border-red-500 @enderror">
                                @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            @if($isGuru || $isSiswa)
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $roleData->tanggal_lahir ?? '') }}"
                                       class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('birth_date') border-red-500 @enderror">
                                @error('birth_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            @endif

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                                <textarea name="address" id="address" rows="3"
                                          class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray @error('address') border-red-500 @enderror">{{ old('address', $roleData->alamat ?? '') }}</textarea>
                                @error('address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <div>
                            <button type="submit"
                                    class="px-4 py-2 mt-4 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg leding-5 mt4font-medium active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
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
                            <input type="password" name="current_password" id="current_password"
                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('current_password') border-red-500 @enderror" autocomplete="current-password">
                            @error('current_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                            <input type="password" name="password" id="password"
                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('password') border-red-500 @enderror" autocomplete="new-password">
                            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" autocomplete="new-password">
                        </div>

                        <div>
                            <button type="submit"
                                    class="px-4 py-2 mt-4 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
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
