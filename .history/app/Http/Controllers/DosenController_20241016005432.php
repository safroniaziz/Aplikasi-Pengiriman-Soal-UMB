<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(){
        $prodis = ProgramStudi::all();
        return view('program_studi.index',compact('prodis'));
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'kode_prodi' => 'required|string',
            'nama_prodi' => 'required|string',
            'jenjang' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ], [
            'kode_prodi.required' => 'Kode program studi wajib diisi.',
            'kode_prodi.string' => 'Kode program studi harus berupa teks.',
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.string' => 'Nama program studi harus berupa teks.',
            'jenjang.required' => 'Jenjang program studi wajib diisi.',
            'jenjang.string' => 'Jenjang program studi harus berupa teks.',
            'visi.required' => 'Visi program studi wajib diisi.',
            'visi.string' => 'Visi program studi harus berupa teks.',
            'misi.required' => 'Misi program studi wajib diisi.',
            'misi.string' => 'Misi program studi harus berupa teks.',
        ]);

        try {
            // Menyimpan data program studi
            $simpan = ProgramStudi::create([
                'kode_prodi' => $request->kode_prodi,
                'nama_prodi' => $request->nama_prodi,
                'jenjang' => $request->jenjang,
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]);

            return response()->json([
                'message' => 'Program studi berhasil disimpan.',
                'data' => $simpan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(ProgramStudi $programStudi)
    {
        try {
            // Mengambil data program studi berdasarkan ID
            $prodi = ProgramStudi::findOrFail($programStudi->id);

            // Mengembalikan data dalam format JSON
            return response()->json($prodi, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Program studi tidak ditemukan!',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, ProgramStudi $programStudi) {
        // Validasi data
        $validatedData = $request->validate([
            'kode_prodi' => 'required|string',
            'nama_prodi' => 'required|string',
            'jenjang' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ], [
            'kode_prodi.required' => 'Kode program studi wajib diisi.',
            'kode_prodi.string' => 'Kode program studi harus berupa teks.',
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.string' => 'Nama program studi harus berupa teks.',
            'jenjang.required' => 'Jenjang program studi wajib diisi.',
            'jenjang.string' => 'Jenjang program studi harus berupa teks.',
            'visi.required' => 'Visi program studi wajib diisi.',
            'visi.string' => 'Visi program studi harus berupa teks.',
            'misi.required' => 'Misi program studi wajib diisi.',
            'misi.string' => 'Misi program studi harus berupa teks.',
        ]);

        try {
            $prodi = ProgramStudi::findOrFail($programStudi->id);
            $prodi->update([
                'kode_prodi' => $request->kode_prodi,
                'nama_prodi' => $request->nama_prodi,
                'jenjang' => $request->jenjang,
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]);

            return response()->json(['message' => 'Program Studi berhasil diupdate.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(ProgramStudi $programStudi) {
        try {
            $prodi = ProgramStudi::findOrFail($programStudi->id);
            $prodi->delete();

            return response()->json(['message' => 'Program Studi berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
