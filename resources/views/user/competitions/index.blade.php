@extends('layouts.app')

@section('title', 'Katalog')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-indigo-600">Eksplorasi Lomba (Katalog)</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($competitions as $competition)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div 
                    class="h-64 overflow-hidden cursor-pointer" 
                    data-img="{{ asset('storage/' . ltrim($competition->photo, '/')) }}"
                    onclick="showModal('{{ asset('storage/' . ltrim($competition->photo, '/')) }}')"
                >
                    <img 
                        src="{{ asset('storage/' . ltrim($competition->photo, '/')) }}" 
                        alt="{{ $competition->title }}" 
                        class="w-full h-full object-cover hover:scale-105 transition duration-300"
                    >
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $competition->title }}</h3>
                    <p class="text-sm text-indigo-500">{{ $competition->category }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($competition->description, 80) }}</p>
                </div>
                <div class="px-4 py-2 border-t text-sm">
                    <span class="text-green-600 font-medium">Hadiah: {{ $competition->prize }}</span><br>
                    <span class="text-red-600">Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Preview -->
<div class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60" id="previewModal">
    <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full">
        <div class="p-4 text-center">
            <img id="modalImage" src="" alt="Preview" class="max-h-[500px] w-auto mx-auto rounded shadow-lg">
        </div>
        <div class="flex justify-center p-4">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showModal(imageUrl) {
        const modal = document.getElementById('previewModal');
        const modalImg = document.getElementById('modalImage');
        modalImg.src = imageUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('previewModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.getElementById('modalImage').src = '';
    }
</script>
@endpush
