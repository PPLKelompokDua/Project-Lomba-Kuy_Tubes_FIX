@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold text-indigo-600 mb-6">
    Selamat datang, {{ auth()->user()->name }}!
</h1>

<!-- Eksplorasi Lomba Preview Carousel -->
<div class="mb-12">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Eksplorasi Lomba</h2>
        <a href="{{ route('explore') }}" class="inline-flex items-center gap-1 text-indigo-600 font-semibold hover:underline">
            Lihat semua lomba →
        </a>
    </div>

    <div id="competition-slider" class="splide px-2 min-h-[460px] pb-10">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($competitions as $competition)
                <li class="splide__slide">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden w-[320px] mx-auto">
                        <img src="{{ asset('storage/' . $competition->photo) }}" 
                             class="w-full h-52 object-cover" 
                             alt="{{ $competition->title }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-indigo-700">{{ $competition->title }}</h3>
                            <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($competition->description, 60) }}</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .splide__slide {
        transition: transform 0.3s ease-in-out;
        height: auto !important;
    }

    .splide__slide.is-visible.is-active {
        transform: scale(1.06);
        z-index: 10;
    }

    .splide__track {
        padding-bottom: 2rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('#competition-slider', {
            type: 'loop',
            perPage: 3,
            focus: 'center',
            gap: '1rem', // lebih rapat antar card
            pagination: true,
            arrows: true,
            breakpoints: {
                1024: { perPage: 2 },
                768: { perPage: 1 },
            },
        }).mount();
    });
</script>
@endpush
