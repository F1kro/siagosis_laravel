@extends('layouts.app')

@section('title', 'SIAGOSIS | MASTER ORTU')

@section('content')
    <div class="w-full overflow-hidden rounded-lg ">
             @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border mt-8 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg @click="show = false" class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.697z"/></svg>
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="bg-red-100 border mt-8 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Gagal</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg @click="show = false" class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.697z"/></svg>
                    </span>
                </div>
            @endif
            
            <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
                Selamat Datang🎉, {{ $name }}
            </h2>
            <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900 ">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Dashboard > Data Orang Tua
                </p>
            </div>
             <div class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
                <form action="{{ route('admin.ortu.index') }}" method="GET" class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
                   <div class="flex flex-col items-start gap-2 ml-2 sm:flex-row sm:items-center">
                       <!-- Search Input -->
                       <input
                           type="text"
                           name="search"
                           placeholder="Cari Orangtua..."
                           value="{{ request('search') }}"
                           class="w-full px-3 py-3 mr-2 text-sm border rounded-md dark:border-none sm:w-48 sm:mr-2 sm:mb-2"
                       />
                   </div>

                   <!-- Submit Button (hidden if using onchange for select) -->
                   <button type="submit" class="hidden">Cari</button>
               </form>
                <div class="ml-2 sm:ml-0">
                    <a href="{{ route('admin.ortu.create') }}" class="w-full px-4 py-3 text-sm text-white bg-blue-600 rounded-md sm:w-auto hover:bg-blue-700">
                        Tambah OrangTua
                    </a>
                </div>
            </div>
            <div class="w-full overflow-x-auto rounded-lg">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">No.</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Telp.</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Pekerjaan</th>
                            <th class="px-4 py-3">Wali dari</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($orangtua as $index => $s)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{ $orangtua->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                     {{-- {{ $s->orangtua->nama ?? '-' }} ===> gaperlu  object orantua lagi, lgsg attribute (nama, dll) --}}
                                     {{ $s->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $s->telepon ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $s->alamat ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $s->pekerjaan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $s && $s->siswa ? $s->siswa->nama : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="{{ route('admin.ortu.edit', $s->id) }}"
                                            class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete({{ $s->id }}, '{{ $s->orangtua?->nama ?? 'Orangtua' }}')"
                                            class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                                    <i class="mb-2 text-3xl fas fa-user-slash"></i>
                                    <p class="mb-2">Tidak ada data orang tua</p>
                                    <a href="{{ route('admin.ortu.create') }}"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                        <i class="mr-2 fas fa-plus"></i> Tambah Ortu
                                    </a>
                                </td>
                            </tr>
                        @endforelse()
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col items-center justify-between py-4 md:flex-row">
                {{-- Pagination links --}}
                <div>
                    {{ $orangtua->links('pagination::tailwind') }}
                </div>

                {{-- Page info --}}
                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                    Halaman {{ $orangtua->currentPage() }} dari {{ $orangtua->lastPage() }} |
                    Menampilkan {{ $orangtua->firstItem() }} - {{ $orangtua->lastItem() }} dari total {{ $orangtua->total() }} data
                </div>
            </div>
    </div>

    {{-- Modal Hapus guru --}}
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Yakin hapus guru?',
                html: `Apakah Anda yakin ingin menghapus orangtua <strong>${name}</strong>?`,
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
                    form.action = `/admin/ortu/${id}`;

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
