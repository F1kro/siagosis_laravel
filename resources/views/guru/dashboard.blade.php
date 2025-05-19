<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="mb-4 col-md-6">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Jadwal Mengajar Hari Ini</h5>
                </div>
                <div class="card-body">
                    @if($jadwalHariIni->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Jam</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwalHariIni as $jadwal)
                                        <tr>
                                            <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                            <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                            <td>{{ $jadwal->mapel->nama }}</td>
                                            <td>{{ $jadwal->ruangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-calendar-day fa-3x text-muted"></i>
                            <p>Tidak ada jadwal mengajar hari ini.</p>
                        </div>
                    @endif
                </div>
                <div class="bg-white card-footer">
                    <a href="{{ route('jadwal.index') }}" class="text-decoration-none">
                        Lihat Semua Jadwal <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-4 col-md-6">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Kelas Wali</h5>
                </div>
                <div class="card-body">
                    @if($kelasWali->count() > 0)
                        <div class="list-group">
                            @foreach($kelasWali as $kelas)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $kelas->nama_kelas }}</h6>
                                            <p class="mb-0 small text-muted">Tahun Ajaran: {{ $kelas->tahun_ajaran }}</p>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $kelas->siswa->count() }} Siswa</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-user-friends fa-3x text-muted"></i>
                            <p>Anda tidak terdaftar sebagai wali kelas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mb-4 col-md-8">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Input Nilai Terbaru</h5>
                        <a href="{{ route('guru.nilai.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> Input Nilai
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($nilaiTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Mapel</th>
                                        <th>Jenis</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiTerbaru as $nilai)
                                        <tr>
                                            <td>{{ $nilai->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $nilai->siswa->user->name }}</td>
                                            <td>{{ $nilai->kelas->nama_kelas }}</td>
                                            <td>{{ $nilai->mapel->nama }}</td>
                                            <td>
                                                <span class="badge bg-{{ $nilai->jenis_nilai == 'tugas' ? 'success' : ($nilai->jenis_nilai == 'ulangan_harian' ? 'info' : ($nilai->jenis_nilai == 'uts' ? 'warning' : 'danger')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $nilai->jenis_nilai)) }}
                                                </span>
                                            </td>
                                            <td>{{ $nilai->nilai }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-star fa-3x text-muted"></i>
                            <p>Belum ada input nilai terbaru.</p>
                            <a href="{{ route('guru.nilai.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Input Nilai
                            </a>
                        </div>
                    @endif
                </div>
                <div class="bg-white card-footer">
                    <a href="{{ route('guru.nilai.index') }}" class="text-decoration-none">
                        Lihat Semua Nilai <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-4 col-md-4">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Akses Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('guru.nilai.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-star me-2 text-warning"></i> Input Nilai
                        </a>
                        <a href="{{ route('guru.kehadiran.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-clipboard-check me-2 text-success"></i> Input Kehadiran
                        </a>
                        <a href="{{ route('jadwal.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i> Lihat Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>