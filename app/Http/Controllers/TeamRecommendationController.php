<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\TeamRecommendation;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TeamRecommendationController extends Controller
{
    public function generateRecommendation()
    {
        $assessment = Assessment::where('user_id', auth()->id())->latest()->first();

        Log::info('Assessment data:', ['assessment' => $assessment]);

        if (!$assessment) {
            return redirect()->route('assessment.index')->with('error', 'Silakan lengkapi assessment terlebih dahulu.');
        }

        $recommendation = $this->analyzeAssessment($assessment);
        
        if (!$recommendation) {
            return redirect()->route('assessment.form')->with('error', 'Terjadi kesalahan saat menganalisis assessment.');
        }

        $teamRecommendation = TeamRecommendation::create([
            'user_id' => auth()->id(),
            'role_recommendation' => $recommendation['role'],
            'strengths' => $recommendation['strengths'],
            'weaknesses' => $recommendation['weaknesses'],
            'compatibility_score' => $recommendation['score'],
        ]);

        $user = auth()->user();
        $recommendedUsers = $this->findMatchingUsers($user);

        return view('team-recommendation.show', [
            'teamRecommendation' => $teamRecommendation,
            'recommendedUsers' => $recommendedUsers,
        ]);
    }

    private function findMatchingUsers($user)
    {
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

        return User::where('role', 'user')
            ->where('id', '!=', $user->id)
            ->whereIn('personality_type', $personalityMatch)
            ->whereIn('preferred_role', $roleMatch)
            ->inRandomOrder()
            ->limit(6)
            ->get();
    }

    private function analyzeAssessment($assessment)
    {
        $scores = json_decode($assessment->results, true);

        if (!is_array($scores)) {
            return $this->defaultRecommendation();
        }

        $gayaKerja = $scores['Gaya Kerja']['A'] ?? 0;
        $leadership = $scores['Leadership & Problem Solving']['A'] ?? 0;
        $komunikasi = $scores['Komunikasi dalam Tim']['A'] ?? 0;

        $total = $gayaKerja + $leadership + $komunikasi;
        $compatibilityScore = round(($total / 18) * 100);

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
    }

    private function defaultRecommendation()
    {
        return [
            'role' => 'Team Member',
            'strengths' => 'Adaptable',
            'weaknesses' => 'Needs more assessment',
            'score' => 50,
        ];
    }

    private function calculateMatchScore($assessment1, $assessment2)
    {
        $score = 0;
        
        if ($assessment1->expertise === $assessment2->expertise) $score += 30;
        if ($assessment1->work_style === $assessment2->work_style) $score += 25;
        if (abs($assessment1->experience_level - $assessment2->experience_level) <= 1) $score += 20;
        if ($assessment1->communication_style === $assessment2->communication_style) $score += 15;
        if ($assessment1->availability === $assessment2->availability) $score += 10;
        
        return $score;
    }
}