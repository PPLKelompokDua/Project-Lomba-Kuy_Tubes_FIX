@extends('layouts.app')

@section('content')
    <h1>Tambah Umpan Balik</h1>
    <form method="POST" action="{{ route('umpanbalik.store') }}">
        @csrf
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email">
        <textarea name="pesan" placeholder="Pesan" required></textarea>
        <button type="submit">Kirim</button>
    </form>
@endsection
