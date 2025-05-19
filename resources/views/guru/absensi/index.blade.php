<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Data Kehadiran') }}
            </h2>
            <a href="{{ route('guru.kehadiran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Input Kehadiran
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-md-12">
                    <form action="{{ route('guru.kehadiran.index') }}" method="GET">
                        <div class="row">
                            <div class="mb-2 col-md-4">
                                <select name="kelas_id" class="form-select">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2 col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="alpa" {{ request('status') == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-3">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" placeholder="Pilih Tanggal">
                            </div>
                            <div class="mb-2 col-md-2">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    @if(request('kelas_id') || request('status') || request('tanggal'))
                                        <a href="{{ route('guru.kehadiran.index') }}" class="btn btn-secondary">Reset</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kehadiran as $index => $k)
                            <tr>
                                <td>{{ $kehadiran->firstItem() + $index }}</td>
                                <td>{{ $k->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $k->siswa->user->name }}</td>
                                <td>{{ $k->kelas->nama_kelas }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->status == 'hadir' ? 'success' : ($k->status == 'izin' ? 'info' : ($k->status == 'sakit' ? 'warning' : 'danger')) }}">
                                        {{ ucfirst($k->status) }}
                                    </span>
                                </td>
                                <td>{{ $k->keterangan ?? '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('guru.kehadiran.edit', $k->id) }}" class="btn btn-sm btn-warning">
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
                                                    <p>Apakah Anda yakin ingin menghapus data kehadiran ini?</p>
                                                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('guru.kehadiran.destroy', $k->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
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
                                    <i class="mb-3 fas fa-clipboard-check fa-3x text-muted"></i>
                                    <p>Tidak ada data kehadiran.</p>
                                    <a href="{{ route('guru.kehadiran.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Input Kehadiran
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $kehadiran->links() }}
            </div>
        </div>
    </div>
</x-app-layout>