@extends('layouts.app')
@section('title', 'Daftar Nilai')

@section('content')
<div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Daftar Nilai: {{ $siswa->nama }}
    </h2>

    <div class="p-4 mb-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('siswa.nilai.index') }}" method="GET" class="flex flex-col space-y-4 md:flex-row md:items-end md:space-y-0 md:space-x-4">
            <div class="flex-1">
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Ajaran</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Semua</option>
                    @foreach ($daftarTahunAjaran as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
             <div class="flex-1">
                <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester</label>
                <select name="semester" id="semester" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Semua</option>
                    <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="">Semua</option>
                    @foreach ($daftarMapel as $mapel)
                        <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Guru</th>
                        <th class="px-4 py-3">Jenis Nilai</th>
                        <th class="px-4 py-3">Tahun Ajaran</th>
                        <th class="px-4 py-3">Semester</th>
                        <th class="px-4 py-3 text-center">Nilai</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($semuaNilai as $nilai)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm font-semibold">{{ $nilai->mapel->nama ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $nilai->guru->nama ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $nilai->jenis_nilai }}</td>
                        <td class="px-4 py-3 text-sm">{{ $nilai->tahun_ajaran }}</td>
                        <td class="px-4 py-3 text-sm"><span class="capitalize">{{ $nilai->semester }}</span></td>
                        <td class="px-4 py-3 text-lg font-semibold text-center">
                            <span class="px-3 py-1 rounded-full {{ $nilai->nilai >= 75 ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100' : 'text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700' }}">
                                {{ $nilai->nilai }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                            Tidak ada data nilai yang cocok dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between px-4 py-3 border-t dark:border-gray-700 md:flex-row bg-gray-50 dark:bg-gray-800">
            <div>
                {{ $semuaNilai->links() }}
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $semuaNilai->currentPage() }} dari {{ $semuaNilai->lastPage() }} |
                Menampilkan {{ $semuaNilai->firstItem() ?? 0 }} - {{ $semuaNilai->lastItem() ?? 0 }} dari total {{ $semuaNilai->total() }} data
            </div>
        </div>
    </div>
</div>
@endsection