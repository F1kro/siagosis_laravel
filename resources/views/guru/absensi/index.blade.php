@extends('layouts.app')

@section('title', 'GURU | DATA ABSENSI > ' . ($selectedKelas->nama_kelas ?? ''))

@section('content')
    <div class="w-full overflow-hidden rounded-lg">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang🎓, {{ Auth::user()->name ?? 'Guru' }}
        </h2>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between p-4 mb-4 text-sm bg-green-500 rounded-lg shadow-md dark:bg-green-500 dark:text-white"
                role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between p-4 mb-4 text-sm text-red-800 rounded-lg shadow-md bg-red-50 dark:bg-red-800 dark:text-red-200"
                role="alert">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <p class="font-medium">Harap perbaiki kesalahan di bawah ini:</p>
                <ul class="mt-1.5 ml-4 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('guru.dashboard') }}" class="hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('guru.absensi.dashboard') }}" class="hover:underline">Pilih Kelas Absensi</a>
                <span class="mx-2">/</span>
                Data Kehadiran Kelas {{ $selectedKelas->nama_kelas ?? 'Tidak Diketahui' }}
            </p>
        </div>

        <div class="flex flex-col items-start gap-4 mb-4 md:flex-row md:items-center">
            <form action="{{ route('guru.absensi.index', ['kelas_id' => $selectedKelas->id]) }}" method="GET"
                  class="flex flex-wrap items-center w-full gap-2">
                <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id }}">

                <select name="mapel_id" class="px-3 py-3 text-sm border rounded-md dark:border-none">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelOptions as $mapel)
                        <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
                    @endforeach
                </select>

                <select name="status" class="px-3 py-3 text-sm border rounded-md dark:border-none">
                    <option value="">Semua Status</option>
                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                </select>

                <input type="date" name="tanggal" class="px-3 py-3 text-sm border rounded-md dark:border-none" value="{{ $tanggal == 'all' ? '' : $tanggal }}">

                <input type="text" name="search" placeholder="Cari nama siswa..."
                    value="{{ request('search') }}"
                    class="flex-grow px-3 py-3 text-sm border rounded-md dark:border-none"
                />

                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Filter
                </button>

                <a href="{{ route('guru.absensi.index', ['kelas_id' => $selectedKelas->id, 'tanggal' => 'all', 'status' => request('status'), 'search' => request('search'), 'mapel_id' => request('mapel_id')]) }}"
                   class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:text-gray-300">
                   Lihat Semua Tanggal
                </a>

                @if(request('kelas_id') || request('status') || request('tanggal') != \Carbon\Carbon::today()->toDateString() || request('search') || request('mapel_id'))
                    <a href="{{ route('guru.absensi.index', ['kelas_id' => $selectedKelas->id, 'tanggal' => \Carbon\Carbon::today()->toDateString()]) }}" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-md dark:text-gray-300 hover:bg-gray-300">Reset Filter</a>
                @endif
            </form>
        </div>

        <div class="flex justify-start w-full gap-2 mb-4">
            {{-- PERBAIKAN DI SINI: Gunakan $tanggal aktif dari halaman index --}}
            <a href="{{ route('guru.absensi.inputAbsensi', ['kelas_id' => $selectedKelas->id, 'tanggal' => $tanggal, 'mapel_id' => request('mapel_id')]) }}"
                class="px-4 py-3 text-sm text-white bg-purple-600 rounded-md hover:bg-purple-700">
                <i class="mr-1 fas fa-plus"></i> Input/Edit Absensi Tanggal Ini
            </a>
            <button type="button" onclick="confirmDeleteMassalAbsensi('{{ $selectedKelas->id }}', '{{ $tanggal }}', '{{ request('mapel_id') }}')"
                class="px-4 py-3 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                <i class="mr-1 fas fa-trash"></i> Hapus Absensi Tanggal Ini
            </button>
        </div>


        <div class="w-full overflow-x-auto rounded-lg">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Siswa</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Mapel</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($absensi as $index => $k)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">{{ $absensi->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $k->siswa->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $k->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $k->mapel->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full
                                    {{ $k->status == 'Hadir' ? 'text-green-700 bg-green-100' : '' }}
                                    {{ $k->status == 'Izin' ? 'text-blue-700 bg-blue-100' : '' }}
                                    {{ $k->status == 'Sakit' ? 'text-orange-700 bg-orange-100' : '' }}
                                    {{ $k->status == 'Alpa' ? 'text-red-700 bg-red-100' : '' }}
                                    dark:bg-opacity-50
                                ">
                                    {{ $k->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">{{ $k->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $k->waktu ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-6 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-clipboard-check"></i>
                                <p class="mb-2">
                                    @if($tanggal == \Carbon\Carbon::today()->toDateString())
                                        Tidak ada data kehadiran untuk hari ini di kelas ini.
                                    @elseif($tanggal == 'all')
                                        Tidak ada data kehadiran sama sekali di kelas ini.
                                    @else
                                        Tidak ada data kehadiran untuk tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }} di kelas ini.
                                    @endif
                                </p>
                                <a href="{{ route('guru.absensi.inputAbsensi', ['kelas_id' => $selectedKelas->id, 'tanggal' => \Carbon\Carbon::today()->toDateString(), 'mapel_id' => request('mapel_id')]) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded hover:bg-purple-700">
                                    <i class="mr-2 fas fa-plus"></i> Input Absensi Hari Ini
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between py-4 md:flex-row">
            <div>
                {{ $absensi->appends(['kelas_id' => $selectedKelas->id, 'tanggal' => $tanggal, 'status' => request('status'), 'search' => request('search'), 'mapel_id' => request('mapel_id')])->links('pagination::tailwind') }}
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $absensi->currentPage() }} dari {{ $absensi->lastPage() }} |
                Menampilkan {{ $absensi->firstItem() }} - {{ $absensi->lastItem() }} dari total {{ $absensi->total() }} data
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteMassalAbsensi(kelasId, tanggal, mapelId) {
            Swal.fire({
                title: 'Yakin hapus absensi?',
                html: `Apakah Anda yakin ingin menghapus **SEMUA** absensi untuk kelas ini (${kelasId}) pada tanggal <strong>${tanggal}</strong> untuk mata pelajaran ini? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus semua!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('guru.absensi.destroy') }}";

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    const kelasIdInput = document.createElement('input');
                    kelasIdInput.type = 'hidden';
                    kelasIdInput.name = 'kelas_id';
                    kelasIdInput.value = kelasId;

                    const tanggalInput = document.createElement('input');
                    tanggalInput.type = 'hidden';
                    tanggalInput.name = 'tanggal';
                    tanggalInput.value = tanggal;

                    const mapelIdInput = document.createElement('input');
                    mapelIdInput.type = 'hidden';
                    mapelIdInput.name = 'mapel_id';
                    mapelIdInput.value = mapelId;

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    form.appendChild(kelasIdInput);
                    form.appendChild(tanggalInput);
                    form.appendChild(mapelIdInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection