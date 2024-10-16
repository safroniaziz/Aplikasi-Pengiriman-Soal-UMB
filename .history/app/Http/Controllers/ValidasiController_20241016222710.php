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

    public function post(Request $request, SoalUjian $soal){
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
            // Cari soal ujian berdasarkan ID
            $soalUjian = SoalUjian::findOrFail($soalUjianId);

            // Simpan status dan catatan validasi ke database
            $soalUjian->status = $validatedData['status'];
            $soalUjian->catatan_kaprodi = $validatedData['catatan_kaprodi'];
            $soalUjian->save();

            // Berikan respons JSON jika berhasil
            return response()->json(['message' => 'Validasi berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            // Jika ada kesalahan lain (misal, soal tidak ditemukan), kirim respons error
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan validasi.'], 500);
        }
    }
}
