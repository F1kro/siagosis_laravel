@extends('layouts.app')

@section('title', 'SIAGOSIS | MASTER JADWAL')

@section('content')
    <div class="w-full overflow-hidden rounded-lg">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang🎉, {{ Auth::user()->name ?? 'Admin' }}
        </h2>

        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
                Data Jadwal Pelajaran
            </p>
        </div>

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

        <div class="flex flex-col items-start gap-4 mb-4 md:flex-row md:items-center">
            <form action="{{ route('admin.jadwal.index') }}" method="GET"
                class="flex flex-wrap items-center w-full gap-2">
                <select name="kelas_id" class="px-3 py-3 text-sm border rounded-md dark:border-none">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="hari" class="px-3 py-3 text-sm border rounded-md dark:border-none">
                    <option value="">Semua Hari</option>
                    @foreach ($hariList as $key => $value)
                        <option value="{{ $key }}" {{ request('hari') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun_ajaran" class="px-3 py-3 text-sm border rounded-md dark:border-none">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta }}" {{ request('tahun_ajaran') == $ta ? 'selected' : '' }}>
                            {{ $ta }}
                        </option>
                    @endforeach
                </select>

                <select name="semester" class="px-3 py-3 text-sm border rounded-md dark:border-none">
                    <option value="">Semua Semester</option>
                    @foreach ($semesterList as $smt)
                        <option value="{{ $smt }}" {{ request('semester') == $smt ? 'selected' : '' }}>
                            {{ $smt }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Filter
                </button>

                @if (request('kelas_id') || request('hari') || request('tahun_ajaran') || request('semester'))
                    <a href="{{ route('admin.jadwal.index') }}"
                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:text-gray-300">Reset</a>
                @endif
            </form>
        </div>

        <div class="flex justify-start w-full gap-2 mb-4">
            <a href="{{ route('admin.jadwal.create') }}"
                class="px-4 py-3 text-sm text-white bg-purple-600 rounded-md hover:bg-purple-700">
                <i class="mr-1 fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>

        <div class="w-full overflow-x-auto rounded-lg">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Guru</th>
                        <th class="px-4 py-3">Hari</th>
                        <th class="px-4 py-3">Jam Mulai</th>
                        <th class="px-4 py-3">Jam Selesai</th>
                        <th class="px-4 py-3">Ruangan</th>
                        <th class="px-4 py-3">Tahun Ajaran</th>
                        <th class="px-4 py-3">Semester</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($jadwal as $index => $j)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">{{ $jadwal->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm">{{ $j->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $j->mapel->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $j->guru->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $hariList[strtolower($j->hari)] ?? $j->hari }}</td>
                            <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</td>
                            <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                            <td class="px-4 py-3 text-sm">{{ $j->ruangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $j->tahun_ajaran ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $j->semester ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="{{ route('admin.jadwal.edit', $j->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                        onclick="confirmDelete('{{ $j->id }}', '{{ $j->kelas->nama_kelas ?? '' }} - {{ $j->mapel->nama ?? '' }}')"
                                        class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-6 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-calendar-alt"></i>
                                <p class="mb-2">Tidak ada data jadwal ditemukan.</p>
                                <a href="{{ route('admin.jadwal.create') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded hover:bg-purple-700">
                                    <i class="mr-2 fas fa-plus"></i> Tambah Jadwal
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between py-4 md:flex-row">
            <div>
                {{ $jadwal->appends(request()->query())->links('pagination::tailwind') }}
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $jadwal->currentPage() }} dari {{ $jadwal->lastPage() }} |
                Menampilkan {{ $jadwal->firstItem() }} - {{ $jadwal->lastItem() }} dari total {{ $jadwal->total() }} data
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Yakin hapus jadwal?',
                html: `Apakah Anda yakin ingin menghapus jadwal <strong>${name}</strong>? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/jadwal/${id}`;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
