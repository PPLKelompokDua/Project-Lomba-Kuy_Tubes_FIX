<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|max:150',
            'message' => 'required|max:1000',
        ]);

        // Simpan ke database
        Contact::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->to(url()->previous() . '#contact')->with('success', 'Pesan Anda berhasil dikirim!');
    }
}
