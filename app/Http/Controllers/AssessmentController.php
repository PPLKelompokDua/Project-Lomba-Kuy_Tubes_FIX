<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessment = Assessment::where('user_id', auth()->id())->first();
        return view('assessment.index', compact('assessment'));
    }

    public function showTestForm()
    {
        return view('assessment.form');
    }

    public function submitTest(Request $request)
    {
        $validated = $request->validate([
            'work_style' => 'required|string',
            'expertise' => 'required|string',
            'experience_level' => 'required|integer|min:1|max:5',
            'communication_style' => 'required|string',
            'availability' => 'required|string',
        ]);

        Assessment::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                ...$validated,
                'last_completed_at' => now()
            ]
        );

        return redirect()->route('assessment.index')
            ->with('success', 'Assessment berhasil disimpan!');
    }
}
