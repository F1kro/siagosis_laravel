<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Data Berita & Pengumuman') }}
            </h2>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Berita
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-md-8">
                    <form action="{{ route('admin.berita.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('admin.berita.index') }}" method="GET">
                        <div class="input-group">
                            <select name="kategori" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Kategori</option>
                                <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="berita" {{ request('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                                <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            </select>
                            @if(request('kategori') || request('search'))
                                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse($berita as $b)
                    <div class="mb-4 col-md-4">
                        <div class="card h-100">
                            @if($b->gambar)
                                <img src="{{ asset('storage/' . $b->gambar) }}" class="card-img-top" alt="{{ $b->judul }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-newspaper fa-4x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="mb-2 d-flex justify-content-between align-items-start">
                                    <span class="badge bg-{{ $b->kategori == 'pengumuman' ? 'danger' : ($b->kategori == 'berita' ? 'info' : 'success') }}">
                                        {{ ucfirst($b->kategori) }}
                                    </span>
                                    <small class="text-muted">{{ $b->tanggal->format('d M Y') }}</small>
                                </div>
                                <h5 class="card-title">{{ $b->judul }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit(strip_tags($b->konten), 100) }}</p>
                            </div>
                            <div class="bg-white card-footer">
                                <div class="btn-group w-100">
                                    <a href="{{ route('admin.berita.show', $b->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $b->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $b->id }}">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $b->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $b->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $b->id }}">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus berita <strong>{{ $b->judul }}</strong>?</p>
                                                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="py-5 text-center">
                            <i class="mb-3 fas fa-newspaper fa-4x text-muted"></i>
                            <p class="mb-3">Belum ada data berita atau pengumuman.</p>
                            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Berita
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-3 d-flex justify-content-center">
                {{ $berita->links() }}
            </div>
        </div>
    </div>
</x-app-layout>