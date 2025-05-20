@extends('layouts.app')

@section('title', 'Master Berita')

@section('content')
    <div class="w-full overflow-hidden rounded-lg">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 capitalize dark:text-gray-200">
            Selamat Datang🎉, {{ $name }}
        </h2>
        <div class="flex px-4 py-3 mb-6 rounded-lg bg-dark-200 dark:bg-gray-900">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Dashboard >  Berita
            </p>
        </div>

        <div class="flex justify-between mb-6">
            <a href="{{ route('admin.berita.create') }}"
                class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                + Tambah Berita
            </a>
        </div>

        <div class="w-full overflow-x-auto rounded-lg">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        <th class="px-4 py-3 border-r">No.</th>
                        <th class="px-4 py-3 border-r">Judul</th>
                        <th class="px-4 py-3 border-r">Kategori</th>
                        <th class="px-4 py-3 border-r">Penulis</th>
                        <th class="px-4 py-3 border-r">Status</th>
                        <th class="px-4 py-3 text-center border-r">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($berita as $index => $b)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ $berita->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 text-sm border-r">{{ \Illuminate\Support\Str::limit($b->judul, 20, '...') }}</td>
                            <td class="px-4 py-3 text-sm border-r">{{ $b->kategori }}</td>
                            <td class="px-4 py-3 text-sm border-r">{{ $b->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm border-r">{{ $b->status }}</td>

                            <td class="flex justify-between px-4 py-3 text-sm text-center">
                                {{-- <div class="flex justify-between text-sm"> --}}

                                    {{-- Show Detail --}}
                                    <a href="{{ route('admin.berita.showdetail', $b->id) }}"
                                        class="text-purple-600 hover:text-purple-800" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.berita.edit', $b->id) }}" class="text-yellow-400 hover:text-yellow-700" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Accept (jika belum publish) --}}
                                    @if ($b->status === 'Unpublish')
                                    <form action="{{ route('admin.berita.accept', $b->id) }}" method="POST" class="">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" title="Terbitkan" class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <button title="Sudah Terbit" disabled class="text-blue-600" style="cursor: default;">
                                        <i class="fas fa-check-double"></i> {{-- icon double check --}}
                                    </button>
                                @endif

                                    {{-- Delete --}}
                                    <div class="">
                                        <button onclick="confirmDelete({{ $b->id }}, '{{ $b->judul ?? '-' }}')"
                                            class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                {{-- </div> --}}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-times-circle"></i>
                                <p class="mb-2">Tidak ada berita tersedia.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between py-4 md:flex-row">
            {{-- Pagination links --}}
            <div>
                {{ $berita->links('pagination::tailwind') }}
            </div>

            {{-- Page info --}}
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $berita->currentPage() }} dari {{ $berita->lastPage() }} |
                Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }} dari total {{ $berita->total() }} data
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Yakin hapus berita?',
            html: `Apakah Anda yakin ingin menghapus berita <strong>${name}</strong>?`,
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
                form.action = `/admin/berita/${id}`;

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
