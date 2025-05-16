@extends('layouts.app')

@section('title', 'Assessment Test')

@section('content')
<div class="flex-grow container mx-auto px-6 py-10">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden" x-data="assessmentFormComponent({{ count($questions) }})">
        <!-- Header -->
        <div class="bg-indigo-600 p-6 text-white">
            <h1 class="text-2xl font-bold">Internal Personality Test</h1>
            <p class="text-indigo-100 mt-2">Discover your personality type and suitable role</p>
            
            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="flex justify-between text-xs mb-1">
                    <span>Step <span x-text="step"></span> of <span x-text="totalSteps"></span></span>
                    <span x-text="Math.round((step/totalSteps)*100) + '%'"></span>
                </div>
                <div class="w-full bg-indigo-300 rounded-full h-2 overflow-hidden">
                    <div class="bg-white h-2 rounded-full transition-all duration-300 ease-out"
                         :style="'width: ' + (step/totalSteps*100) + '%'"></div>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if ($errors->has('answers.*'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    All questions must be answered.
                </div>
            @endif

            <form action="{{ route('assessment.submit') }}" method="POST">
                @csrf

                @php $stepIndex = 1; @endphp
                @foreach($questions as $category => $qs)
                    <div x-show="step === {{ $stepIndex }}" data-step="{{ $stepIndex }}"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-full"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform -translate-x-full"
                         class="step">
                        
                        <div class="bg-indigo-50 rounded-xl p-4 mb-6 border-l-4 border-indigo-500">
                            <h2 class="text-lg font-semibold text-indigo-700">{{ $category }}</h2>
                            <p class="text-sm text-gray-600">Choose the answer that best reflects you</p>
                        </div>
                        
                        @foreach($qs as $q)
                            <div class="mb-8 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                                <p class="font-medium text-gray-800 mb-4">{{ $q->question }}</p>
                                
                                <div class="space-y-3 pl-2">
                                    @foreach($q->options as $opt)
                                        <label class="flex items-start space-x-3 p-2 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                            <span class="relative flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->label }}" required 
                                                    class="appearance-none w-5 h-5 border-2 border-gray-300 rounded-full checked:border-indigo-600 checked:border-6 transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-1">
                                            </span>
                                            <div class="flex-grow">
                                                <p class="text-gray-700"><span class="font-medium text-indigo-600">{{ $opt->label }}.</span> {{ $opt->text }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @php $stepIndex++; @endphp
                @endforeach

                <!-- Navigation Controls -->
                <div class="flex justify-between mt-10 border-t pt-6 border-gray-200">
                    <!-- Left Side: Cancel & Back -->
                    <div class="flex space-x-3">
                        <a href="{{ route('assessment.index') }}" class="flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>

                        <button type="button"
                            @click="step = step > 1 ? step - 1 : step"
                            x-show="step > 1"
                            class="flex items-center justify-center px-4 py-2 bg-gray-100 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-200 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </button>
                    </div>

                    <!-- Right Side: Next & Submit -->
                    <div>
                        <button type="button"
                            @click="if(validateStep(step)) step++"
                            x-show="step < totalSteps"
                            class="flex items-center justify-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <button type="submit"
                            @click.prevent="if(validateStep(step)) $el.form.submit()"
                            x-show="step === totalSteps"
                            class="flex items-center justify-center px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Finish & Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Step Indicator -->
        <div class="px-6 pb-6">
            <div class="flex justify-center space-x-2">
                <template x-for="i in totalSteps" :key="i">
                    <button @click="step = i" 
                        :class="{'bg-indigo-800 scale-125': step === i, 'bg-gray-300': step !== i}"
                        class="w-3 h-3 rounded-full focus:outline-none transition-colors"></button>
                </template>
            </div>
        </div>
    </div>
    
    <!-- Tips Card -->
    <div class="max-w-md mx-auto mt-6 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-4 flex">
            <div class="flex-shrink-0 bg-indigo-100 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-indigo-700">Filling Tips</h3>
                <p class="text-xs text-gray-600">Answer all questions honestly based on your daily personality for accurate results.</p>
            </div>
        </div>
    </div>
</div>

<!-- Custom Radio Button Style -->
<style>
    input[type="radio"]:checked {
        background-clip: content-box;
        background-color: white;
    }
</style>
@endsection

<script>
    function assessmentFormComponent(totalSteps) {
        return {
            step: 1,
            totalSteps: totalSteps,
            validateStep(step) {
                const required = document.querySelectorAll(`[data-step="${step}"] [type=radio]`);
                const names = [...new Set([...required].map(r => r.name))];

                for (let name of names) {
                    if (![...document.getElementsByName(name)].some(r => r.checked)) {
                        alert('Please answer all questions before continuing.');
                        return false;
                    }
                }
                return true;
            }
        };
    }
</script>