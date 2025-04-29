@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Hasil Rekomendasi Tim</h4>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(isset($teamRecommendation))
                        <div class="text-center mb-4">
                            <h5 class="fw-bold">Peran yang Direkomendasikan</h5>
                            <span class="badge bg-success fs-5 py-2 px-4">
                                {{ $teamRecommendation->role_recommendation }}
                            </span>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">Kekuatan</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="lead mb-0">{{ $teamRecommendation->strengths }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-header bg-warning text-white">
                                        <h6 class="mb-0">Kelemahan</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="lead mb-0">{{ $teamRecommendation->weaknesses }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-secondary text-white text-center">
                                    <h6 class="mb-0">Skor Kecocokan Tim</h6>
                                </div>
                                <div class="card-body">
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: {{ $teamRecommendation->compatibility_score }}%;"
                                            aria-valuenow="{{ $teamRecommendation->compatibility_score }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ $teamRecommendation->compatibility_score }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rekomendasi Anggota Berdasarkan Assessment -->
                        <div class="mt-6">
                            <h5 class="text-center text-xl font-bold mb-4">Rekomendasi Calon Anggota</h5>

                            @php
                                $recommendedUsers = \App\Models\User::where('id', '!=', auth()->id())
                                    ->where('role', 'user')
                                    ->inRandomOrder()
                                    ->limit(6)
                                    ->get();
                            @endphp

                            @if($recommendedUsers->count() > 0)
                                <div class="row g-4">
                                    @foreach($recommendedUsers as $user)
                                        <div class="col-md-4">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body text-center">
                                                    <div class="mb-3">
                                                        <div class="rounded-full bg-primary text-white w-16 h-16 mx-auto flex items-center justify-center text-2xl">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <h6 class="font-semibold text-indigo-700">{{ $user->name }}</h6>
                                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                    <p class="mt-1 text-sm"><strong>Personality:</strong> {{ $user->personality_type }}</p>
                                                    <p class="text-sm"><strong>Role:</strong> {{ $user->preferred_role }}</p>
                                                    @if($user->description)
                                                        <p class="text-sm mt-2 text-gray-700">{{ \Illuminate\Support\Str::limit($user->description, 100) }}</p>
                                                    @endif
                                                    <div class="mt-3">
                                                        <a href="mailto:{{ $user->email }}" class="btn btn-outline-primary btn-sm w-100">Undang</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info text-center mt-4">
                                    Belum ada calon anggota yang tersedia.
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            Data rekomendasi tidak ditemukan. Silakan selesaikan assessment terlebih dahulu.
                        </div>
                    @endif

                    <div class="text-center mt-5">
                        <a href="{{ route('assessment.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Assessment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge {
        font-size: 1.2rem;
    }

    .progress {
        border-radius: 15px;
    }

    .progress-bar {
        border-radius: 15px;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-sm {
        font-size: 0.875rem;
    }

    /* Add some margin to the button group */
    .btn-group .btn {
        margin-right: 5px;
    }

    .modal-header {
        background-color: #343a40;
        color: #fff;
    }

    .modal-footer .btn {
        border-radius: 50px;
    }

    /* Style for the Add Member button */
    .btn-success {
        border-radius: 50px;
    }

    /* Container for Edit & Delete buttons */
    .btn-group {
        display: flex;
        gap: 10px;
    }

    /* Styling for cards */
    .card {
        border-radius: 10px;
    }
</style>
@endsection