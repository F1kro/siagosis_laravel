<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Data Nilai') }}
            </h2>
            <a href="{{ route('guru.nilai.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Input Nilai
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-md-12">
                    <form action="{{ route('guru.nilai.index') }}" method="GET">
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
                                <select name="mapel_id" class="form-select">
                                    <option value="">Semua Mapel</option>
                                    @foreach($mapel as $m)
                                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2 col-md-3">
                                <select name="jenis_nilai" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="tugas" {{ request('jenis_nilai') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                                    <option value="ulangan_harian" {{ request('jenis_nilai') == 'ulangan_harian' ? 'selected' : '' }}>Ulangan Harian</option>
                                    <option value="uts" {{ request('jenis_nilai') == 'uts' ? 'selected' : '' }}>UTS</option>
                                    <option value="uas" {{ request('jenis_nilai') == 'uas' ? 'selected' : '' }}>UAS</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-2">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    @if(request('kelas_id') || request('mapel_id') || request('jenis_nilai'))
                                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">Reset</a>
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
                            <th>Mapel</th>
                            <th>Jenis</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilai as $index => $n)
                            <tr>
                                <td>{{ $nilai->firstItem() + $index }}</td>
                                <td>{{ $n->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $n->siswa->user->name }}</td>
                                <td>{{ $n->kelas->nama_kelas }}</td>
                                <td>{{ $n->mapel->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $n->jenis_nilai == 'tugas' ? 'success' : ($n->jenis_nilai == 'ulangan_harian' ? 'info' : ($n->jenis_nilai == 'uts' ? 'warning' : 'danger')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $n->jenis_nilai)) }}
                                    </span>
                                </td>
                                <td>{{ $n->nilai }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('guru.nilai.edit', $n->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $n->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $n->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $n->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $n->id }}">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus nilai ini?</p>
                                                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('guru.nilai.destroy', $n->id) }}" method="POST">
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
                                <td colspan="8" class="py-4 text-center">
                                    <i class="mb-3 fas fa-star fa-3x text-muted"></i>
                                    <p>Tidak ada data nilai.</p>
                                    <a href="{{ route('guru.nilai.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Input Nilai
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $nilai->links() }}
            </div>
        </div>
    </div>
</x-app-layout>