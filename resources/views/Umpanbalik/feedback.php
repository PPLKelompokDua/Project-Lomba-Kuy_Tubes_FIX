@extends('layouts.app')

@section('content')
    <h1>Detail Umpan Balik</h1>
    <p><strong>Nama:</strong> {{ $umpanbalik->nama }}</p>
    <p><strong>Pesan:</strong> {{ $umpanbalik->pesan }}</p>
    <a href="{{ route('umpanbalik.index') }}">Kembali</a>
@endsection
