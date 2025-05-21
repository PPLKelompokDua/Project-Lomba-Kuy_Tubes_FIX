<?php

namespace App\Http\Controllers;

use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function show()
    {
        $result = Auth::user()->assessmentResults()->latest()->first();
        return view('assessment.result', compact('result'));
    }

    public function retake()
    {
        // Tampilkan form assessment baru
        return view('assessment.retake');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'result' => 'required|string'
        ]);

        AssessmentResult::create([
            'user_id' => Auth::id(),
            'result' => $validated['result']
        ]);

        return redirect()->route('assessment.result')->with('success', 'Assessment diperbarui.');
    }
}
