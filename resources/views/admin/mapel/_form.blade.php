@php
    $data = optional($mapel);
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($mapel) ? 'Edit' : 'Tambah' }} Mapel
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($mapel) ? route('admin.mapel.update', $mapel->id) : route('admin.mapel.store') }}" method="POST">
            @csrf
            @if(isset($mapel))
                @method('PUT')
            @endif

            {{-- Kode Mapel --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Kode Mapel</span>
                <input
                    type="text"
                    name="kode"
                    value="{{ old('kode', $data->kode ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: MTK101"
                />
                @error('kode')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Nama Mapel --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nama Mapel</span>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $data->nama ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: Matematika"
                />
                @error('nama')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- KKM --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">KKM</span>
                <input
                    type="number"
                    name="kkm"
                    value="{{ old('kkm', $data->kkm ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: 75"
                />
                @error('kkm')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Jumlah Jam --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Jumlah Jam</span>
                <input
                    type="number"
                    name="jumlah_jam"
                    value="{{ old('jumlah_jam', $data->jumlah_jam ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: 4"
                />
                @error('jumlah_jam')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Pilih Kelas (Multi-select) --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Pilih Kelas</span>
                <select
                    name="kelas_id[]"
                    multiple
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300"
                >
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ (collect(old('kelas_id', optional($data->kelas)->pluck('id') ?: []))->contains($k->id)) ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Submit --}}
            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700"
                >
                    {{ isset($mapel) ? 'Update' : 'Simpan' }} Mapel
                </button>
            </div>
        </form>
    </div>
</div>
