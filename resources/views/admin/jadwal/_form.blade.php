@php
    $data = optional($jadwal ?? null); // Menggunakan $jadwal sebagai data utama
@endphp

<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{ isset($jadwal) && $jadwal->exists ? 'Edit' : 'Tambah' }} Jadwal Pelajaran
    </h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ isset($jadwal) && $jadwal->exists ? route('admin.jadwal.update', $jadwal->id) : route('admin.jadwal.store') }}" method="POST">
            @csrf
            @if(isset($jadwal) && $jadwal->exists)
                @method('PUT')
            @endif

            {{-- Pilih Kelas --}}
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                <select name="kelas_id" id="kelas_id" required class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $data->kelas_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Pilih Mata Pelajaran --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Mata Pelajaran</span>
                <select name="mapel_id" required class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}" {{ old('mapel_id', $data->mapel_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Pilih Guru --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Guru Pengajar</span>
                <select name="guru_id" required class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}" {{ old('guru_id', $data->guru_id) == $g->id ? 'selected' : '' }}>
                            {{ $g->nama }} ({{ $g->nip }})
                        </option>
                    @endforeach
                </select>
                @error('guru_id')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Pilih Hari --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Hari</span>
                <select name="hari" required class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Hari --</option>
                    @foreach($hariList as $key => $value)
                        <option value="{{ $key }}" {{ old('hari', $data->hari) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('hari')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Jam Mulai --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Jam Mulai</span>
                <input type="time" name="jam_mulai" required
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    value="{{ old('jam_mulai', $data->jam_mulai ? \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') : '') }}">
                @error('jam_mulai')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Jam Selesai --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Jam Selesai</span>
                <input type="time" name="jam_selesai" required
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    value="{{ old('jam_selesai', $data->jam_selesai ? \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') : '') }}">
                @error('jam_selesai')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Ruangan (input biasa, default dari controller jika kosong) --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Ruangan (Opsional, Default: Nama Kelas)</span>
                <input type="text" name="ruangan"
                    class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Biarkan kosong untuk menggunakan nama kelas sebagai ruangan" value="{{ old('ruangan', $data->ruangan) }}">
                @error('ruangan')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Tahun Ajaran --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tahun Ajaran</span>
                <select name="tahun_ajaran" id="tahun_ajaran" required
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach($tahunAjaranList as $ta)
                        <option value="{{ $ta }}" {{ old('tahun_ajaran', $data->tahun_ajaran) == $ta ? 'selected' : '' }}>
                            {{ $ta }}
                        </option>
                    @endforeach
                </select>
                @error('tahun_ajaran')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Semester --}}
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Semester</span>
                <select name="semester" id="semester" required
                    class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                    <option value="">-- Pilih Semester --</option>
                    @foreach($semesterList as $smt)
                        <option value="{{ $smt }}" {{ old('semester', $data->semester) == $smt ? 'selected' : '' }}>
                            {{ $smt }}
                        </option>
                    @endforeach
                </select>
                @error('semester')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </label>

            {{-- Submit Button --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                    {{ isset($jadwal) && $jadwal->exists ? 'Update' : 'Simpan' }} Jadwal
                </button>
            </div>
        </form>
    </div>
</div>