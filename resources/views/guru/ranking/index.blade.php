@extends('layouts.app')
@section('title', 'Peringkat Siswa')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Peringkat Akademik Siswa
    </h2>

    @if ($daftarKelasWali->isNotEmpty())
        <div class="p-4 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('guru.ranking.index') }}" method="GET" class="flex flex-col space-y-4 md:flex-row md:items-end md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        @foreach ($daftarKelasWali as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id', $kelasTerpilih->id) == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="tahun_ajaran" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        @foreach ($daftarTahunAjaran as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_ajaran', $daftarTahunAjaran->first()) == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester</label>
                    <select name="semester" id="semester" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                         @foreach ($daftarSemester as $semester)
                            <option value="{{ $semester }}" {{ request('semester', $daftarSemester->first()) == $semester ? 'selected' : '' }} class="capitalize">{{ $semester }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
             <h3 class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
                Daftar Peringkat Kelas: <span class="text-purple-600">{{ $kelasTerpilih->nama_kelas }}</span>
            </h3>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Peringkat</th>
                            <th class="px-4 py-3">Nama Siswa</th>
                            <th class="px-4 py-3">NISN</th>
                            <th class="px-4 py-3">Total Nilai</th>
                            <th class="px-4 py-3">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($rankings as $ranking)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-lg font-bold">
                                {{ $ranking->ranking_kelas }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold">
                                {{ $ranking->siswa->nama ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $ranking->siswa->nisn ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ number_format($ranking->total_nilai, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold">
                                {{ number_format($ranking->rata_rata_nilai, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center dark:text-gray-300">
                                Data peringkat untuk periode yang dipilih belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col items-center justify-between px-4 py-3 border-t dark:border-gray-700 md:flex-row bg-gray-50 dark:bg-gray-800">
                <div>
                    {{ $rankings->links() }}
                </div>
                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                    Halaman {{ $rankings->currentPage() }} dari {{ $rankings->lastPage() }} |
                    Menampilkan {{ $rankings->firstItem() ?? 0 }} - {{ $rankings->lastItem() ?? 0 }} dari total {{ $rankings->total() }} siswa
                </div>
            </div>
        </div>

    @else
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                Anda tidak ditugaskan sebagai wali kelas, sehingga tidak dapat melihat data peringkat.
            </p>
        </div>
    @endif
</div>
@endsection