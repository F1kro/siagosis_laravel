<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Data Mata Pelajaran') }}
            </h2>
            <a href="{{ route('admin.mapel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Mapel
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-md-8">
                    <form action="{{ route('admin.mapel.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama mapel..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Mapel</th>
                            <th>Kelompok</th>
                            <th>Tingkat</th>
                            <th>KKM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapel as $index => $m)
                            <tr>
                                <td>{{ $mapel->firstItem() + $index }}</td>
                                <td>{{ $m->kode }}</td>
                                <td>{{ $m->nama }}</td>
                                <td>{{ $m->kelompok }}</td>
                                <td>{{ $m->tingkat }}</td>
                                <td>{{ $m->kkm }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.mapel.show', $m->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.mapel.edit', $m->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $m->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $m->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $m->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $m->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus mata pelajaran <strong>{{ $m->nama }}</strong>?</p>
                                                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</small></p>

                                                    @if($m->jadwal->count() > 0 || $m->nilai->count() > 0)
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Mata pelajaran ini memiliki data terkait (jadwal atau nilai). Hapus data terkait terlebih dahulu.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" {{ $m->jadwal->count() > 0 || $m->nilai->count() > 0 ? 'disabled' : '' }}>Hapus</button>
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
                                    <i class="mb-3 fas fa-book fa-3x text-muted"></i>
                                    <p>Tidak ada data mata pelajaran.</p>
                                    <a href="{{ route('admin.mapel.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Mapel
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $mapel->links() }}
            </div>
        </div>
    </div>
</x-app-layout>