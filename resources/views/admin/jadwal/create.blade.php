@extends('layouts.app')

@section('content')
    {{-- Form untuk membuat jadwal baru --}}
    @include('admin.jadwal._form', [
        'jadwal' => null, // Kirim null untuk mode create
        'kelas' => $kelas,
        'mapel' => $mapel,
        'guru' => $guru,
        'hariList' => $hariList,
        'tahunAjaranList' => $tahunAjaranList,
        'semesterList' => $semesterList
    ])
@endsection