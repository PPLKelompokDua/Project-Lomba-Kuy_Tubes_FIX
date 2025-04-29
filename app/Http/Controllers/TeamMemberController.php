<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
        ]);

        $members = session()->get('manualMembers', []);
        $members[] = $request->member_name;
        session()->put('manualMembers', $members);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function update(Request $request, $index)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
        ]);

        $members = session()->get('manualMembers', []);
        if (isset($members[$index])) {
            $members[$index] = $request->member_name;
            session()->put('manualMembers', $members);
        }

        return redirect()->back()->with('success', 'Anggota berhasil diperbarui!');
    }

    public function destroy($index)
    {
        $members = session()->get('manualMembers', []);
        if (isset($members[$index])) {
            unset($members[$index]);
            session()->put('manualMembers', array_values($members)); // re-index
        }

        return redirect()->back()->with('success', 'Anggota berhasil dihapus!');
    }
}