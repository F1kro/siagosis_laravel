@php
    $data = optional($kelas);
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($kelas) ? 'Edit' : 'Tambah' }} Kelas
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($kelas) ? route('admin.kelas.update', $kelas->id) : route('admin.kelas.store') }}" method="POST">
            @csrf
            @if(isset($kelas))
                @method('PUT')
            @endif

            {{-- Nama Kelas --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nama Kelas</span>
                <input
                    type="text"
                    name="nama_kelas"
                    value="{{ old('nama_kelas', $data->nama_kelas ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: Kelas 10 IPA 1"
                />
                @error('nama_kelas')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Kode Kelas --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Kode Kelas</span>
                <input
                    type="text"
                    name="kode_kelas"
                    value="{{ old('kode_kelas', $data->kode_kelas ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: 10IPA1"
                />
                @error('kode_kelas')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Tahun Ajaran --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tahun Ajaran</span>
                <input
                    type="text"
                    name="tahun_ajaran"
                    value="{{ old('tahun_ajaran', $data->tahun_ajaran ?? '') }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: 2024/2025"
                />
                @error('tahun_ajaran')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Wali Kelas --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Wali Kelas</span>
                <select
                    name="guru_id"
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300"
                >
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($guru as $g)
                    <option value="{{ $g->id }}" {{ old('guru_id', $data->guru_id ?? '') == $g->id ? 'selected' : '' }}>
                        {{ $g->nama }} ({{ $g->nip }})
                    </option>
                    @endforeach
                </select>
                @error('guru_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Submit --}}
            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700"
                >
                    {{ isset($kelas) ? 'Update' : 'Simpan' }} Kelas
                </button>
            </div>
        </form>
    </div>
</div>
