@extends('layouts.app')

@section('title', 'SIAGOSIS | MASTER GURU-MAPEL')

@section('content')
    <div class="w-full overflow-hidden rounded-lg">

        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang🎉, {{ $name }}
        </h2>

        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Dashboard > Data Guru Mapel
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

        <div class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
            <form action="{{ route('admin.guru-mapel.index') }}" method="GET"
                class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
                <input type="text" name="search" placeholder="Cari Guru atau Mapel..." value="{{ $search ?? '' }}"
                    class="w-full px-3 py-3 mr-2 text-sm border rounded-md dark:border-none sm:w-48 sm:mr-2 sm:mb-2" />
                <button type="submit" class="hidden">Cari</button>
            </form>

            <div class="ml-2 sm:ml-0">
                <a href="{{ route('admin.guru-mapel.create') }}"
                    class="w-full px-4 py-3 text-sm text-white bg-blue-600 rounded-md sm:w-auto hover:bg-blue-700">
                    Tambah Guru Mapel
                </a>
            </div>
        </div>

        <div class="w-full overflow-x-auto rounded-lg">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">No.</th>
                        <th class="px-4 py-3">Nama Guru</th>
                        <th class="px-4 py-3">Mata Pelajaran</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Tahun Ajaran</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($guruMapel as $index => $gm)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">{{ $guruMapel->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm">{{ $gm->guru->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $gm->mapel->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $gm->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $gm->tahun_ajaran ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <a href="{{ route('admin.guru-mapel.edit', $gm->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $gm->id }}, '{{ $gm->guru->nama ?? '-' }}')"
                                        class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-user-slash"></i>
                                <p class="mb-2">Tidak ada data guru mapel</p>
                                <a href="{{ route('admin.guru-mapel.create') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                    <i class="mr-2 fas fa-plus"></i> Tambah Guru Mapel
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between py-4 md:flex-row">
            <div>
                {{ $guruMapel->links('pagination::tailwind') }}
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $guruMapel->currentPage() }} dari {{ $guruMapel->lastPage() }} |
                Menampilkan {{ $guruMapel->firstItem() }} - {{ $guruMapel->lastItem() }} dari total
                {{ $guruMapel->total() }} data
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Yakin hapus data?',
                html: `Apakah Anda yakin ingin menghapus data guru mapel dari <strong>${name}</strong>?`,
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
                    form.action = `/admin/guru-mapel/${id}`;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    form.appendChild(csrfInput);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(methodInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
