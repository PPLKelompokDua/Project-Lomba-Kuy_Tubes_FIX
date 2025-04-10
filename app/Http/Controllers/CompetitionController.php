<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    
    public function explore()
    {
        // Gunakan paginate() untuk bisa pakai ->links() di blade
        $competitions = \App\Models\Competition::latest()->paginate(12);
        return view('competitions.explore', compact('competitions')); 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitions = \App\Models\Competition::latest()->paginate(12); // 12 item per page
        return view('competitions.explore', compact('competitions')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
