<?php

namespace App\Http\Controllers;

use App\Models\ReviewTugas;
use Illuminate\Http\Request;

class ReviewTugasController extends Controller
{
    public function index()
    {
        $tasks = ReviewTugas::all()->groupBy('status');
        return view('task.board', compact('tasks'));
    }

    public function store(Request $request)
    {
        $task = ReviewTugas::create([
            'title'      => $request->title,
            'status'     => $request->status,
            'author'     => $request->author,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date
        ]);

        return response()->json(['id' => $task->id]);
    }

    public function update(Request $request, ReviewTugas $tugas)
    {
        $tugas->update([
            'status'     => $request->status,
            'author'     => $request->author ?? $tugas->author,
            'start_date' => $request->start_date ?? $tugas->start_date,
            'end_date'   => $request->end_date ?? $tugas->end_date,
        ]);

        return response()->json(['success' => true]);
    }
}
