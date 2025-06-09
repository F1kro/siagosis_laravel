@extends('layouts.app')

@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Laporan Peringkat Siswa
            </h2>

            <div class="px-4 py-4 mb-4 bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
                <i class="fa fa-backward-step" aria-hidden="true"></i>
                <a href="{{ route('admin.laporan.index') }}">Kembali ke menu laporan</a>
            </div>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Filter Peringkat</h4>
                    @if (!empty($rankingData) && $rankingData->count() > 0)
                        <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                            <i class="mr-2 fas fa-file-excel"></i>
                            <span>Export to Excel</span>
                        </a>
                    @endif
                </div>
                <form action="{{ route('admin.laporan.ranking') }}" method="GET">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                            <select name="kelas_id" required
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Semester</span>
                            <select name="semester" required
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">Pilih Semester</option>
                                <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil
                                </option>
                                <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </label>
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Tahun Ajaran</span>
                            <input name="tahun_ajaran" value="{{ request('tahun_ajaran') }}" required
                                placeholder="Contoh: 2025/2026"
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </label>
                        <div class="flex items-end mt-4">
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if (!empty($rankingData) && $rankingData->count() > 0)
                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="p-4 bg-white rounded-t-lg dark:bg-gray-800">
                        <p class="font-semibold text-gray-700 dark:text-gray-200">
                            Hasil Peringkat untuk Kelas {{ $rankingData->first()->kelas->nama_kelas ?? '' }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Semester: {{ request('semester') }} - Tahun Ajaran: {{ request('tahun_ajaran') }}
                        </p>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Peringkat</th>
                                    <th class="px-4 py-3">NISN</th>
                                    <th class="px-4 py-3">Nama Siswa</th>
                                    <th class="px-4 py-3">Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($rankingData as $data)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm font-semibold">{{ $data->ranking_kelas }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $data->siswa->nisn ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $data->siswa->nama ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm font-bold">
                                            {{ number_format($data->rata_rata_nilai, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif(request()->has('kelas_id'))
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <p class="text-sm text-black dark:text-gray-200">
                        Data peringkat tidak ditemukan untuk filter yang dipilih. Mungkin peringkat belum di-generate untuk
                        periode ini.
                    </p>
                </div>
            @else
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <p class="text-sm text-black dark:text-blue-100">
                        Silakan pilih Kelas, Semester, dan Tahun Ajaran untuk melihat laporan peringkat.
                    </p>
                </div>
            @endif
        </div>
    </main>
@endsection
