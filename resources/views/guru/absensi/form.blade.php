@extends('layouts.app')

@section('title', 'Input/Edit Absensi Kelas ' . ($selectedKelas->nama_kelas ?? '') . ' Tanggal ' . \Carbon\Carbon::parse($tanggal)->format('d/m/Y'))

@section('content')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Input/Edit Absensi Kelas {{ $selectedKelas->nama_kelas ?? 'Tidak Diketahui' }} - Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}
        </h2>

        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('guru.dashboard') }}" class="hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('guru.absensi.dashboard') }}" class="hover:underline">Pilih Kelas Absensi</a>
                <span class="mx-2">/</span>
                {{-- PERBAIKAN DI SINI: Tambahkan mapel_id ke route index --}}
                <a href="{{ route('guru.absensi.index', ['kelas_id' => $selectedKelas->id, 'tanggal' => $tanggal, 'mapel_id' => $mapelId]) }}" class="hover:underline">Data Kehadiran</a>
                <span class="mx-2">/</span>
                Input/Edit Absensi
            </p>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('guru.absensi.store') }}" method="POST">
                @csrf

                {{-- Hidden Inputs --}}
                <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                {{-- Pilihan Semester dan Tahun Ajaran --}}
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                            <input type="text" value="{{ $selectedKelas->nama_kelas }}" readonly
                                class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300">
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Tanggal Absensi</span>
                            <input type="date" value="{{ $tanggal }}" readonly
                                class="block w-full mt-1 text-sm form-input dark:bg-gray-700 dark:text-gray-300">
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-2">
                    <div>
                        <label for="semester" class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Semester:</span>
                            <select name="semester" id="semester"
                                class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    <div>
                        <label for="tahun_ajaran" class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Tahun Ajaran:</span>
                            <select name="tahun_ajaran" id="tahun_ajaran"
                                class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                                @php
                                    $tahunSekarang = date('Y');
                                    $tahunMulai = $tahunSekarang - 3;
                                    $tahunSelesai = $tahunSekarang + 5;
                                @endphp
                                @for ($i = $tahunMulai; $i <= $tahunSelesai; $i++)
                                    <option value="{{ $i }}/{{ $i + 1 }}" {{ old('tahun_ajaran') == $i . '/' . ($i + 1) ? 'selected' : '' }}>
                                        {{ $i }}/{{ $i + 1 }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun_ajaran')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="mapel_id" class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Mata Pelajaran:</span>
                        <select name="mapel_id" id="mapel_id" required
                            class="block w-full mt-1 text-sm form-select dark:bg-gray-700 dark:text-gray-300">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapelOptions as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mapel_id', $mapelId) == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('mapel_id')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <h3 class="my-6 text-lg font-semibold text-gray-700 dark:text-gray-200">
                    Daftar Siswa
                </h3>

                <div class="w-full overflow-x-auto rounded-lg shadow-md">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3 text-center" colspan="4">Status Kehadiran</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3">Waktu Input</th>
                            </tr>
                            <tr class="text-xs font-semibold tracking-wide text-center text-gray-500 uppercase bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th colspan="2"></th>
                                <th class="px-4 py-1">Hadir</th>
                                <th class="px-4 py-1">Izin</th>
                                <th class="px-4 py-1">Sakit</th>
                                <th class="px-4 py-1">Alpa</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @forelse($siswas as $index => $siswa)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $siswa->nama }}
                                        <input type="hidden" name="absensi_data[{{ $index }}][siswa_id]" value="{{ $siswa->id }}">
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <input type="radio" class="text-green-500 form-radio dark:bg-gray-700 dark:border-gray-600"
                                            name="absensi_data[{{ $index }}][status]" value="Hadir" required
                                            {{ old('absensi_data.' . $index . '.status', $formattedExistingAbsensi[$siswa->id]['status'] ?? 'Hadir') == 'Hadir' ? 'checked' : '' }}>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input type="radio" class="text-blue-500 form-radio dark:bg-gray-700 dark:border-gray-600"
                                            name="absensi_data[{{ $index }}][status]" value="Izin" required
                                            {{ old('absensi_data.' . $index . '.status', $formattedExistingAbsensi[$siswa->id]['status'] ?? 'Hadir') == 'Izin' ? 'checked' : '' }}>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input type="radio" class="text-orange-500 form-radio dark:bg-gray-700 dark:border-gray-600"
                                            name="absensi_data[{{ $index }}][status]" value="Sakit" required
                                            {{ old('absensi_data.' . $index . '.status', $formattedExistingAbsensi[$siswa->id]['status'] ?? 'Hadir') == 'Sakit' ? 'checked' : '' }}>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input type="radio" class="text-red-500 form-radio dark:bg-gray-700 dark:border-gray-600"
                                            name="absensi_data[{{ $index }}][status]" value="Alpa" required
                                            {{ old('absensi_data.' . $index . '.status', $formattedExistingAbsensi[$siswa->id]['status'] ?? 'Hadir') == 'Alpa' ? 'checked' : '' }}>
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        <input type="text" name="absensi_data[{{ $index }}][keterangan]"
                                            class="block w-full text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                                            value="{{ old('absensi_data.' . $index . '.keterangan', $formattedExistingAbsensi[$siswa->id]['keterangan'] ?? '') }}"
                                            placeholder="Keterangan">
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <input type="time" name="absensi_data[{{ $index }}][waktu]"
                                            class="block w-full text-sm form-input dark:bg-gray-700 dark:text-gray-300"
                                            value="{{ old('absensi_data.' . $index . '.waktu', $formattedExistingAbsensi[$siswa->id]['waktu'] ?? '') }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-6 text-center text-gray-500">
                                        <p>Tidak ada siswa di kelas ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @error('absensi_data')
                    <span class="block mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
                @error('absensi_data.*.status')
                    <span class="block mt-2 text-xs text-red-600 dark:text-red-400">Pastikan semua status kehadiran diisi.</span>
                @enderror

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium leading-5 text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                        Simpan Absensi
                    </button>
                    <a href="{{ route('guru.absensi.index', ['kelas_id' => $selectedKelas->id, 'tanggal' => $tanggal, 'mapel_id' => $mapelId]) }}"
                        class="px-4 py-2 ml-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection