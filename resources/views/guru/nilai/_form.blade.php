<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($nilai) && $nilai->exists ? 'Edit' : 'Tambah' }} Nilai
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form
            action="{{ isset($nilai) && $nilai->exists ? route('guru.nilai.update', $nilai->id) : route('guru.nilai.store') }}"
            method="POST">
            @csrf
            @if (isset($nilai) && $nilai->exists)
                @method('PUT')
            @endif

            @if (request()->has('kelas_id'))
                <input type="hidden" name="kelas_id" value="{{ request('kelas_id') }}">
            @endif

            {{-- Siswa --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Siswa</span>
                <select name="siswa_id" required
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $s)
                        {{-- Gunakan $nilai->siswa_id ?? '' untuk mengambil nilai lama, aman jika $nilai null --}}
                        <option value="{{ $s->id }}"
                            {{ old('siswa_id', $nilai->siswa_id ?? '') == $s->id ? 'selected' : '' }}>
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
                <span class="text-700 dark:text-gray-400">Mata Pelajaran</span>
                <select name="mapel_id" required
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach ($mapel as $m)
                        {{-- Gunakan $nilai->mapel_id ?? '' untuk mengambil nilai lama --}}
                        <option value="{{ $m->id }}"
                            {{ old('mapel_id', $nilai->mapel_id ?? '') == $m->id ? 'selected' : '' }}>
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
                <select name="jenis_nilai" required
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Jenis Nilai --</option>
                    @foreach (['Tugas', 'Ulangan', 'UTS', 'UAS'] as $jenis)
                        {{-- Gunakan $nilai->jenis_nilai ?? '' untuk mengambil nilai lama --}}
                        <option value="{{ $jenis }}"
                            {{ old('jenis_nilai', $nilai->jenis_nilai ?? '') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
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
                    placeholder="Masukkan nilai, contoh: 85" value="{{ old('nilai', $nilai->nilai ?? '') }}">
                {{-- Gunakan $nilai->nilai ?? '' --}}
                @error('nilai')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Semester --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Semester</span>
                <select name="semester" required
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Semester --</option>
                    @foreach (['Ganjil', 'Genap'] as $smt)
                        {{-- Gunakan $nilai->semester ?? '' untuk mengambil nilai lama --}}
                        <option value="{{ $smt }}"
                            {{ old('semester', $nilai->semester ?? '') == $smt ? 'selected' : '' }}>
                            {{ $smt }}
                        </option>
                    @endforeach
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
                    placeholder="Contoh: 2024/2025" value="{{ old('tahun_ajaran', $nilai->tahun_ajaran ?? '') }}">
                {{-- Gunakan $nilai->tahun_ajaran ?? '' --}}
                @error('tahun_ajaran')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>



            {{-- Submit Button --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                    {{ isset($nilai) && $nilai->exists ? 'Update' : 'Simpan' }} Nilai
                </button>
            </div>
        </form>
    </div>
</div>
