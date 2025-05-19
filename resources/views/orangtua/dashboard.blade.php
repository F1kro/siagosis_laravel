<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard Orangtua') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="mb-4 col-md-12">
            <div class="card">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Daftar Anak</h5>
                </div>
                <div class="card-body">
                    @if($anak->count() > 0)
                        <div class="row">
                            @foreach($anak as $a)
                                <div class="mb-4 col-md-4">
                                    <div class="card h-100">
                                        <div class="text-center card-body">
                                            <div class="mb-3">
                                                @if($a->siswa->foto)
                                                    <img src="{{ asset('storage/' . $a->siswa->foto) }}" alt="{{ $a->name }}" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                @else
                                                    <div class="mx-auto rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                                        <i class="fas fa-user fa-3x text-secondary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <h5 class="card-title">{{ $a->name }}</h5>
                                            <p class="card-text text-muted">
                                                {{ $a->siswa->kelas->nama_kelas }}
                                            </p>
                                            <div class="gap-2 d-grid">
                                                <a href="{{ route('orangtua.anak.show', $a->siswa->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-child fa-3x text-muted"></i>
                            <p>Belum ada data anak yang terdaftar.</p>
                            <p class="small text-muted">Silakan hubungi pihak sekolah untuk mendaftarkan anak Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mb-4 col-md-6">
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
                                        <th>Anak</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Jenis</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nilaiTerbaru as $nilai)
                                        <tr>
                                            <td>{{ $nilai->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $nilai->siswa->user->name }}</td>
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
            </div>
        </div>

        <div class="mb-4 col-md-6">
            <div class="card h-100">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Kehadiran Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($kehadiranTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Anak</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kehadiranTerbaru as $kehadiran)
                                        <tr>
                                            <td>{{ $kehadiran->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $kehadiran->siswa->user->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $kehadiran->status == 'hadir' ? 'success' : ($kehadiran->status == 'izin' ? 'info' : ($kehadiran->status == 'sakit' ? 'warning' : 'danger')) }}">
                                                    {{ ucfirst($kehadiran->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $kehadiran->keterangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-clipboard-check fa-3x text-muted"></i>
                            <p>Belum ada data kehadiran terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>