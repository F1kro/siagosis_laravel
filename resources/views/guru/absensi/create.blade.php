<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Input Kehadiran') }}
            </h2>
            <a href="{{ route('guru.kehadiran.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('guru.kehadiran.store') }}" method="POST" id="formKehadiran">
                @csrf

                <div class="mb-4 row">
                    <div class="col-md-6">
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

                    <div class="col-md-6">
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
                                    <th width="30%">Nama Siswa</th>
                                    <th width="10%">NIS</th>
                                    <th width="20%">Status</th>
                                    <th width="35%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="siswaList">
                                <!-- Data siswa akan dimuat di sini -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary me-2">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan Kehadiran</button>
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
                    fetch(`{{ url('guru/kehadiran/get-siswa-by-kelas') }}?kelas_id=${kelasId}`)
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
                                            <select class="form-select" name="status[${siswa.siswa.id}]" required>
                                                <option value="hadir" selected>Hadir</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="alpa">Alpa</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="keterangan[${siswa.siswa.id}]" placeholder="Opsional">
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
            const formKehadiran = document.getElementById('formKehadiran');
            formKehadiran.addEventListener('submit', function(event) {
                const kelasId = document.getElementById('kelas_id').value;

                if (!kelasId) {
                    event.preventDefault();
                    alert('Silakan pilih Kelas terlebih dahulu.');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>