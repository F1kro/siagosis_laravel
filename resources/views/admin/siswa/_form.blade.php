@php
    $data = optional(optional($siswa)->siswa);
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($siswa) ? 'Edit' : 'Tambah' }}  Siswa
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- NISN -->
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">NISN</span>
                <input
                    type="text"
                    name="nisn"
                    value="{{ old('nisn', $data->nisn ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan NISN"
                />
                @error('nisn')
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

            <!-- Kelas -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                <select
                    name="kelas_id"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                >
                    @foreach($kelas as $kelasItem)
                        <option value="{{ $kelasItem->id }}" {{ old('kelas_id') == $kelasItem->id ? 'selected' : '' }}>
                            {{ $kelasItem->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
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
                <span class="text-gray-700 dark:text-gray-400">Tempat Lahir</span>
                <input
                    type="text"
                    name="tempat_lahir"
                    value="{{ old('tempat_lahir', $data->tempat_lahir ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Tempat Lahir"
                />
                @error('tempat_lahir')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <!-- Agama -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Agama</span>
                <input
                    type="text"
                    name="agama"
                    value="{{ old('agama', $data->agama ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Agama"
                />
                @error('agama')
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
                {{ isset($siswa) ? 'Update' : 'Simpan' }}  Data Siswa
                </button>
            </div>
        </form>
    </div>
</div>