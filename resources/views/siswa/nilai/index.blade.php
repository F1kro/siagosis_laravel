<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Nilai Saya') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <div class="col-md-12">
                    <form action="{{ route('siswa.nilai.index') }}" method="GET">
                        <div class="row">
                            <div class="mb-2 col-md-4">
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
                            <div class="mb-2 col-md-3">
                                <select name="semester" class="form-select">
                                    <option value="">Semua Semester</option>
                                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-2">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    @if(request('mapel_id') || request('jenis_nilai') || request('semester'))
                                        <a href="{{ route('siswa.nilai.index') }}" class="btn btn-secondary">Reset</a>
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
                            <th>Mata Pelajaran</th>
                            <th>Jenis</th>
                            <th>Semester</th>
                            <th>Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilai as $index => $n)
                            <tr>
                                <td>{{ $nilai->firstItem() + $index }}</td>
                                <td>{{ $n->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $n->mapel->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $n->jenis_nilai == 'tugas' ? 'success' : ($n->jenis_nilai == 'ulangan_harian' ? 'info' : ($n->jenis_nilai == 'uts' ? 'warning' : 'danger')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $n->jenis_nilai)) }}
                                    </span>
                                </td>
                                <td>{{ $n->semester }}</td>
                                <td>{{ $n->nilai }}</td>
                                <td>
                                    @if($n->nilai >= $n->mapel->kkm)
                                        <span class="badge bg-success">Tuntas</span>
                                    @else
                                        <span class="badge bg-danger">Belum Tuntas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center">
                                    <i class="mb-3 fas fa-star fa-3x text-muted"></i>
                                    <p>Belum ada data nilai.</p>
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

    <div class="mt-4 row">
        <div class="col-md-12">
            <div class="card">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Statistik Nilai</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Rata-rata Nilai per Mata Pelajaran</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th>Rata-rata</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rataRataMapel as $mapel => $rata)
                                            <tr>
                                                <td>{{ $mapel }}</td>
                                                <td>{{ number_format($rata['nilai'], 2) }}</td>
                                                <td>
                                                    @if($rata['nilai'] >= $rata['kkm'])
                                                        <span class="badge bg-success">Tuntas</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum Tuntas</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-3">Rata-rata Nilai per Jenis</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jenis Nilai</th>
                                            <th>Rata-rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rataRataJenis as $jenis => $rata)
                                            <tr>
                                                <td>{{ ucfirst(str_replace('_', ' ', $jenis)) }}</td>
                                                <td>{{ number_format($rata, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>