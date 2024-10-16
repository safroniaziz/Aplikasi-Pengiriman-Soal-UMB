<?php

namespace App\Http\Controllers;

use App\Models\SoalUjian;
use App\Models\Ujian;
use App\Models\Validasi;
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

    public function post(Request $request, SoalUjian $soal)
    {
        // Validasi input yang diterima dari form
        $validatedData = $request->validate([
            'status' => 'required|in:validated,rejected',  // Hanya menerima status tertentu
            'catatan_kaprodi' => 'nullable|string|max:255',  // Catatan kaprodi opsional
        ], [
            // Pesan validasi dalam bahasa Indonesia
            'status.required' => 'Status validasi wajib diisi.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'catatan_kaprodi.string' => 'Catatan harus berupa teks.',
            'catatan_kaprodi.max' => 'Catatan tidak boleh lebih dari 255 karakter.',
        ]);

        try {

            Validasi::create([
                'soal_id'   =>  $soal->id,
                ''
            ]);
            // Simpan status dan catatan validasi ke database
            $soal->status = $validatedData['status'];
            $soal->catatan_kaprodi = $validatedData['catatan_kaprodi'];
            $soal->save();

            // Berikan respons JSON jika berhasil
            return response()->json(['message' => 'Validasi berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            // Kirim pesan error spesifik dari exception
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan validasi.',
                'error' => $e->getMessage() // Mengirimkan pesan kesalahan yang lebih detail
            ], 500);
        }
    }

}