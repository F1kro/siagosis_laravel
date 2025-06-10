@extends('layouts.app')
@section('title', 'Generate Peringkat Siswa')

@section('content')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Manajemen Peringkat Siswa
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

        <div class="p-6 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Generate Peringkat Baru</h3>
            <form action="{{ route('admin.ranking.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div>
                        <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun
                            Ajaran</label>
                        <select name="tahun_ajaran" id="tahun_ajaran" required
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            @foreach ($daftarTahunAjaran as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="semester"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester</label>
                        <select name="semester" id="semester" required
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
                    <div>
                        <label for="kelas_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                        <select name="kelas_id" id="kelas_id" required
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            @foreach ($daftarKelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="self-end">
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            <i class="fas fa-cogs"></i> Generate
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <h3
                class="p-4 text-lg font-semibold text-gray-700 bg-white border-b dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700">
                Riwayat Peringkat yang Sudah Digenerate
            </h3>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Tahun Ajaran</th>
                            <th class="px-4 py-3">Semester</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Jumlah Siswa</th>
                            <th class="px-4 py-3">Tanggal Dibuat</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($riwayatRanking as $riwayat)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">{{ $riwayat->tahun_ajaran }}</td>
                                <td class="px-4 py-3 text-sm capitalize">{{ $riwayat->semester }}</td>
                                <td class="px-4 py-3 text-sm">{{ $riwayat->kelas->nama_kelas ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $riwayat->jumlah_siswa }}</td>
                                <td class="px-4 py-3 text-sm">
                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_dibuat)->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <form id="delete-form-{{ $loop->index }}"
                                        action="{{ route('admin.ranking.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="tahun_ajaran" value="{{ $riwayat->tahun_ajaran }}">
                                        <input type="hidden" name="semester" value="{{ $riwayat->semester }}">
                                        <input type="hidden" name="kelas_id" value="{{ $riwayat->kelas_id }}">
                                        <button type="button" onclick="confirmDelete({{ $loop->index }})"
                                            class="px-2 py-1 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="py-3">
                                <td colspan="6" class="px-4 py-10 text-center dark:text-gray-300">Belum ada riwayat
                                    peringkat yang digenerate.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(index) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Batch peringkat ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + index).submit();
            }
        })
    }
</script>
