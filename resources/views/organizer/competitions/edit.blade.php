@extends('layouts.organizer')

@section('title', 'Edit Lomba')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8" data-aos="fade-up">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Lomba</h2>
            <a href="{{ route('organizer.competitions.index') }}"
               class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition"
               data-aos="fade-left">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg relative" role="alert" data-aos="fade-up">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="font-semibold">Terjadi Kesalahan:</span>
                </div>
                <ul class="list-disc pl-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="absolute top-2 right-2 text-red-500 hover:text-red-700" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('organizer.competitions.update', $competition->id) }}" method="POST" enctype="multipart/form-data" id="competitionForm">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Judul Lomba -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Lomba <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="title" id="title" value="{{ old('title', $competition->title) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Masukkan judul lomba" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="150">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-align-left absolute left-3 top-4 text-gray-400"></i>
                        <textarea name="description" id="description" rows="5" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Jelaskan detail lomba" required>{{ old('description', $competition->description) }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Kategori -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                    <label for="category_select" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="category_select" id="category_select" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required onchange="toggleCustomCategory()">
                            <option value="" disabled>Pilih kategori</option>
                            <option value="Desain" {{ old('category_select', $competition->category) == 'Desain' ? 'selected' : '' }}>Desain</option>
                            <option value="Teknologi" {{ old('category_select', $competition->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="Musik" {{ old('category_select', $competition->category) == 'Musik' ? 'selected' : '' }}>Musik</option>
                            <option value="Olahraga" {{ old('category_select', $competition->category) == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                            <option value="Pendidikan" {{ old('category_select', $competition->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Other" {{ !in_array(old('category_select', $competition->category), ['Desain', 'Teknologi', 'Musik', 'Olahraga', 'Pendidikan']) ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="customCategoryContainer" class="mt-2 {{ in_array(old('category_select', $competition->category), ['Desain', 'Teknologi', 'Musik', 'Olahraga', 'Pendidikan']) ? 'hidden' : '' }}">
                        <div class="relative">
                            <i class="fas fa-pen absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="custom_category" value="{{ !in_array(old('category_select', $competition->category), ['Desain', 'Teknologi', 'Musik', 'Olahraga', 'Pendidikan']) ? old('category', $competition->category) : '' }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Masukkan kategori lain">
                        </div>
                    </div>
                    <input type="hidden" name="category" id="category" value="{{ old('category', $competition->category) }}">
                </div>

                <!-- Deadline -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="250">
                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $competition->deadline->format('Y-m-d')) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        @error('deadline')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Hadiah -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="300">
                    <label for="prize" class="block text-sm font-medium text-gray-700 mb-1">Hadiah <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-gift absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="prize" id="prize" value="{{ old('prize', $competition->prize) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Contoh: Rp 1.000.000" required>
                        @error('prize')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Link Pendaftaran -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="350">
                    <label for="registration_link" class="block text-sm font-medium text-gray-700 mb-1">Link Pendaftaran <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-link absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="url" name="registration_link" id="registration_link" value="{{ old('registration_link', $competition->registration_link) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Masukkan URL pendaftaran" required>
                        @error('registration_link')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Maksimum Peserta -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="450">
                    <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">Maksimum Peserta (Opsional)</label>
                    <div class="relative">
                        <i class="fas fa-users absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $competition->max_participants) }}" min="1" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Masukkan jumlah maksimum peserta">
                        @error('max_participants')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="500">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="location" id="location" value="{{ old('location', $competition->location) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Masukkan lokasi lomba" required>
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="550">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-calendar-plus absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $competition->start_date->format('Y-m-d')) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        @error('start_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="600">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-calendar-minus absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $competition->end_date->format('Y-m-d')) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        @error('end_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Poster Lomba -->
                <div class="mb-6" data-aos="fade-up" data-aos-delay="650">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Poster Lomba (Opsional)</label>
                    <div class="relative">
                        <input type="file" name="photo" id="photo" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 cursor-pointer">
                        @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($competition->photo)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Poster Saat Ini:</p>
                            <img src="{{ asset('storage/' . $competition->photo) }}" class="w-48 h-48 object-cover rounded-lg cursor-pointer" alt="Current Poster" onclick="openPreviewModal('{{ asset('storage/' . $competition->photo) }}')">
                        </div>
                    @endif
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImage" class="w-48 h-48 object-cover rounded-lg" alt="Poster Preview">
                        <button type="button" class="mt-2 text-red-600 hover:text-red-800 text-sm" onclick="clearImagePreview()">
                            <i class="fas fa-trash mr-1"></i> Hapus Gambar
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end" data-aos="fade-up" data-aos-delay="700">
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Lomba
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview -->
<div class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" id="previewModal">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4">
        <div class="p-4 text-center">
            <img id="modalImage" class="rounded mx-auto" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
        </div>
        <div class="p-4 border-t border-gray-200">
            <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Input focus animation */
    input:focus, textarea:focus, select:focus {
        transform: scale(1.01);
        transition: transform 0.2s ease;
    }
    
    /* Custom button glow */
    button[type="submit"] {
        position: relative;
    }
    
    button[type="submit"]::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        z-index: -1;
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    button[type="submit"]:hover::after {
        opacity: 0.5;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-2xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
    });

    // Category Selection Logic
    function toggleCustomCategory() {
        const select = document.getElementById('category_select');
        const customContainer = document.getElementById('customCategoryContainer');
        const customInput = document.getElementById('custom_category');
        const categoryInput = document.getElementById('category');

        if (select.value === 'Other') {
            customContainer.classList.remove('hidden');
            customInput.focus();
            categoryInput.value = customInput.value || '';
        } else {
            customContainer.classList.add('hidden');
            categoryInput.value = select.value;
        }
    }

    // Update hidden category input on custom input change
    document.getElementById('custom_category').addEventListener('input', function() {
        document.getElementById('category').value = this.value;
    });

    // Initialize category input on page load
    document.getElementById('category_select').addEventListener('change', toggleCustomCategory);
    toggleCustomCategory(); // Run on load to set initial state

    // Image Preview
    document.getElementById('photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            previewImage.src = '';
        }
    });

    function clearImagePreview() {
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const input = document.getElementById('photo');
        
        input.value = '';
        previewContainer.classList.add('hidden');
        previewImage.src = '';
    }

    // Modal Preview Functions
    function openPreviewModal(imageUrl) {
        console.log('Opening modal with image:', imageUrl);
        const modal = document.getElementById('previewModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePreviewModal() {
        console.log('Closing modal');
        const modal = document.getElementById('previewModal');
        modal.classList.add('hidden');
        document.getElementById('modalImage').src = '';
        document.body.style.overflow = 'auto';
    }

    // Close modal on click outside
    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
            closePreviewModal();
        }
    });

    // Add click event to preview image to open modal
    document.getElementById('previewImage').addEventListener('click', function() {
        openPreviewModal(this.src);
    });
</script>
@endpush