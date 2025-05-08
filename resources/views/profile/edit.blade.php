@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 hover-rise" data-aos="fade-up">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Profil</h2>
            <a href="{{ route('profile.show') }}"
               class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition"
               data-aos="fade-left">
                <i class="fas fa-arrow-left mr-2"></i> Back to Profile
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
                    <span class="font-semibold">An Error Occurred:</span>
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

        <!-- Edit Form -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm" data-aos="fade-up" data-aos-delay="100">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-user mr-2"></i> Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           required>
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-envelope mr-2"></i> Email <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           required>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-align-left mr-2"></i> Description
                </label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                >{{ old('description', $user->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Achievements -->
            <div class="mb-6">
                <label for="achievements" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-trophy mr-2"></i> Achievements (Optional)
                </label>
                <textarea name="achievements" id="achievements" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                >{{ old('achievements', $user->achievements) }}</textarea>
                @error('achievements')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profile Image -->
            <div class="mb-6" data-aos="fade-up" data-aos-delay="200">
                <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-image mr-2"></i> Profile Photo (Optional)
                </label>
                <div class="relative">
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg p-2 cursor-pointer">
                </div>
                <!-- Current Image -->
                <div class="mt-4">
                    <img src="{{ $user->profile_image ? asset('storage/images/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                         alt="Current Profile"
                         class="w-48 h-48 object-cover rounded-lg mx-auto cursor-pointer"
                         onclick="openPreviewModal('{{ $user->profile_image ? asset('storage/images/' . $user->profile_image) : 'https://via.placeholder.com/150' }}')">
                    <p class="text-sm text-gray-500 mt-2 text-center">Current Profile Photo</p>
                </div>
                <!-- New Image Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="previewImage" class="w-48 h-48 object-cover rounded-lg mx-auto" alt="Profile Preview">
                    <button type="button" class="mt-2 text-red-600 hover:text-red-800 text-sm" onclick="clearImagePreview()">
                        <i class="fas fa-trash mr-1"></i> Delete Photo
                    </button>
                </div>
                @error('profile_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Competition Experience -->
            <div class="mb-8" data-aos="fade-up" data-aos-delay="200" id="competition-experience">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Competition Experience</h3>
                <p class="text-sm text-gray-600 mb-4"> Add the categories of competitions you have participated in. This information will help other users find you when they're looking for team members.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="inline-flex items-center mb-2">
                            <input type="checkbox" name="experience[]" value="Desain" class="form-checkbox h-5 w-5 text-indigo-600 rounded" {{ in_array('Desain', $user->experience ?? []) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Desain</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center mb-2">
                            <input type="checkbox" name="experience[]" value="Teknologi" class="form-checkbox h-5 w-5 text-indigo-600 rounded" {{ in_array('Teknologi', $user->experience ?? []) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Teknologi</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center mb-2">
                            <input type="checkbox" name="experience[]" value="Musik" class="form-checkbox h-5 w-5 text-indigo-600 rounded" {{ in_array('Musik', $user->experience ?? []) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Musik</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center mb-2">
                            <input type="checkbox" name="experience[]" value="Olahraga" class="form-checkbox h-5 w-5 text-indigo-600 rounded" {{ in_array('Olahraga', $user->experience ?? []) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Olahraga</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center mb-2">
                            <input type="checkbox" name="experience[]" value="Pendidikan" class="form-checkbox h-5 w-5 text-indigo-600 rounded" {{ in_array('Pendidikan', $user->experience ?? []) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Pendidikan</span>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center mb-2">
                            <input type="checkbox" name="experience[]" value="Other" class="form-checkbox h-5 w-5 text-indigo-600 rounded" {{ in_array('Other', $user->experience ?? []) ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Other</span>
                        </label>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                            Adding your competition experience will increase your visibility when other users search for team members with specific skills.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-6" data-aos="fade-up" data-aos-delay="250">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock mr-2"></i> New Password (Optional)
                </label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" id="password"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>
                <p class="text-sm text-gray-500 mt-1">Leave blank if you don't want to change your password.</p>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-6" data-aos="fade-up" data-aos-delay="300">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    <i class="fas fa-lock mr-2"></i> Password Conformation
                </label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Buttons -->
            <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="350">
                <button type="submit"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg flex items-center justify-center transition min-w-[120px] shadow-md action-button">
                    <i class="fas fa-save mr-2"></i> Save
                </button>
                <a href="{{ route('profile.show') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg flex items-center justify-center transition min-w-[120px] action-button">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                   </a>
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
            <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Close</button>
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
    
    .action-button::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        border-radius: 8px;
        z-index: -1;
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

    // Image Preview
    document.getElementById('profile_image').addEventListener('change', function(event) {
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
        const input = document.getElementById('profile_image');
        
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

    document.getElementById('previewModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closePreviewModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('previewModal').classList.contains('hidden')) {
            closePreviewModal();
        }
    });

    // Add click event to preview image to open modal
    document.getElementById('previewImage').addEventListener('click', function() {
        if (this.src) {
            openPreviewModal(this.src);
        }
    });
</script>
@endpush