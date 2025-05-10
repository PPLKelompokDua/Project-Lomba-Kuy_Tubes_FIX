<?php

namespace App\Http\Controllers;

use App\Models\TeamRecommendation;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeamRecommendationController extends Controller
{
    public function generateRecommendation()
{
    $assessment = Assessment::where('user_id', auth()->id())->latest()->first();

    Log::info('Assessment data:', ['assessment' => $assessment]);

    if ($assessment) {
        $recommendation = $this->analyzeAssessment($assessment);

        $teamRecommendation = TeamRecommendation::create([
            'user_id' => auth()->id(),
            'role_recommendation' => $recommendation['role'],
            'strengths' => $recommendation['strengths'],
            'weaknesses' => $recommendation['weaknesses'],
            'compatibility_score' => $recommendation['score'],
        ]);

        // 🔥 LOGIKA REKOMENDASI USER BERDASARKAN HASIL ASSESSMENT
        $user = auth()->user();

        $personalityMatch = match($user->personality_type) {
            'Conscientiousness' => ['Openness to Experience', 'Agreeableness'],
            'Openness to Experience' => ['Conscientiousness', 'Extraversion'],
            'Extraversion' => ['Supporter', 'Planner'],
            'Neuroticism' => ['Leader', 'Planner'],
            'Agreeableness' => ['Creative', 'Supporter'],
            default => [],
        };

        $roleMatch = match($user->preferred_role) {
            'Leader' => ['Planner', 'Supporter'],
            'Planner' => ['Leader', 'Supporter'],
            'Supporter' => ['Leader', 'Creative'],
            'Creative' => ['Planner', 'Leader'],
            default => [],
        };

        $recommendedUsers = \App\Models\User::where('role', 'user')
            ->where('id', '!=', $user->id)
            ->whereIn('personality_type', $personalityMatch)
            ->whereIn('preferred_role', $roleMatch)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('team-recommendation.show', [
            'teamRecommendation' => $teamRecommendation,
            'recommendedUsers' => $recommendedUsers, // <== kirim ke view
        ]);
    }

    return redirect()->route('assessment.index')->with('error', 'Silakan lengkapi assessment terlebih dahulu.');
} 
    private function analyzeAssessment($assessment)
    {
        $scores = json_decode($assessment->results, true);

        if (!is_array($scores)) {
            return $this->defaultRecommendation();
        }

        // Ubah penghitungan sesuai kategori yang ada
        $gayaKerja = $scores['Gaya Kerja']['A'] ?? 0;
        $leadership = $scores['Leadership & Problem Solving']['A'] ?? 0;
        $komunikasi = $scores['Komunikasi dalam Tim']['A'] ?? 0;

        $total = $gayaKerja + $leadership + $komunikasi;
        $compatibilityScore = round(($total / 18) * 100); // Asumsikan 6 soal per kategori (6*3 = 18)

        if ($leadership >= 4) {
            $role = 'Project Manager';
            $strengths = 'Leadership, Strategic Thinking';
            $weaknesses = 'Micromanagement';
        } elseif ($gayaKerja >= 4) {
            $role = 'Planner';
            $strengths = 'Organization, Planning';
            $weaknesses = 'Too rigid';
        } elseif ($komunikasi >= 4) {
            $role = 'Team Coordinator';
            $strengths = 'Communication, Mediation';
            $weaknesses = 'Emotional decisions';
        } else {
            $role = 'Support Member';
            $strengths = 'Helpful, Reliable';
            $weaknesses = 'Passive';
        }

        return [
            'role' => $role,
            'strengths' => $strengths,
            'weaknesses' => $weaknesses,
            'score' => min(100, max(0, $compatibilityScore)),
        ];
        if (empty($scores)) {
                return redirect()->route('assessment.form')->with('error', 'Tidak ada jawaban yang diberikan.');
            }
    }
}
