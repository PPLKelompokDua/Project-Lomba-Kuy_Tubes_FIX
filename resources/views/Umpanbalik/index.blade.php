@extends('layouts.app')

@section('content')
    <h1>Daftar Umpan Balik</h1>
    <a href="{{ route('umpanbalik.create') }}">Tambah Umpan Balik</a>
    @foreach($data as $item)
        <div>
            <h3>{{ $item->nama }}</h3>
            <p>{{ $item->pesan }}</p>
            <a href="{{ route('umpanbalik.show', $item->id) }}">Lihat</a>
            <a href="{{ route('umpanbalik.edit', $item->id) }}">Edit</a>
            <form action="{{ route('umpanbalik.destroy', $item->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </div>
    @endforeach
@endsection
