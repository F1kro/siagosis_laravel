@extends('layouts.app')

@section('content')
    @include('admin.jadwal._form', [
        'jadwal' => $jadwal, // Kirim objek jadwal yang akan diedit
        'kelas' => $kelas,
        'mapel' => $mapel,
        'guru' => $guru,
        'hariList' => $hariList,
        'tahunAjaranList' => $tahunAjaranList,
        'semesterList' => $semesterList
    ])
@endsection