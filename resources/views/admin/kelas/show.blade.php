<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Detail Kelas') }}
            </h2>
            <div>
                <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="mb-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Kelas</h5>
                    <hr>
                    <div class="mb-3 row">
                        <div class="col-md-5 fw-bold">Nama Kelas</div>
                        <div class="col-md-7">{{ $kelas->nama_kelas }}</div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-5 fw-bold">Tingkat</div>
                        <div class="col-md-7">{{ $kelas->tingkat }}</div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-5 fw-bold">Tahun Ajaran</div>
                        <div class="col-md-7">{{ $kelas->tahun_ajaran }}</div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-5 fw-bold">Kapasitas</div>
                        <div class="col-md-7">
                            <div class="d-flex align-items-center">
                                <span class="me-2">{{ $siswa->count() }}/{{ $kelas->kapasitas }}</span>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar {{ $siswa->count() >= $kelas->kapasitas ? 'bg-danger' : 'bg-success' }}" role="progressbar" style="width: {{ ($siswa->count() / $kelas->kapasitas) * 100 }}%" aria-valuenow="{{ $siswa->count() }}" aria-valuemin="0" aria-valuemax="{{ $kelas->kapasitas }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 card">
                <div class="card-body">
                    <h5 class="card-title">Wali Kelas</h5>
                    <hr>
                    @if($kelas->waliKelas)
                        <div class="mb-3 d-flex align-items-center">
                            @if($kelas->waliKelas->guru && $kelas->waliKelas->guru->foto)
                                <img src="{{ asset('storage/' . $kelas->waliKelas->guru->foto) }}" alt="{{ $kelas->waliKelas->name }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="text-white rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $kelas->waliKelas->name }}</h6>
                                <p class="mb-0 text-muted">{{ $kelas->waliKelas->guru->nip ?? 'NIP tidak tersedia' }}</p>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <div class="col-md-4 fw-bold">Email</div>
                            <div class="col-md-8">{{ $kelas->waliKelas->email }}</div>
                        </div>

                        @if($kelas->waliKelas->guru && $kelas->waliKelas->guru->telepon)
                            <div class="mb-2 row">
                                <div class="col-md-4 fw-bold">Telepon</div>
                                <div class="col-md-8">{{ $kelas->waliKelas->guru->telepon }}</div>
                            </div>
                        @endif

                        <div class="gap-2 mt-3 d-grid">
                            <a href="{{ route('admin.guru.show', $kelas->waliKelas->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    @else
                        <div class="py-3 text-center">
                            <i class="mb-3 fas fa-user-slash fa-3x text-muted"></i>
                            <p>Belum ada wali kelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-4 col-md-8">
            <div class="card">
                <div class="bg-white card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Siswa</h5>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" id="searchSiswa" class="form-control" placeholder="Cari siswa...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($siswa->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableSiswa">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIS/NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswa as $index => $s)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($s->siswa && $s->siswa->foto)
                                                        <img src="{{ asset('storage/' . $s->siswa->foto) }}" alt="{{ $s->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="text-white rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    @endif
                                                    {{ $s->name }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $s->siswa->nis ?? '-' }}<br>
                                                <small class="text-muted">NISN: {{ $s->siswa->nisn ?? '-' }}</small>
                                            </td>
                                            <td>{{ $s->siswa ? ($s->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-user-graduate fa-3x text-muted"></i>
                            <p>Belum ada siswa dalam kelas ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 card">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Jadwal Pelajaran</h5>
                </div>
                <div class="card-body">
                    @if($kelas->jadwal->count() > 0)
                        <ul class="mb-3 nav nav-tabs" id="jadwalTab" role="tablist">
                            @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $index => $hari)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $hari }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $hari }}" type="button" role="tab" aria-controls="{{ $hari }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                        {{ ucfirst($hari) }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="jadwalTabContent">
                            @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $index => $hari)
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $hari }}" role="tabpanel" aria-labelledby="{{ $hari }}-tab">
                                    @php
                                        $jadwalHari = $kelas->jadwal->where('hari', $hari)->sortBy('jam_mulai');
                                    @endphp

                                    @if($jadwalHari->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Jam</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Guru</th>
                                                        <th>Ruangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($jadwalHari as $jadwal)
                                                        <tr>
                                                            <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                                            <td>{{ $jadwal->mapel->nama }}</td>
                                                            <td>{{ $jadwal->guru->user->name }}</td>
                                                            <td>{{ $jadwal->ruangan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="py-3 text-center">
                                            <p class="text-muted">Tidak ada jadwal pada hari {{ ucfirst($hari) }}.</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-calendar-times fa-3x text-muted"></i>
                            <p>Belum ada jadwal pelajaran untuk kelas ini.</p>
                            <a href="{{ route('admin.jadwal.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Jadwal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchSiswa');
            const table = document.getElementById('tableSiswa');
            const rows = table ? table.getElementsByTagName('tr') : [];

            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();

                for (let i = 1; i < rows.length; i++) {
                    const name = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                    const nis = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();

                    if (name.includes(query) || nis.includes(query)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>