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
        if (empty($assessment->results)) {
            return $this->defaultRecommendation();
        }

        $scores = is_array($assessment->results)
            ? $assessment->results
            : json_decode($assessment->results, true);

        if (!is_array($scores)) {
            return $this->defaultRecommendation();
        }

        $logical = $scores['logical'] ?? 0;
        $emotional = $scores['emotional'] ?? 0;
        $teamwork = $scores['teamwork'] ?? 0;

        $averageScore = ($logical + $emotional + $teamwork) / 3;
        $compatibilityScore = round($averageScore);

        // Penentuan role lebih make sense
        if ($logical >= 80 && $teamwork >= 70) {
            $role = 'Project Manager';
            $strengths = 'Leadership, Decision Making';
            $weaknesses = 'Detail Orientation';
        } elseif ($emotional >= 80 && $teamwork >= 70) {
            $role = 'Team Leader';
            $strengths = 'Empathy, Motivation';
            $weaknesses = 'Overthinking';
        } elseif ($logical >= 60 && $teamwork >= 60) {
            $role = 'Core Member';
            $strengths = 'Problem Solving, Critical Thinking';
            $weaknesses = 'Communication Skills';
        } elseif ($teamwork >= 50) {
            $role = 'Support Member';
            $strengths = 'Teamwork, Cooperation';
            $weaknesses = 'Initiative Taking';
        } else {
            $role = 'Freelance Member';
            $strengths = 'Flexibility';
            $weaknesses = 'Consistency';
        }

        return [
            'role' => $role,
            'strengths' => $strengths,
            'weaknesses' => $weaknesses,
            'score' => min(100, max(0, $compatibilityScore)),
        ];
    }

    private function defaultRecommendation()
    {
        return [
            'role' => 'Support Member',
            'strengths' => 'Adaptability',
            'weaknesses' => 'Limited Leadership',
            'score' => 50,
        ];
    }
}
