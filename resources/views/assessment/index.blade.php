@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-indigo-700">Assessment Kepribadian</h1>

        <div class="mt-6 flex flex-col md:flex-row gap-4">
            <a href="https://www.ibunda.id/tespsikologi/tes-mengenal-diri-sendiri-online"
                class="btn btn-primary bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700" target="_blank">
                Lakukan Tes Kepribadian
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form untuk memilih tipe kepribadian dan peran -->
        <form action="{{ route('assessment.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="personality_type" class="block text-sm font-medium text-gray-700">Tipe Kepribadian</label>
                <select id="personality_type" name="personality_type" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Tipe Kepribadian --</option>
                    <option value="Conscientiousness">Conscientiousness</option>
                    <option value="Openness to Experience">Openness to Experience</option>
                    <option value="Extraversion">Extraversion</option>
                    <option value="Neuroticism">Neuroticism</option>
                    <option value="Agreeableness">Agreeableness</option>
                </select>
            </div>

            <div>
                <label for="preferred_role" class="block text-sm font-medium text-gray-700">Peran yang Diinginkan</label>
                <select id="preferred_role" name="preferred_role" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Peran --</option>
                    <option value="Leader">Leader</option>
                    <option value="Planner">Planner</option>
                    <option value="Supporter">Supporter</option>
                    <option value="Creative">Creative</option>
                </select>
            </div>

            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Simpan Hasil</button>
        </form>

        @if(Auth::user()->personality_type && Auth::user()->preferred_role)
            <div class="mt-8 bg-gray-50 p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Hasil Terakhir</h2>
                <p><strong>Tipe Kepribadian:</strong> {{ Auth::user()->personality_type }}</p>
                <p><strong>Peran yang Diinginkan:</strong> {{ Auth::user()->preferred_role }}</p>

                @php
                    $images = [
                        'Conscientiousness' => asset('storage/bigfive/conscientiousness.jpg'),
                        'Openness to Experience' => asset('storage/bigfive/openness.jpg'),
                        'Extraversion' => asset('storage/bigfive/extraversion.jpg'),
                        'Neuroticism' => asset('storage/bigfive/neuroticism.jpg'),
                        'Agreeableness' => asset('storage/bigfive/agreeableness.jpg'),
                    ];
                    $img = $images[Auth::user()->personality_type] ?? null;
                @endphp

                @if($img)
                    <div class="mt-4 text-center">
                        <img src="{{ $img }}" alt="Ilustrasi Kepribadian"
                            class="w-40 h-40 object-contain rounded-md mx-auto shadow-md">
                    </div>
                @endif
            </div>
        @endif

        @php
            $history = Auth::user()->assessmentHistories()->latest()->take(5)->get();
        @endphp

        @if($history->count())
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-800">📜 Riwayat Assessment:</h3>
                <ul class="space-y-2">
                    @foreach($history as $entry)
                        <li class="p-3 bg-white border rounded-lg shadow-sm">
                            <div class="text-sm text-gray-600">
                                <strong>{{ $entry->created_at->format('d M Y H:i') }}</strong><br>
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $entry->personality_type }}
                                </span>
                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $entry->preferred_role }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tombol untuk mengarahkan ke halaman tes kepribadian -->
        <div class="mt-6 flex flex-col md:flex-row gap-4">
            <!-- Tombol View Recommendation Team -->
            <a href="{{ route('team.recommendation') }}"
                class="btn btn-secondary bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                View Recommendation Team
            </a>
        </div>
    </div>
</div>
@endsection