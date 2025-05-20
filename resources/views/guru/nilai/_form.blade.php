@php
    $data = optional($nilai);
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($nilai) ? 'Edit' : 'Tambah' }} Nilai
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($nilai) ? route('admin.nilai.update', $nilai->id) : route('admin.nilai.store') }}"
            method="POST">
            @csrf
            @if (isset($nilai))
                @method('PUT')
            @endif

            {{-- Siswa --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Siswa</span>
                <select name="siswa_id" class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id', $data->siswa_id) == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Mapel --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Mata Pelajaran</span>
                <select name="mapel_id" class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300" required>
                    <option value="">-- Pilih Mapel --</option>
                    @foreach ($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mapel_id', $data->mapel_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Jenis Nilai --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Jenis Nilai</span>
                <select name="jenis_nilai" class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300" required>
                    <option value="">-- Pilih Jenis Nilai --</option>
                    <option value="Tugas" {{ old('jenis_nilai', $data->jenis_nilai) == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                    <option value="Ulangan" {{ old('jenis_nilai', $data->jenis_nilai) == 'Ulangan' ? 'selected' : '' }}>Ulangan</option>
                    <option value="UTS" {{ old('jenis_nilai', $data->jenis_nilai) == 'UTS' ? 'selected' : '' }}>UTS</option>
                    <option value="UAS" {{ old('jenis_nilai', $data->jenis_nilai) == 'UAS' ? 'selected' : '' }}>UAS</option>
                </select>
                @error('jenis_nilai')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Nilai --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nilai</span>
                <input type="number" name="nilai" min="0" max="100" required
                    class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input"
                    placeholder="Masukkan nilai, contoh: 85" value="{{ old('nilai', $data->nilai) }}">
                @error('nilai')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Semester --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Semester</span>
                <select name="semester" class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="Ganjil" {{ old('semester', $data->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester', $data->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Tahun Ajaran --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tahun Ajaran</span>
                <input type="text" name="tahun_ajaran" required
                    class="block w-full mt-1 text-sm dark:bg-gray-700 dark:text-gray-300 form-input"
                    placeholder="Contoh: 2024/2025" value="{{ old('tahun_ajaran', $data->tahun_ajaran) }}">
                @error('tahun_ajaran')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Submit --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                    {{ isset($nilai) ? 'Update' : 'Simpan' }} Nilai
                </button>
            </div>
        </form>
    </div>
</div>
