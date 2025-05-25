@extends('layouts.app')

@section('title', 'Data Mapel')

@section('content')
<div class="w-full overflow-hidden rounded-lg">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
        Selamat Datang🎉, {{ $name }}
    </h2>

    <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900 ">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Dashboard > Data Mata Pelajaran
        </p>
    </div>

    <div class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
        <form action="{{ route('admin.mapel.index') }}" method="GET"
            class="flex flex-col items-start justify-between gap-4 mb-4 sm:flex-row sm:items-center">
            <div class="flex flex-col items-start gap-2 ml-2 sm:flex-row sm:items-center">
                <input type="text" name="search" placeholder="Cari Mapel..." value="{{ request('search') }}"
                    class="w-full px-3 py-3 mr-2 text-sm border rounded-md dark:border-none sm:w-48 sm:mr-2 sm:mb-2" />
            </div>

            <button type="submit" class="hidden">Cari</button>
        </form>

        <div class="ml-2 sm:ml-0">
            <a href="{{ route('admin.mapel.create') }}"
                class="w-full px-4 py-3 text-sm text-white bg-blue-600 rounded-md sm:w-auto hover:bg-blue-700">
                Tambah Mapel
            </a>
        </div>
    </div>

    <div class="w-full overflow-x-auto rounded-lg">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">No.</th>
                    <th class="px-4 py-3">Kode Mapel</th>
                    <th class="px-4 py-3">Nama Mapel</th>
                    <th class="px-4 py-3">KKM</th>
                    <th class="px-4 py-3">Jumlah Jam</th>
                    <th class="px-4 py-3">Untuk Kelas</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @forelse($mapel as $index => $s)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">
                        {{ $mapel->firstItem() + $index }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $s->kode ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $s->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $s->kkm ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        {{ $s->jumlah_jam ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if ($s->kelas->isNotEmpty())
                            @foreach ($s->kelas as $k)
                                <span class="px-2 py-1 text-xs font-semibold leading-tight">
                                    {{ $k->nama_kelas }}
                                </span><br>
                            @endforeach
                        @else
                            <span class="px-2 py-1 text-xs font-semibold leading-tight ">
                                Belum ada kelas
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                            <a href="{{ route('admin.mapel.edit', $s->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $s->id }}, '{{ $s->nama ?? '-' }}')"
                                class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-6 text-center text-gray-500"> {{-- <-- UBAH colspan SESUAI JUMLAH KOLOM --}}
                        <i class="mb-2 text-3xl fas fa-user-slash"></i>
                        <p class="mb-2">Tidak ada data mapel</p>
                        <a href="{{ route('admin.mapel.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                            <i class="mr-2 fas fa-plus"></i> Tambah Mapel
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col items-center justify-between py-4 md:flex-row">
        {{-- Pagination links --}}
        <div>
            {{ $mapel->links('pagination::tailwind') }}
        </div>

        {{-- Page info --}}
        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
            Halaman {{ $mapel->currentPage() }} dari {{ $mapel->lastPage() }} |
            Menampilkan {{ $mapel->firstItem() }} - {{ $mapel->lastItem() }} dari total {{ $mapel->total() }} data
        </div>
    </div>
</div>

{{-- Modal Hapus Mapel --}}
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Yakin hapus mapel?',
            html: `Apakah Anda yakin ingin menghapus mapel <strong>${name}</strong>?`,
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
                form.action = `/admin/mapel/${id}`;

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