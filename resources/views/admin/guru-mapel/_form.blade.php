@php
    $data = optional($guruMapel ?? null);
    // Untuk mode edit, kita butuh currentCombinedId yang sudah dibuat di controller
    $selectedCombinedId = old('mapel_kelas_combined_id', $currentCombinedId ?? '');
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($guruMapel) && $guruMapel->exists ? 'Edit' : 'Tambah' }} Guru Mapel
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($guruMapel) && $guruMapel->exists ? route('admin.guru-mapel.update', $guruMapel->id) : route('admin.guru-mapel.store') }}" method="POST">
            @csrf
            @if(isset($guruMapel) && $guruMapel->exists)
                @method('PUT')
            @endif

            {{-- Pilih Guru --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Guru</span>
                <select
                    name="guru_id"
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300"
                    required
                >
                    <option value="">-- Pilih Guru --</option>
                    @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id', $data->guru_id) == $guru->id ? 'selected' : '' }}>
                        {{ $guru->nama }} ({{ $guru->nip }})
                    </option>
                    @endforeach
                </select>
                @error('guru_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Pilih Mata Pelajaran (digabung dengan Kelas) --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Mata Pelajaran & Kelas</span>
                <select
                    name="mapel_kelas_combined_id" {{-- <-- NAMA BARU UNTUK INPUT INI --}}
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300"
                    required
                >
                    <option value="">-- Pilih Mapel dan Kelas --</option>
                    {{-- $mapelsWithKelas sudah berisi data yang sudah digabung dari controller --}}
                    @foreach($mapelsWithKelas as $mk)
                    <option value="{{ $mk['id'] }}" {{ $selectedCombinedId == $mk['id'] ? 'selected' : '' }}>
                        {{ $mk['nama_tampil'] }}
                    </option>
                    @endforeach
                </select>
                @error('mapel_kelas_combined_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Pilih Kelas --}}
            {{-- <label class="block mt-4 text-sm"> --}}
            {{--    <span class="text-gray-700 dark:text-gray-400">Kelas</span> --}}
            {{--    <select --}}
            {{--        name="kelas_id" --}}
            {{--        class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300" --}}
            {{--    > --}}
            {{--        <option value="">-- Pilih Kelas --</option> --}}
            {{--        @foreach($kelas as $k) --}}
            {{--        <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id) == $k->id ? 'selected' : '' }}> --}}
            {{--            {{ $k->nama_kelas }} --}}
            {{--        </option> --}}
            {{--        @endforeach --}}
            {{--    </select> --}}
            {{--    @error('kelas_id') --}}
            {{--        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span> --}}
            {{--    @enderror --}}
            {{-- </label> --}}
            {{-- ^^^^^ Ini adalah bagian yang dihapus sesuai permintaanmu ^^^^^ --}}

            {{-- Tahun Ajaran --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tahun Ajaran (Optional)</span>
                <input
                    type="text"
                    name="tahun_ajaran"
                    value="{{ old('tahun_ajaran', $data->tahun_ajaran) }}"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Contoh: 2024/2025"
                />
                @error('tahun_ajaran')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Submit --}}
            <div class="flex justify-end mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700"
                >
                    {{ isset($guruMapel) && $guruMapel->exists ? 'Update' : 'Simpan' }} Guru Mapel
                </button>
            </div>
        </form>
    </div>
</div>