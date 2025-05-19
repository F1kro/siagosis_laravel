<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Jadwal Pelajaran') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <ul class="mb-4 nav nav-tabs" id="jadwalTab" role="tablist">
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
                            $jadwalHari = $jadwal->where('hari', $hari)->sortBy('jam_mulai');
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
                                        @foreach($jadwalHari as $j)
                                            <tr>
                                                <td>{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</td>
                                                <td>{{ $j->mapel->nama }}</td>
                                                <td>{{ $j->guru->user->name }}</td>
                                                <td>{{ $j->ruangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-5 text-center">
                                <i class="mb-3 fas fa-calendar-times fa-3x text-muted"></i>
                                <p>Tidak ada jadwal pada hari {{ ucfirst($hari) }}.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-4 row">
        <div class="col-md-12">
            <div class="card">
                <div class="bg-white card-header">
                    <h5 class="mb-0">Jadwal Mingguan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-light">
                                    <th width="10%">Jam</th>
                                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                                        <th width="15%">{{ ucfirst($hari) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jamPelajaran as $jam)
                                    <tr>
                                        <td class="align-middle">{{ substr($jam['mulai'], 0, 5) }} - {{ substr($jam['selesai'], 0, 5) }}</td>

                                        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                                            <td>
                                                @php
                                                    $jadwalCell = $jadwal->where('hari', $hari)
                                                                        ->where('jam_mulai', $jam['mulai'])
                                                                        ->where('jam_selesai', $jam['selesai'])
                                                                        ->first();
                                                @endphp

                                                @if($jadwalCell)
                                                    <div class="p-2 rounded {{ $jadwalCell->mapel->kelompok == 'Umum' ? 'bg-info' : ($jadwalCell->mapel->kelompok == 'Peminatan' ? 'bg-warning' : 'bg-success') }} bg-opacity-10">
                                                        <div class="fw-bold">{{ $jadwalCell->mapel->nama }}</div>
                                                        <div class="small">{{ $jadwalCell->guru->user->name }}</div>
                                                        @if($jadwalCell->ruangan)
                                                            <div class="small text-muted">{{ $jadwalCell->ruangan }}</div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="text-center text-muted">-</div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>