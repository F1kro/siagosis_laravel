<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Tambah Mata Pelajaran') }}
            </h2>
            <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Mapel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode') }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Contoh: MTK, BIG, FIS</div>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Mapel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Contoh: Matematika, Bahasa Inggris, Fisika</div>
                        </div>

                        <div class="mb-3">
                            <label for="kelompok" class="form-label">Kelompok <span class="text-danger">*</span></label>
                            <select class="form-select @error('kelompok') is-invalid @enderror" id="kelompok" name="kelompok" required>
                                <option value="" selected disabled>Pilih Kelompok</option>
                                <option value="Umum" {{ old('kelompok') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                <option value="Peminatan" {{ old('kelompok') == 'Peminatan' ? 'selected' : '' }}>Peminatan</option>
                                <option value="Muatan Lokal" {{ old('kelompok') == 'Muatan Lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                            </select>
                            @error('kelompok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                <option value="" selected disabled>Pilih Tingkat</option>
                                <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                                <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                                <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII (Dua Belas)</option>
                                <option value="X, XI, XII" {{ old('tingkat') == 'X, XI, XII' ? 'selected' : '' }}>Semua Tingkat</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kkm" class="form-label">KKM <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('kkm') is-invalid @enderror" id="kkm" name="kkm" value="{{ old('kkm', 75) }}" min="0" max="100" required>
                            @error('kkm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Kriteria Ketuntasan Minimal (0-100)</div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>