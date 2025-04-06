<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetitionController extends Controller
{
    // Menampilkan semua lomba untuk katalog
    public function index()
    {
        $competitions = Competition::latest()->get();
        return view('competitions.index', compact('competitions'));
    }

    // Form tambah lomba
    public function create()
    {
        return view('competitions.create');
    }

    // Simpan lomba baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'prize' => 'required',
            'deadline' => 'required|date',
            'registration_link' => 'required|url',
            'photo' => 'nullable|image|max:2048'
        ]);

        $photoPath = $request->file('photo')?->store('competition_photos', 'public');

        Competition::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'prize' => $request->prize,
            'deadline' => $request->deadline,
            'registration_link' => $request->registration_link,
            'photo' => $photoPath,
            'organizer_id' => auth()->id()
        ]);

        return redirect()->route('competitions.index')->with('success', 'Lomba berhasil ditambahkan.');
    }

    // Form edit lomba
    public function edit(Competition $competition)
    {
        return view('competitions.edit', compact('competition'));
    }

    // Update lomba
    public function update(Request $request, Competition $competition)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'prize' => 'required',
            'deadline' => 'required|date',
            'registration_link' => 'required|url',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($competition->photo) {
                Storage::disk('public')->delete($competition->photo);
            }
            $competition->photo = $request->file('photo')->store('competition_photos', 'public');
        }

        $competition->update($request->only([
            'title', 'description', 'category', 'prize', 'deadline', 'registration_link'
        ]));

        return redirect()->route('competitions.index')->with('success', 'Lomba berhasil diperbarui.');
    }

    // Hapus lomba
    public function destroy(Competition $competition)
    {
        if ($competition->photo) {
            Storage::disk('public')->delete($competition->photo);
        }
        $competition->delete();

        return redirect()->route('competitions.index')->with('success', 'Lomba berhasil dihapus.');
    }
}
