<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda
     */
    public function index()
    {
        return view('home'); // pastikan ada view 'home.blade.php'
    }
}
