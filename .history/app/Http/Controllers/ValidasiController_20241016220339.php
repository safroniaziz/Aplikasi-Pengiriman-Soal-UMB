<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index(){
        $ujians = Ujian::with(['mataKuliah.prodi', 'kopSoalUjian', 'soalUjian', 'pengupload'])
                        ->where('pengupload_id',Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('data_ujian.index', compact('ujians'));
    }
}
