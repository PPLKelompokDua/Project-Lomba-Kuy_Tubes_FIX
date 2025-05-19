@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-8 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-indigo-700">
            <i class="fas fa-flag-checkered"></i>
            Tambah Milestone untuk Kompetisi
        </h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('milestones.store', $competition->id ?? $competitionId) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                <div class="mt-1 relative">
                    <input type="text" name="title" id="title" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10"
                        placeholder="Contoh: Finalisasi Proposal">
                    <div class="absolute left-3 top-0 text-gray-300">
                        <i class="fas fa-heading"></i>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <div class="mt-1 relative">
                    <textarea name="description" id="description" rows="4"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10"
                        placeholder="Deskripsi milestone (opsional)"></textarea>
                    <div class="absolute left-3 top-0 text-gray-400">
                        <i class="fas fa-align-left"></i>
                    </div>
                </div>
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <div class="mt-1 relative">
                    <input type="date" name="start_date" id="start_date" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10">
                    <div class="absolute left-3 top-0 text-gray-400">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Tanggal Selesai -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <div class="mt-1 relative">
                    <input type="date" name="end_date" id="end_date" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10">
                    <div class="absolute left-3 top-0 text-gray-400">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <div class="mt-1 relative">
                    <select name="status" id="status" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-10">
                        <option value="Not Started">Belum Dimulai</option>
                        <option value="In Progress">Sedang Berlangsung</option>
                        <option value="Completed">Selesai</option>
                    </select>
                    <div class="absolute left-3 top-0 text-gray-400">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
