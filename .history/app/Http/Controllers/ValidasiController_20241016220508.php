<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function index(){
        $ujians = Ujian::with(['mataKuliah.prodi', 'kopSoalUjian', 'soalUjian', 'pengupload'])
                        ->whereHas('mataKuliah.prodi', function ($query) {
                            $query->where('id', Auth::user()->prodi_id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('validasi.index', compact('ujians'));
    }
}
