@php
    $data = optional(optional($guru)->guru);
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($guru) ? 'Edit' : 'Tambah' }}  Guru
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- NISN -->
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">NIP</span>
                <input
                    type="text"
                    name="nip"
                    value="{{ old('nip', $data->nip ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan NIP"
                />
                @error('nip')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Nama -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nama Lengkap</span>
                <input
                    type="text"
                    name="nama"
                    value="{{old('nama', $data->nama ?? '')}}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Nama Lengkap"
                />
                @error('nama')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">No. Telp</span>
                <input
                    type="number"
                    name="telepon"
                    value="{{old('telepon', $data->telepon ?? '')}}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan No.Telp"
                />
                @error('telepon')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Jenis Kelamin -->
            <div class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Jenis Kelamin</span>
                <div class="mt-2">
                    <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            value="Laki-laki"
                            {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'Laki-laki' ? 'checked' : '' }}
                            class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        />
                        <span class="ml-2">Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            value="Perempuan"
                            {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'Perempuan' ? 'checked' : '' }}
                            class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        />
                        <span class="ml-2">Perempuan</span>
                    </label>
                </div>
                @error('jenis_kelamin')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tanggal Lahir</span>
                <input
                    type="date"
                    name="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $data->tanggal_lahir ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                />
                @error('tanggal_lahir')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Tempat Lahir -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Pendidika Terakhir</span>
                <input
                    type="text"
                    name="pendidikan_terakhir"
                    value="{{ old('pendidikan_terakhir', $data->pendidikan_terakhir ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Pendidikan Terakhir"
                />
                @error('pendidikan_terakhir')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Alamat -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Alamat</span>
                <textarea
                    name="alamat"
                    rows="3"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    placeholder="Masukkan Alamat Lengkap"
                >{{ old('alamat', $data->alamat ?? '') }}</textarea>
                @error('alamat')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Foto Profil -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Foto Profil</span>
                <input
                    type="file"
                    name="foto"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    value="{{ old('foto', $data->foto ?? '') }}"
                />
                @error('foto')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                {{ isset($guru) ? 'Update' : 'Simpan' }}  Data guru
                </button>
            </div>
        </form>
    </div>
</div>