@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
  <h1 class="text-4xl font-bold mb-6 text-indigo-600">Welcome, Admin!</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Total Users</h2>
      <p class="text-3xl font-bold text-indigo-700">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Total Competitions</h2>
      <p class="text-3xl font-bold text-indigo-700">{{ $totalCompetitions }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-2">Active Organizers</h2>
      <p class="text-3xl font-bold text-indigo-700">{{ $totalOrganizers }}</p>
    </div>
  </div>

  <div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4 text-indigo-700">Semua Kompetisi</h2>

    @if ($competitions->count())
      <table class="table-auto w-full text-sm border">
        <thead class="bg-indigo-100 text-left">
          <tr>
            <th class="p-3">Judul</th>
            <th class="p-3">Organizer</th>
            <th class="p-3">Deadline</th>
            <th class="p-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($competitions as $competition)
            <tr class="border-t hover:bg-gray-50">
              <td class="p-3">{{ $competition->title }}</td>
              <td class="p-3">{{ $competition->organizer->name ?? '-' }}</td>
              <td class="p-3">{{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</td>
              <td class="p-3 space-x-2">
                <form action="{{ route('organizer.competitions.destroy', $competition->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin hapus?')">
                  @csrf @method('DELETE')
                  <button class="text-red-600 hover:underline" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      @if ($competitions->hasPages())
      <div class="mt-6 flex justify-center">
        {{ $competitions->links() }}
      </div>
      @endif
    @else
      <p class="text-gray-600">Belum ada kompetisi.</p>
    @endif
  </div>
@endsection

@push('styles')
<style>
  .pagination {
    margin-top: 1rem;
  }

  .pagination .page-item .page-link {
    padding: 0.5rem 1rem;
    color: #4F46E5; /* Indigo-600 */
    background-color: white;
    border: 1px solid #E5E7EB; /* gray-200 */
    border-radius: 0.375rem;
    margin: 0 0.25rem;
  }

  .pagination .page-item.active .page-link {
    background-color: #6366F1; /* Indigo-500 */
    color: white;
    border-color: #6366F1;
  }

  .pagination .page-item.disabled .page-link {
    color: #9CA3AF; /* gray-400 */
  }
</style>
@endpush
