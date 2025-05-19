<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Tambah Kelas') }}
            </h2>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Contoh: X IPA 1, XI IPS 2, XII Bahasa</div>
                        </div>

                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                <option value="" selected disabled>Pilih Tingkat</option>
                                <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X (Sepuluh)</option>
                                <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI (Sebelas)</option>
                                <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII (Dua Belas)</option>
                            </select>
                            @error('tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="wali_kelas_id" class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                            <select class="form-select @error('wali_kelas_id') is-invalid @enderror" id="wali_kelas_id" name="wali_kelas_id" required>
                                <option value="" selected disabled>Pilih Wali Kelas</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->name }} {{ $g->guru && $g->guru->nip ? '(' . $g->guru->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wali_kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran" required>
                                <option value="" selected disabled>Pilih Tahun Ajaran</option>
                                <option value="2022/2023" {{ old('tahun_ajaran') == '2022/2023' ? 'selected' : '' }}>2022/2023</option>
                                <option value="2023/2024" {{ old('tahun_ajaran') == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                                <option value="2024/2025" {{ old('tahun_ajaran') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                            </select>
                            @error('tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', 30) }}" min="1" required>
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Jumlah maksimal siswa dalam kelas</div>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>