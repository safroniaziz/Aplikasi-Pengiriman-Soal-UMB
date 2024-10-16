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

    public function post(Request $request){
        $validatedData = $request->validate([
            'nama_prodi' => 'required|string',
        ], [
            'nama_prodi.required' => 'Nama kategori wajib diisi.',
            'nama_prodi.string' => 'Nama kategori harus berupa teks.',
        ]);

        try {
            $simpan = ProgramStudi::create([
                'nama_prodi' =>  $request->nama_prodi
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

    public function update(Request $request, ProgramStudi $prodi) {
        // Validasi data
        $request->validate([
            'nama_prodi' => 'required|string',
        ], [
            'nama_prodi.required' => 'Nama kategori wajib diisi.',
            'nama_prodi.string' => 'Nama kategori harus berupa teks.',
        ]);

        try {
            $prodi = ProgramStudi::findOrFail($prodi->id);
            $prodi->update([
                'nama_prodi' => $request->nama_prodi,
            ]);

            return response()->json(['message' => 'Program Studi berhasil diupdate.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(ProgramStudi $prodi) {
        try {
            $prodi = ProgramStudi::findOrFail($prodi->id);
            $prodi->delete();

            return response()->json(['message' => 'Program Studi berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
