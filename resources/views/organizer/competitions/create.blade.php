@extends('layouts.organizer')

@section('title', 'Add Competition')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8" data-aos="fade-up">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Add New Competition</h2>
            <a href="{{ route('organizer.competitions.index') }}"
               class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-semibold transition"
               data-aos="fade-left">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <!-- Client-Side Error Messages -->
        <div id="client-errors" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg relative hidden" role="alert" data-aos="fade-up">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-semibold">An Error Occurred:</span>
            </div>
            <ul id="client-error-list" class="list-disc pl-5 mt-2 text-sm"></ul>
            <button class="absolute top-2 right-2 text-red-500 hover:text-red-700" onclick="this.parentElement.classList.add('hidden')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Server-Side Error Messages -->
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

        <!-- Form -->
        <form action="{{ route('organizer.competitions.store') }}" method="POST" enctype="multipart/form-data" id="competitionForm" onsubmit="return syncCategory()">

            @csrf

            <div class="space-y-6">
                <!-- Competition Title -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Competition Title <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter competition title" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="150">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-align-left absolute left-3 top-4 text-gray-400"></i>
                        <textarea name="description" id="description" rows="5" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Describe competition details" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Category -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                    <label for="category_select" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="category_select" id="category_select"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            required onchange="toggleCustomCategory()">
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select category</option>
                            @php
                                $preset = ['Design', 'Technology', 'Music', 'Sports', 'Education'];
                                $category = old('category');
                            @endphp
                            @foreach($preset as $presetCategory)
                                <option value="{{ $presetCategory }}" {{ $category === $presetCategory ? 'selected' : '' }}>
                                    {{ $presetCategory }}
                                </option>
                            @endforeach
                            <option value="Other" {{ $category && !in_array($category, $preset) ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Input Custom Category -->
                    <div id="customCategoryContainer" class="mt-2 {{ $category && !in_array($category, $preset) ? '' : 'hidden' }}">
                        <div class="relative">
                            <i class="fas fa-pen absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="custom_category"
                                value="{{ $category && !in_array($category, $preset) ? $category : '' }}"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                placeholder="Enter other category">
                            <span id="custom_category-error" class="text-red-500 text-sm hidden">Other category is required.</span>
                        </div>
                    </div>

                    <input type="hidden" name="category" id="category" value="{{ $category }}">
                    @error('category')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Deadline -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="250">
                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                    </div>
                    @error('deadline')
                        <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                    @enderror
                    <span id="deadline-error" class="text-red-500 text-sm hidden block mt-1">Deadline must be today or in the future.</span>
                </div>

                <!-- Prize -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="300">
                    <label for="prize" class="block text-sm font-medium text-gray-700 mb-1">Prize <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-gift absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="prize" id="prize" value="{{ old('prize') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Example: $1,000" required>
                        @error('prize')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Registration Link -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="350">
                    <label for="registration_link" class="block text-sm font-medium text-gray-700 mb-1">Registration Link <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-link absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="url" name="registration_link" id="registration_link" value="{{ old('registration_link') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter registration URL" required>
                        @error('registration_link')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Maximum Participants -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="450">
                    <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">Maximum Participants (Optional)</label>
                    <div class="relative">
                        <i class="fas fa-users absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter maximum number of participants">
                        @error('max_participants')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="500">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter competition location" required>
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Start Date -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="550">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                    </div>
                    @error('start_date')
                        <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                    @enderror
                    <span class="text-sm text-gray-500 block mt-1">Start Date begins from the start of the registration period</span>
                </div>

                <!-- End Date -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="600">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-calendar-minus"></i>
                        </div>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                    </div>
                    @error('end_date')
                        <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                    @enderror
                    <span id="end_date-error" class="text-red-500 text-sm hidden block mt-1">End Date must be in the future.</span>
                    <span class="text-sm text-gray-500 block mt-1">End Date until all competition timelines are complete, e.g., announcement</span>
                </div>

                <!-- Competition Poster -->
                <div class="mb-6" data-aos="fade-up" data-aos-delay="650">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Competition Poster (Optional)</label>
                    <div class="relative">
                        <input type="file" name="photo" id="photo" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 cursor-pointer">
                        @error('photo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImage" class="w-48 h-48 object-cover rounded-lg" alt="Poster Preview">
                        <button type="button" class="mt-2 text-red-600 hover:text-red-800 text-sm" onclick="clearImagePreview()">
                            <i class="fas fa-trash mr-1"></i> Remove Image
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div dusk="btn-simpan-lomba" class="flex justify-end" data-aos="fade-up" data-aos-delay="700">
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Save Competition
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
            <button type="button" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700 transition" onclick="closePreviewModal()">Close</button>
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
    
    /* Date input icon alignment */
    .date-icon {
        width: 1.25rem;
        height: 1.25rem;
        line-height: 1;
        top: 50%;
        transform: translateY(-50%);
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-3xl {
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

    function toggleCustomCategory() {
        const select = document.getElementById('category_select');
        const customContainer = document.getElementById('customCategoryContainer');
        const customInput = document.getElementById('custom_category');
        const categoryInput = document.getElementById('category');

        if (select.value === 'Other') {
            customContainer.classList.remove('hidden');
            customInput.setAttribute('required', 'required');
            categoryInput.value = customInput.value.trim();
        } else {
            customContainer.classList.add('hidden');
            customInput.removeAttribute('required');
            customInput.value = '';
            categoryInput.value = select.value;
        }
    }

    // Validate category
    function validateCategory() {
        const select = document.getElementById('category_select');
        const customInput = document.getElementById('custom_category');
        const error = document.getElementById('custom_category-error');
        let isValid = true;
        let errors = [];

        if (select.value === 'Other' && !customInput.value.trim()) {
            error.classList.remove('hidden');
            customInput.classList.add('border-red-500');
            errors.push('Other category is required.');
            isValid = false;
        } else {
            error.classList.add('hidden');
            customInput.classList.remove('border-red-500');
        }

        return { isValid, errors };
    }

    // Sync category on form submission
    function syncCategory() {
        const select = document.getElementById('category_select');
        const customInput = document.getElementById('custom_category');
        const categoryInput = document.getElementById('category');

        if (select.value === 'Other') {
            const val = customInput.value.trim();
            categoryInput.value = val;
            if (!val) {
                alert("Other category is required.");
                customInput.focus();
                return false;
            }
        } else {
            categoryInput.value = select.value;
        }

        return true;
    }

    // Update hidden category input on custom input change
    document.getElementById('custom_category').addEventListener('input', function() {
        document.getElementById('category').value = this.value.trim();
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

    // Date Validation
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().split('T')[0];

    function validateDates() {
        const deadlineInput = document.getElementById('deadline');
        const endDateInput = document.getElementById('end_date');
        const deadlineError = document.getElementById('deadline-error');
        const endDateError = document.getElementById('end_date-error');
        let errors = [];
        let isValid = true;

        // Validate Deadline (today or future)
        if (!deadlineInput.value || deadlineInput.value < today) {
            deadlineError.classList.remove('hidden');
            deadlineInput.classList.add('border-red-500');
            errors.push('Deadline must be today or in the future.');
            isValid = false;
        } else {
            deadlineError.classList.add('hidden');
            deadlineInput.classList.remove('border-red-500');
        }

        // Validate End Date (future)
        if (!endDateInput.value || endDateInput.value <= today) {
            endDateError.classList.remove('hidden');
            endDateInput.classList.add('border-red-500');
            errors.push('End Date must be in the future.');
            isValid = false;
        } else {
            endDateError.classList.add('hidden');
            endDateInput.classList.remove('border-red-500');
        }

        return { isValid, errors };
    }

    // Form Validation
    function validateForm() {
        const dateValidation = validateDates();
        const categoryValidation = validateCategory();
        const clientErrors = document.getElementById('client-errors');
        const clientErrorList = document.getElementById('client-error-list');

        const allErrors = [...dateValidation.errors, ...categoryValidation.errors];
        const isValid = dateValidation.isValid && categoryValidation.isValid;

        if (allErrors.length > 0) {
            clientErrorList.innerHTML = allErrors.map(error => `<li>${error}</li>`).join('');
            clientErrors.classList.remove('hidden');
        } else {
            clientErrors.classList.add('hidden');
        }

        return isValid;
    }

    // Validate on input change and manual typing
    document.getElementById('deadline').addEventListener('input', function() {
        if (this.value && this.value < today) {
            this.value = today; // Reset to today if past date is typed
            validateDates();
        }
    });

    document.getElementById('end_date').addEventListener('input', function() {
        if (this.value && this.value <= today) {
            this.value = tomorrow; // Reset to tomorrow if past or today is typed
            validateDates();
        }
    });

    document.getElementById('deadline').addEventListener('change', validateForm);
    document.getElementById('end_date').addEventListener('change', validateForm);
    document.getElementById('category_select').addEventListener('change', validateForm);
    document.getElementById('custom_category').addEventListener('input', validateForm);

    // Validate on form submission
    document.getElementById('competitionForm').addEventListener('submit', function(event) {
        // Force update category before validation
        const select = document.getElementById('category_select');
        const customInput = document.getElementById('custom_category');
        const categoryInput = document.getElementById('category');
        
        if (select.value === 'Other') {
            categoryInput.value = customInput.value.trim();
        } else {
            categoryInput.value = select.value;
        }

        console.log('Submitting form, category:', categoryInput.value);

        if (!validateForm()) {
            event.preventDefault();
        }
    });
</script>
@endpush