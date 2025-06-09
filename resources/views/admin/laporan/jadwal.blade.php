@extends('layouts.app')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Laporan Jadwal Pelajaran
        </h2>

        <div class="px-4 py-4 mb-4 bg-white rounded-lg shadow-md dark:text-gray-400 dark:bg-gray-800">
            <i class="fa fa-backward-step" aria-hidden="true"></i>
           <a href="{{ route('admin.laporan.index') }}">Kembali ke menu laporan</a>
       </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Filter Laporan</h4>
                @if($jadwalByHari->isNotEmpty())
                <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                    class="px-3 py-1 text-sm font-bold leading-5 text-black duration-150 bg-green-600 border border-transparent rounded-md translate-x-1ansition-colors dark:text-white active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                    <i class="mr-2 fas fa-file-excel"></i>
                    <span>Export to Excel</span>
                </a>
                @endif
            </div>
            <form action="{{ route('admin.laporan.jadwal') }}" method="GET">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Kelas</span>
                        <select name="kelas_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Hari</span>
                        <select name="hari" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="">Semua Hari</option>
                            <option value="Senin" {{ request('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                            <option value="Selasa" {{ request('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                            <option value="Rabu" {{ request('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                            <option value="Kamis" {{ request('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                            <option value="Jumat" {{ request('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                            <option value="Sabtu" {{ request('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        </select>
                    </label>
                    <div class="flex items-end mt-4">
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($jadwalByHari->isEmpty())
            <div class="p-4 text-blue-700 bg-blue-100 rounded-lg shadow-xs dark:bg-blue-700 dark:text-blue-100">
                Pilih kelas untuk melihat jadwal pelajaran.
            </div>
        @else
            @foreach($jadwalByHari as $hari => $jadwals)
            <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">{{ $hari }}</h4>
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Jam</th>
                                <th class="px-4 py-3">Mata Pelajaran</th>
                                <th class="px-4 py-3">Guru</th>
                                <th class="px-4 py-3">Ruangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach($jadwals as $jadwal)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $jadwal->mapel->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $jadwal->guru->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $jadwal->ruangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</main>
@endsection