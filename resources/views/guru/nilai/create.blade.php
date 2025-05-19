<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Input Nilai') }}
            </h2>
            <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('guru.nilai.store') }}" method="POST" id="formNilai">
                @csrf

                <div class="mb-4 row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                                <option value="" selected disabled>Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="mapel_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('mapel_id') is-invalid @enderror" id="mapel_id" name="mapel_id" required>
                                <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                @foreach($mapel as $m)
                                    <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mapel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jenis_nilai" class="form-label">Jenis Nilai <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_nilai') is-invalid @enderror" id="jenis_nilai" name="jenis_nilai" required>
                                <option value="" selected disabled>Pilih Jenis Nilai</option>
                                <option value="tugas" {{ old('jenis_nilai') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                                <option value="ulangan_harian" {{ old('jenis_nilai') == 'ulangan_harian' ? 'selected' : '' }}>Ulangan Harian</option>
                                <option value="uts" {{ old('jenis_nilai') == 'uts' ? 'selected' : '' }}>UTS</option>
                                <option value="uas" {{ old('jenis_nilai') == 'uas' ? 'selected' : '' }}>UAS</option>
                            </select>
                            @error('jenis_nilai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4 row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="loading" class="py-4 text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data siswa...</p>
                </div>

                <div id="siswaContainer" style="display: none;">
                    <h5 class="mb-3">Daftar Siswa</h5>

                    <div class="table-responsive">
                        <table class="table table-hover" id="tableSiswa">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="40%">Nama Siswa</th>
                                    <th width="15%">NIS</th>
                                    <th width="40%">Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="siswaList">
                                <!-- Data siswa akan dimuat di sini -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </div>
                </div>

                <div id="noSiswa" class="py-4 text-center" style="display: none;">
                    <i class="mb-3 fas fa-user-slash fa-3x text-muted"></i>
                    <p>Tidak ada siswa dalam kelas ini.</p>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kelasSelect = document.getElementById('kelas_id');
            const loadingElement = document.getElementById('loading');
            const siswaContainer = document.getElementById('siswaContainer');
            const noSiswaElement = document.getElementById('noSiswa');
            const siswaList = document.getElementById('siswaList');

            kelasSelect.addEventListener('change', function() {
                const kelasId = this.value;

                if (kelasId) {
                    loadingElement.style.display = 'block';
                    siswaContainer.style.display = 'none';
                    noSiswaElement.style.display = 'none';

                    // Fetch siswa by kelas
                    fetch(`{{ url('guru/nilai/get-siswa-by-kelas') }}?kelas_id=${kelasId}`)
                        .then(response => response.json())
                        .then(data => {
                            loadingElement.style.display = 'none';

                            if (data.length > 0) {
                                siswaContainer.style.display = 'block';
                                siswaList.innerHTML = '';

                                data.forEach((siswa, index) => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${siswa.name}</td>
                                        <td>${siswa.siswa ? siswa.siswa.nis : '-'}</td>
                                        <td>
                                            <input type="number" class="form-control" name="nilai[${siswa.siswa.id}]" min="0" max="100" required>
                                        </td>
                                    `;
                                    siswaList.appendChild(row);
                                });
                            } else {
                                noSiswaElement.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            loadingElement.style.display = 'none';
                            alert('Terjadi kesalahan saat memuat data siswa.');
                        });
                }
            });

            // Validate form before submit
            const formNilai = document.getElementById('formNilai');
            formNilai.addEventListener('submit', function(event) {
                const kelasId = document.getElementById('kelas_id').value;
                const mapelId = document.getElementById('mapel_id').value;
                const jenisNilai = document.getElementById('jenis_nilai').value;

                if (!kelasId || !mapelId || !jenisNilai) {
                    event.preventDefault();
                    alert('Silakan pilih Kelas, Mata Pelajaran, dan Jenis Nilai terlebih dahulu.');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>