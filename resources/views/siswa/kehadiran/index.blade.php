<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Kehadiran Saya') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 row">
                        <div class="col-md-12">
                            <form action="{{ route('siswa.kehadiran.index') }}" method="GET">
                                <div class="row">
                                    <div class="mb-2 col-md-4">
                                        <select name="bulan" class="form-select">
                                            <option value="">Semua Bulan</option>
                                            @foreach(range(1, 12) as $bulan)
                                                <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2 col-md-4">
                                        <select name="status" class="form-select">
                                            <option value="">Semua Status</option>
                                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="alpa" {{ request('status') == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                        </select>
                                    </div>
                                    <div class="mb-2 col-md-4">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                                            @if(request('bulan') || request('status'))
                                                <a href="{{ route('siswa.kehadiran.index') }}" class="btn btn-secondary">Reset</a>
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
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kehadiran as $index => $k)
                                    <tr>
                                        <td>{{ $kehadiran->firstItem() + $index }}</td>
                                        <td>{{ $k->tanggal->format('d F Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $k->status == 'hadir' ? 'success' : ($k->status == 'izin' ? 'info' : ($k->status == 'sakit' ? 'warning' : 'danger')) }}">
                                                {{ ucfirst($k->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $k->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center">
                                            <i class="mb-3 fas fa-clipboard-check fa-3x text-muted"></i>
                                            <p>Belum ada data kehadiran.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex justify-content-center">
                        {{ $kehadiran->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-4 card">
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
            </div>

            <div class="card">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Rekap Kehadiran</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Total Hari</td>
                                    <td class="text-end">{{ $totalHari }}</td>
                                </tr>
                                <tr>
                                    <td>Hadir</td>
                                    <td class="text-end">{{ $totalHadir }}</td>
                                </tr>
                                <tr>
                                    <td>Izin</td>
                                    <td class="text-end">{{ $totalIzin }}</td>
                                </tr>
                                <tr>
                                    <td>Sakit</td>
                                    <td class="text-end">{{ $totalSakit }}</td>
                                </tr>
                                <tr>
                                    <td>Alpa</td>
                                    <td class="text-end">{{ $totalAlpa }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>