<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;

class SavedCompetitionController extends Controller
{
    public function store($id)
    {
        $user = auth()->user();
        $user->savedCompetitions()->syncWithoutDetaching([$id]);

        return back()->with('success', 'Lomba disimpan ke favorit.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $user->savedCompetitions()->detach($id);

        return back()->with('success', 'Lomba dihapus dari favorit.');
    }
}
