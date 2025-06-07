@extends('layouts.app')

@section('content')
    <div class="container grid px-6 mx-auto">
        <div class="flex items-center justify-between my-6">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Daftar Tugas Saya
            </h2>
            <a href="{{ route('siswa.todolist.create') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Tambah Tugas Baru
            </a>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Tugas</th>
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Deadline</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($todos as $todo)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p
                                                class="font-semibold {{ $todo->selesai ? 'line-through text-gray-500 dark:text-gray-400' : '' }}">
                                                {{ $todo->judul }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $todo->deskripsi }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $todo->mapel->nama ?? 'Pribadi' }}</td>

                                {{-- MODIFIKASI 1: Kolom Deadline dibuat merah jika terlewat --}}
                                <td class="px-4 py-3 text-sm">
                                    <span class="{{ !$todo->selesai && $todo->deadline->isPast() ? 'text-red-600 font-bold dark:text-red-500' : '' }}">
                                        {{ $todo->deadline->format('d M Y') }}
                                    </span>
                                </td>

                                {{-- MODIFIKASI 2: Kolom Status dengan Alert Terlewat --}}
                                <td class="px-4 py-3 text-xs">
                                    <div class="flex items-center">
                                        @if ($todo->selesai)
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                                Belum Selesai
                                            </span>

                                            {{-- PENAMBAHAN ALERT JIKA TERLAMBAT --}}
                                            @if (!$todo->selesai && $todo->deadline->isPast())
                                            <span
                                                class="px-2 py-1 ml-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                Terlewat!
                                            </span>
                                            @endif
                                            {{-- AKHIR PENAMBAHAN --}}
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-4 text-sm">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('siswa.todolist.edit', $todo) }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray hover:text-blue-800"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </a>

                                        {{-- Toggle Status Button --}}
                                        <form action="{{ route('siswa.todolist.update', $todo) }}" method="POST"
                                            class="inline-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="toggle_status" value="true">
                                            <button type="submit"
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray {{ $todo->selesai ? 'text-green-600 hover:text-green-800' : 'text-gray-500 hover:text-green-600' }}"
                                                aria-label="Toggle Status">
                                                @if ($todo->selesai)
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>

                                        <button data-id="{{ $todo->id }}" data-title="{{ $todo->judul }}"
                                            onclick="confirmDelete(this)"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray hover:text-red-800"
                                            aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center">Yeay! Tidak ada tugas yang perlu
                                    dikerjakan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-col items-center justify-between py-4 md:flex-row">
            <div>
                {{ $todos->links('pagination::tailwind') }}
            </div>

            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 md:mt-0">
                Halaman {{ $todos->currentPage() }} dari {{ $todos->lastPage() }} |
                Menampilkan {{ $todos->firstItem() }} - {{ $todos->lastItem() }} dari total {{ $todos->total() }} data
            </div>
        </div>
    </div>


 <script>
        function confirmDelete(button) {
            const id = button.dataset.id;
            const title = button.dataset.title;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Tugas "<strong>${title}</strong>" yang dihapus tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('siswa/todolist') }}/${id}`;

                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    // Add Method Spoofing
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
