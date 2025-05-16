<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment;
use App\Models\AssessmentHistory;
use App\Models\AssessmentQuestion;

class AssessmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $history = $user->assessmentHistories()->latest()->take(5)->get();
        $latestAssessment = Assessment::where('user_id', $user->id)->latest()->first();

        return view('assessment.index', compact('history', 'latestAssessment'));
    }

    public function showTestForm()
    {
        $questions = AssessmentQuestion::with('options')->get()->groupBy('category');
        return view('assessment.form', compact('questions'));
    }

    public function submitTest(Request $request)
    {
        $user = auth()->user();

        // Ambil semua ID pertanyaan dari DB
        $questions = \App\Models\AssessmentQuestion::pluck('id')->toArray();

        // Buat aturan validasi untuk setiap jawaban
        $rules = [];
        foreach ($questions as $id) {
            $rules["answers.$id"] = 'required';
        }

        $request->validate($rules, [
            'answers.*.required' => 'Semua pertanyaan harus dijawab.'
        ]);

        $answers = $request->input('answers');
        $scores = [];

        foreach ($answers as $questionId => $choice) {
            $question = \App\Models\AssessmentQuestion::find($questionId);
            $category = $question->category;

            if (!isset($scores[$category])) {
                $scores[$category] = ['A' => 0, 'B' => 0];
            }

            $scores[$category][$choice]++;
        }

        // ====== Penentuan personality dan role sederhana ======
        $preferred_role = 'Supporter';
        $personality_type = 'Agreeableness';

        if (($scores['Gaya Kerja']['A'] ?? 0) > ($scores['Gaya Kerja']['B'] ?? 0)) {
            $preferred_role = 'Planner';
        } else {
            $preferred_role = 'Creative';
        }

        if (($scores['Leadership & Problem Solving']['A'] ?? 0) > ($scores['Leadership & Problem Solving']['B'] ?? 0)) {
            $personality_type = 'Conscientiousness';
        } elseif (($scores['Komunikasi dalam Tim']['A'] ?? 0) > ($scores['Komunikasi dalam Tim']['B'] ?? 0)) {
            $personality_type = 'Extraversion';
        }

        // ====== Penentuan hasil rekomendasi tim langsung ======
        $gayaKerja = $scores['Gaya Kerja']['A'] ?? 0;
        $leadership = $scores['Leadership & Problem Solving']['A'] ?? 0;
        $komunikasi = $scores['Komunikasi dalam Tim']['A'] ?? 0;

        $rekomTotal = $gayaKerja + $leadership + $komunikasi;
        $compatibilityScore = round(($rekomTotal / 18) * 100); // 18 = 6 soal * 3 kategori

        if ($leadership >= 4) {
            $recommendedRole = 'Project Manager';
            $strengths = 'Leadership, Strategic Thinking';
            $weaknesses = 'Micromanagement';
        } elseif ($gayaKerja >= 4) {
            $recommendedRole = 'Planner';
            $strengths = 'Organization, Planning';
            $weaknesses = 'Too Rigid';
        } elseif ($komunikasi >= 4) {
            $recommendedRole = 'Team Coordinator';
            $strengths = 'Communication, Mediation';
            $weaknesses = 'Emotional Decisions';
        } else {
            $recommendedRole = 'Support Member';
            $strengths = 'Helpful, Reliable';
            $weaknesses = 'Passive';
        }

        $totalScore = array_sum(array_map(function ($group) {
            return $group['A'] + $group['B'];
        }, $scores));

        // ====== Simpan ke User ======
        $user->update([
            'personality_type' => $personality_type,
            'preferred_role' => $preferred_role,
        ]);

        // ====== Simpan ke assessments ======
        \App\Models\Assessment::create([
            'user_id' => $user->id,
            'personality_type' => $personality_type,
            'preferred_role' => $preferred_role,
            'results' => json_encode($scores),
            'total_score' => $totalScore,
            'recommended_role' => $recommendedRole,
            'strengths' => $strengths,
            'weaknesses' => $weaknesses,
            'compatibility_score' => $compatibilityScore,
        ]);

        // ====== Simpan ke riwayat ======
        \App\Models\AssessmentHistory::create([
            'user_id' => $user->id,
            'assessment_data' => json_encode($scores),
            'personality_type' => $personality_type,
            'preferred_role' => $preferred_role,
        ]);

        return redirect()->route('assessment.index')->with('success', 'Test Result succesfully saved');
    }

}
