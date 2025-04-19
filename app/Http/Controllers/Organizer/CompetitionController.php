<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    /**
     * Tampilkan semua lomba milik organizer yang login
     */
    public function index()
    {
        $user = auth()->user();
    
        // Ambil data lomba milik organizer yang sedang login
        $competitions = Competition::where('organizer_id', $user->id)->latest()->paginate(10);
    
        // Total jumlah lomba (tetap dihitung semua, bukan hanya yang di halaman aktif)
        $total = Competition::where('organizer_id', $user->id)->count();
    
        return view('organizer.dashboard', [
            'competitions' => $competitions,
            'totalCompetitions' => $total
        ]);
    }

    /**
     * Form tambah lomba baru
     */
    public function create()
    {
        return view('organizer.competitions.create');
    }

    /**
     * Simpan data lomba baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'category'         => 'required|string',
            'prize'            => 'required|string',
            'deadline'         => 'required|date',
            'registration_link'=> 'nullable|url',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'category', 'prize', 'deadline', 'registration_link']);
        $data['organizer_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        Competition::create($data);

        return redirect()->route('organizer.competitions.index')->with('success', 'Lomba berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail lomba
     */
    public function show(Competition $competition)
    {
        // Pastikan hanya pemilik bisa akses
        $this->authorizeAccess($competition);

        return view('organizer.competitions.show', compact('competition'));
    }

    /**
     * Form edit
     */
    public function edit(Competition $competition)
    {
        $this->authorizeAccess($competition);

        return view('organizer.competitions.edit', compact('competition'));
    }

    /**
     * Update lomba
     */
    public function update(Request $request, Competition $competition)
    {
        $this->authorizeAccess($competition);

        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'category'         => 'required|string',
            'prize'            => 'required|string',
            'deadline'         => 'required|date',
            'registration_link'=> 'nullable|url',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'category', 'prize', 'deadline', 'registration_link']);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($competition->photo && Storage::disk('public')->exists($competition->photo)) {
                Storage::disk('public')->delete($competition->photo);
            }

            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $competition->update($data);

        return redirect()->route('organizer.competitions.index')->with('success', 'Lomba berhasil diperbarui!');
    }

    /**
     * Hapus lomba
     */
    public function destroy(Competition $competition)
    {
        $this->authorizeAccess($competition);
    
        if ($competition->photo && Storage::disk('public')->exists($competition->photo)) {
            Storage::disk('public')->delete($competition->photo);
        }
    
        $competition->delete();
    
        return redirect()
            ->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'organizer.competitions.index')
            ->with('success', 'Lomba berhasil dihapus.');
    }

    /**
     * Validasi akses hanya untuk organizer pemilik lomba
     */
    private function authorizeAccess(Competition $competition)
    {
        if (auth()->user()->role === 'admin') {
            return; // Admin boleh akses semua
        }
    
        if ($competition->organizer_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }
    }
}
