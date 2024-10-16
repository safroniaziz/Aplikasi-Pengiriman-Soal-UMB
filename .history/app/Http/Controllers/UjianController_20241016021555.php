<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function index(){
        // Ambil semua data ujian dengan relasi ke mata kuliah
        $ujians = Ujian::with('mataKuliah')->orderBy('created_at', 'desc')->get();
        $mataKuliahs = MataKuliah::all();  // Untuk form dropdown

        return view('ujian.index', compact('ujians', 'mataKuliahs'));
    }
}
