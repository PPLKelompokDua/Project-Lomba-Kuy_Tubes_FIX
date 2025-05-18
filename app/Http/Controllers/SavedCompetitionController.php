<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;
use Illuminate\Support\Facades\Auth;

class SavedCompetitionController extends Controller
{
    public function store($id)
    {
        $user = auth()->user();
        $user->savedCompetitions()->syncWithoutDetaching([$id]);

        return back()->with('success', 'The competition is saved to bookmarks.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $user->savedCompetitions()->detach($id);

        return back()->with('success', 'The competition is deleted from bookmarks.');
    }
}
