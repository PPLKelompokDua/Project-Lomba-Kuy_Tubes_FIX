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
        $questions = config('assessment_questions');
        return view('assessment.index', compact('questions'));
    }

    public function showResults()
    {
        $user = Auth::user();
    $assessment = Assessment::where('user_id', $user->id)->latest()->first();

    if (!$assessment) {
        return redirect()->route('assessment.index')->with('error', 'Assessment belum tersedia.');
    }

    // Decode hasil skor
    $scoresRaw = json_decode($assessment->results, true);
    $scores = [];

    $roles = [];

    foreach ($scoresRaw as $category => $values) {
        $total = $values['A'] + $values['B'];
        if ($total == 0) {
            $scores[$category] = ['A' => 0, 'B' => 0];
        } else {
            $scores[$category] = [
                'A' => round(($values['A'] / $total) * 100),
                'B' => round(($values['B'] / $total) * 100),
            ];
        }

        // Role per kategori (bisa kamu kembangkan sesuai kebutuhan)
        if ($category === 'Gaya Kerja') {
            $roles[$category] = $values['A'] > $values['B'] ? 'Visioner' : 'Eksekutor';
        } elseif ($category === 'Leadership & Problem Solving') {
            $roles[$category] = $values['A'] > $values['B'] ? 'Perencana' : 'Penggerak';
        } else {
            $roles[$category] = 'Pendukung';
        }
    }

    return view('assessment.result', [
        'scores' => $scores,
        'roles' => $roles,
        'personality_type' => $assessment->personality_type,
        'preferred_role' => $assessment->preferred_role,
        ]);

        Assessment::create([
            'user_id' => $user->id,
            'personality_type' => $personality_type,
            'preferred_role' => $preferred_role,
            'results' => json_encode([
                'raw_scores' => $scores,
                'percentages' => $percentageScores,
                'roles' => $roleMapping,
            ]),
        ]);

        AssessmentHistory::create([
            'user_id' => $user->id,
            'assessment_data' => json_encode($data),
            'personality_type' => $personality_type,
            'preferred_role' => $preferred_role,
        ]);

        return view('assessment.result', [
            'scores' => $percentageScores,
            'personality_type' => $personality_type,
            'preferred_role' => $preferred_role,
            'roles' => $roleMapping,
        ]);
    }
}
