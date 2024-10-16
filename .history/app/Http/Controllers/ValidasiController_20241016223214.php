<?php

namespace App\Http\Controllers;

use App\Models\SoalUjian;
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

    namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoalUjian;

class ValidasiController extends Controller
{
    public function post(Request $request, SoalUjian $soal)
    {
        // Validasi input yang diterima dari form
        $validatedData = $request->validate([
            'status' => 'required|in:pending,validated,rejected',  // Hanya menerima status tertentu
            'catatan_kaprodi' => 'nullable|string|max:255',  // Catatan kaprodi opsional
        ], [
            // Pesan validasi dalam bahasa Indonesia
            'status.required' => 'Status validasi wajib diisi.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'catatan_kaprodi.string' => 'Catatan harus berupa teks.',
            'catatan_kaprodi.max' => 'Catatan tidak boleh lebih dari 255 karakter.',
        ]);

        try {
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

}
