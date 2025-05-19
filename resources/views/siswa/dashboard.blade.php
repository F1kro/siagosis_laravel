<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="mb-4 col-md-8">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Jadwal Pelajaran Hari Ini</h5>
                </div>
                <div class="card-body">
                    @if($jadwalHariIni->count() > 0)
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
                                    @foreach($jadwalHariIni as $jadwal)
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
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-calendar-day fa-3x text-muted"></i>
                            <p>Tidak ada jadwal pelajaran hari ini.</p>
                        </div>
                    @endif
                </div>
                <div class="bg-white card-footer">
                    {{-- <a href="{{ route('jadwal.index') }}" class="text-decoration-none">
                        Lihat Semua Jadwal <i class="fas fa-arrow-right ms-1"></i>
                    </a> --}}
                </div>
            </div>
        </div>

        <div class="mb-4 col-md-4">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Statistik Kehadiran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="mb-1 d-flex justify-content-between">
                            <span>Hadir</span>
                            <span>{{ $persentaseHadir }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persentaseHadir }}%" aria-valuenow="{{ $persentaseHadir }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="mb-1 d-flex justify-content-between">
                            <span>Izin</span>
                            <span>{{ $persentaseIzin }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $persentaseIzin }}%" aria-valuenow="{{ $persentaseIzin }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="mb-1 d-flex justify-content-between">
                            <span>Sakit</span>
                            <span>{{ $persentaseSakit }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persentaseSakit }}%" aria-valuenow="{{ $persentaseSakit }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="mb-1 d-flex justify-content-between">
                            <span>Alpa</span>
                            <span>{{ $persentaseAlpa }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $persentaseAlpa }}%" aria-valuenow="{{ $persentaseAlpa }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-white card-footer">
                    {{-- <a href="{{ route('siswa.kehadiran.index') }}" class="text-decoration-none">
                        Lihat Detail Kehadiran <i class="fas fa-arrow-right ms-1"></i>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mb-4 col-md-8">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Nilai Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($nilaiTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiTerbaru as $nilai)
                                        <tr>
                                            <td>{{ $nilai->tanggal->format('d/m/Y') }}</td>
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
                            <p>Belum ada nilai terbaru.</p>
                        </div>
                    @endif
                </div>
                <div class="bg-white card-footer">
                    {{-- <a href="{{ route('siswa.nilai.index') }}" class="text-decoration-none">
                        Lihat Semua Nilai <i class="fas fa-arrow-right ms-1"></i>
                    </a> --}}
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
                        {{-- <a href="{{ route('jadwal.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i> Jadwal Pelajaran
                        </a>
                        <a href="{{ route('siswa.nilai.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-star me-2 text-warning"></i> Nilai
                        </a>
                        <a href="{{ route('siswa.nilai.rapor') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-alt me-2 text-danger"></i> Rapor
                        </a>
                        <a href="{{ route('siswa.kehadiran.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-clipboard-check me-2 text-success"></i> Kehadiran
                        </a>
                        <a href="{{ route('berita.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-newspaper me-2 text-info"></i> Berita/Pengumuman
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>