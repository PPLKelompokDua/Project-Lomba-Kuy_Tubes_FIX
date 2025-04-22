@extends('layouts.app')

@section('content')
    <h1>Edit Umpan Balik</h1>
    <form method="POST" action="{{ route('umpanbalik.update', $umpanbalik->id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="nama" value="{{ $umpanbalik->nama }}" required>
        <input type="email" name="email" value="{{ $umpanbalik->email }}">
        <textarea name="pesan" required>{{ $umpanbalik->pesan }}</textarea>
        <button type="submit">Update</button>
    </form>
@endsection
