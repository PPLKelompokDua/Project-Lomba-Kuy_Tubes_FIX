@php
    $layout = auth()->user()->role === 'organizer' ? 'layouts.organizer' : 'layouts.app';
@endphp
@extends($layout)

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover-rise" data-aos="fade-up">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Pengaturan</h2>
            <a href="{{ route('dashboard') }}"
               class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition"
               data-aos="fade-left">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" data-aos="fade-up">
                <p>{{ session('success') }}</p>
            </div>
        @endif
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

        <!-- Profile Overview -->
        <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Profil</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Profile Image -->
                <div class="text-center">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/images/' . auth()->user()->profile_image) : 'https://via.placeholder.com/150' }}"
                         alt="{{ auth()->user()->name }}'s Profile"
                         class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto border-2 border-indigo-100 cursor-pointer shadow-md"
                         onclick="openPreviewModal('{{ auth()->user()->profile_image ? asset('storage/images/' . auth()->user()->profile_image) : 'https://via.placeholder.com/150' }}')">
                    <p class="text-sm text-gray-500 mt-2">Klik untuk melihat foto profil</p>
                </div>
                <!-- User Details -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600 mb-2"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="text-sm text-gray-600 mb-2"><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
                    <!-- Statistics -->
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-indigo-50 rounded-lg p-3">
                            <h4 class="text-xl font-bold text-indigo-600">{{ $completedCompetitions ?? 0 }}</h4>
                            <p class="text-xs text-gray-600">Lomba Selesai</p>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-3">
                            <h4 class="text-xl font-bold text-indigo-600">{{ $achievements ?? 0 }}</h4>
                            <p class="text-xs text-gray-600">Pencapaian</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Profile Button -->
            <div class="flex justify-end">
                <a href="{{ route('profile.edit') }}"
                   class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg flex items-center transition min-w-[120px] shadow-md action-button">
                    <i class="fas fa-edit mr-2"></i> Edit Profil
                </a>
            </div>
        </div>

        <!-- Settings Form -->
        <form action="{{ route('settings.update') }}" method="POST" id="settingsForm" data-aos="fade-up" data-aos-delay="150">
            @csrf
            @method('PUT')

            <!-- Notification Preferences -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Preferensi Notifikasi</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="notification_preferences[saved_competitions]" id="saved_competitions"
                               {{ old('notification_preferences.saved_competitions', auth()->user()->notification_preferences['saved_competitions'] ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="saved_competitions" class="ml-2 block text-sm text-gray-700">
                            Notifikasi email untuk pembaruan lomba tersimpan (misalnya, pengingat tenggat waktu)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="notification_preferences[new_competitions]" id="new_competitions"
                               {{ old('notification_preferences.new_competitions', auth()->user()->notification_preferences['new_competitions'] ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="new_competitions" class="ml-2 block text-sm text-gray-700">
                            Notifikasi email untuk lomba baru di kategori yang diikuti
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Buttons -->
            <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="300">
                <button type="submit"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg flex items-center justify-center transition min-w-[120px] shadow-md action-button">
                    <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                </button>
                <a href="{{ route('dashboard') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg flex items-center justify-center transition min-w-[120px] action-button">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>

        <!-- Account Deletion -->
        <div class="mt-8 border-t pt-6" data-aos="fade-up" data-aos-delay="350">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Hapus Akun</h3>
            <p class="text-sm text-gray-600 mb-4">Menghapus akun Anda akan menghapus semua data pribadi secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
            <button type="button" onclick="openDeleteModal()"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center transition min-w-[120px] shadow-md">
                <i class="fas fa-trash-alt mr-2"></i> Hapus Akun
            </button>
        </div>
    </div>
</div>

<!-- Modal Preview (for Profile Image) -->
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

<!-- Delete Account Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" id="deleteModal">
    <div class="bg-white rounded-lg max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Penghapusan Akun</h3>
            <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus akun Anda? Semua data akan hilang dan tidak dapat dipulihkan.</p>
            <form action="{{ route('settings.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeDeleteModal()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">Batal</button>
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    .action-button {
        position: relative;
    }
    
    .action-button::after {
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
    
    .action-button:hover::after {
        opacity: 0.5;
    }
    
    input:focus, textarea:focus, select:focus {
        transform: scale(1.01);
        transition: transform 0.2s ease;
    }
    
    @media (max-width: 640px) {
        .max-w-4xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

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

    // Delete Account Modal
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePreviewModal();
            closeDeleteModal();
        }
    });
</script>
@endpush