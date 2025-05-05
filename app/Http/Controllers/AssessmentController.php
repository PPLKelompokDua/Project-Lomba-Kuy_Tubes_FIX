<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment;
use App\Models\AssessmentHistory;

class AssessmentController extends Controller
{
    public function index()
    {
        return view('assessment.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'personality_type' => 'required|string',
            'preferred_role' => 'required|string',
        ]);

        $user = Auth::user();

        // Simpan ke tabel users
        $user->update([
            'personality_type' => $request->personality_type,
            'preferred_role' => $request->preferred_role,
        ]);

        // Simpan ke tabel assessments
        Assessment::create([
            'user_id' => $user->id,
            'personality_type' => $request->personality_type,
            'preferred_role' => $request->preferred_role,
            'results' => json_encode([
                'logical' => rand(20, 30),
                'emotional' => rand(20, 30),
                'teamwork' => rand(20, 30),
            ])
        ]);

        AssessmentHistory::create([
            'user_id' => $user->id,
            'assessment_data' => json_encode([
                'personality_type' => $request->personality_type,
                'preferred_role' => $request->preferred_role,
            ]),
            'personality_type' => $request->personality_type,
            'preferred_role' => $request->preferred_role,
        ]);

        return redirect()->route('assessment.index')->with('success', 'Hasil assessment berhasil disimpan!');
    }
}