@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Hasil Assessment</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Ringkasan Hasil Assessment
                </div>
                <div class="card-body">

                    <h5 class="card-title">Hasil Penilaian Anda</h5>

                    @isset($scores)
                        @if(!empty($scores))
                            <table class="table table-bordered mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Skor A (%)</th>
                                        <th>Skor B (%)</th>
                                        <th>Peran Tim yang Cocok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scores as $category => $score)
                                        <tr>
                                            <td>{{ ucfirst($category) }}</td>
                                            <td>{{ $score['A'] ?? 0 }}%</td>
                                            <td>{{ $score['B'] ?? 0 }}%</td>
                                            <td>{{ $roles[$category] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="alert alert-info mt-4">
                                <p><strong>Tipe Kepribadian Utama:</strong> {{ $personality_type }}</p>
                                <p><strong>Peran dalam Tim:</strong> {{ $preferred_role }}</p>
                            </div>
                        @else
                            <p class="text-danger">Skor assessment kosong. Silakan lakukan ulang assessment.</p>
                        @endif
                    @else
                        <p class="text-warning">Data assessment tidak ditemukan. Silakan coba lagi.</p>
                    @endisset

                    <div class="mt-4">
                        <a href="{{ route('assessment.retry') }}" class="btn btn-primary me-2">Ulangi Assessment</a>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
