<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index(){
        $prodis = ProgramStudi::all();
        return view('program_studi.index',compact('prodis'));
    }

    public function prodiPost(Request $request){
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
        ]);

        try {
            $simpan = ProgramStudi::create([
                'nama_kategori' =>  $request->nama_kategori
            ]);

            return response()->json([
                'message' => 'Kategori anggota berhasil disimpan.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function prodiUpdate(Request $request, KategoriAnggota $kategoriAnggota) {
        // Validasi data
        $request->validate([
            'nama_kategori' => 'required|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
        ]);

        try {
            $kategoriAnggota = ProgramStudi::findOrFail($kategoriAnggota->id);
            $kategoriAnggota->update([
                'nama_kategori' => $request->nama_kategori,
            ]);

            return response()->json(['message' => 'Kategori anggota berhasil diupdate.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function kategoriAnggotaDelete(KategoriAnggota $kategoriAnggota) {
        try {
            $kategoriAnggota = ProgramStudi::findOrFail($kategoriAnggota->id);
            $kategoriAnggota->delete();

            return response()->json(['message' => 'Kategori berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
