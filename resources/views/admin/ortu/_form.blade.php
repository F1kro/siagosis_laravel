@php
    $data = optional(optional($orangtua)->orangtua);
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($orangtua) ? 'Edit' : 'Tambah' }} Orangtua
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($orangtua) ? route('admin.ortu.update', $orangtua->id) : route('admin.ortu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($orangtua))
                @method('PUT')
            @endif

            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nama</span>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $data->nama ?? '') }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Nama"
                />
                @error('nama')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Telp</span>
                <input
                    type="text"
                    name="telepon"
                    value="{{old('telepon', $data->telepon ?? '')}}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan No.Telp"
                />
                @error('telepon')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Pekerjaan</span>
                <input
                    type="text"
                    name="pekerjaan"
                    value="{{old('pekerjaan', $data->pekerjaan ?? '')}}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Pekerjaan"
                />
                @error('pekerjaan')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Orangtua / Wali dari</span>
                <select
                    name="siswa_id"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                >
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa as $siswaItem)
                        <option value="{{ $siswaItem->id }}"
                            {{ old('siswa_id', $data->siswa_id ?? '') == $siswaItem->id ? 'selected' : '' }}>
                            {{ $siswaItem->nama }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

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

            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                {{ isset($orangtua) ? 'Update' : 'Simpan' }}  Data Orang Tua
                </button>
            </div>
        </form>
    </div>
</div>