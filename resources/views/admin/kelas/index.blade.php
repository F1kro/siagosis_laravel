<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Data Kelas') }}
            </h2>
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Kelas
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-md-8">
                    <form action="{{ route('admin.kelas.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama kelas..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('admin.kelas.index') }}" method="GET">
                        <div class="input-group">
                            <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach(['2022/2023', '2023/2024', '2024/2025'] as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                            @if(request('tahun_ajaran') || request('search'))
                                <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Wali Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $k)
                            <tr>
                                <td>{{ $kelas->firstItem() + $index }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->waliKelas->name ?? '-' }}</td>
                                <td>{{ $k->tahun_ajaran }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $k->siswa->count() }}/{{ $k->kapasitas }}</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.kelas.show', $k->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $k->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $k->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $k->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $k->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus kelas <strong>{{ $k->nama_kelas }}</strong>?</p>
                                                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</small></p>

                                                    @if($k->siswa->count() > 0)
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Kelas ini memiliki {{ $k->siswa->count() }} siswa. Hapus atau pindahkan siswa terlebih dahulu.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" {{ $k->siswa->count() > 0 ? 'disabled' : '' }}>Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center">
                                    <i class="mb-3 fas fa-school fa-3x text-muted"></i>
                                    <p>Tidak ada data kelas.</p>
                                    <a href="{{ route('admin.kelas.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Kelas
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $kelas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>