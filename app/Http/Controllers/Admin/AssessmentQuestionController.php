<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentOption;
use Illuminate\Http\Request;

class AssessmentQuestionController extends Controller
{
    public function index()
    {
        $questions = \App\Models\AssessmentQuestion::with('options')->orderBy('category')->get();
        return view('admin.assessment.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.assessment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'question' => 'required|string',
            'options.*.label' => 'required|string',
            'options.*.text' => 'required|string',
        ]);

        $question = AssessmentQuestion::create([
            'category' => $request->category,
            'question' => $request->question,
        ]);

        foreach ($request->options as $opt) {
            AssessmentOption::create([
                'assessment_question_id' => $question->id, // <-- tambahkan ini
                'label' => $opt['label'],
                'text' => $opt['text'],
            ]);
        }

        return redirect()->route('admin.assessment-questions.index')->with('success', 'Question successfully Added.');
    }

    public function edit(AssessmentQuestion $assessment_question)
    {
        $assessment_question->load('options');
        return view('admin.assessment.edit', compact('assessment_question'));
    }

    public function update(Request $request, AssessmentQuestion $assessment_question)
    {
        $request->validate([
            'category' => 'required|string',
            'question' => 'required|string',
            'options.*.label' => 'required|string',
            'options.*.text' => 'required|string',
        ]);

        $assessment_question->update([
            'category' => $request->category,
            'question' => $request->question,
        ]);

        // Hapus lama, tambah baru (atau ubah logic kalau ingin lebih presisi)
        $assessment_question->options()->delete();

        foreach ($request->options as $opt) {
            AssessmentOption::create([
                'assessment_question_id' => $assessment_question->id,
                'label' => $opt['label'],
                'text' => $opt['text'],
            ]);
        }

        return redirect()->route('admin.assessment-questions.index')->with('success', 'Question successfully updated.');
    }

    public function destroy($id)
    {
        $assessment_question = AssessmentQuestion::findOrFail($id);
        $assessment_question->options()->delete();
        $assessment_question->delete();

        return redirect()->route('admin.assessment-questions.index')->with('success', 'Question successfully deleted.');
    }
}
