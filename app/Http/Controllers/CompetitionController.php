<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;

class CompetitionController extends Controller
{
    public function index()
    {
        // Ambil seluruh data kompetisi (sesuaikan dengan kebutuhan)
        $competitions = Competition::all();

        // Kirim data ke view
        return view('user.competitions.index', compact('competitions'));
    }
}
