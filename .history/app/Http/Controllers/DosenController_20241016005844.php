<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(){
        $dosens = User::where('role','dosen')->get();
        return view('data_dosen.index',compact('dosens'));
    }

    public function post(Request $request){

    }

    public function edit(User $dosen)
    {
        try {
            // Mengambil data User berdasarkan ID
            $prodi = User::findOrFail($dosen->id);

            // Mengembalikan data dalam format JSON
            return response()->json($prodi, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User tidak ditemukan!',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, User $dosen) {
        // Validasi data
        $validatedData = $request->validate([
            'kode_prodi' => 'required|string',
            'nama_prodi' => 'required|string',
            'jenjang' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ], [
            'kode_prodi.required' => 'Kode User wajib diisi.',
            'kode_prodi.string' => 'Kode User harus berupa teks.',
            'nama_prodi.required' => 'Nama User wajib diisi.',
            'nama_prodi.string' => 'Nama User harus berupa teks.',
            'jenjang.required' => 'Jenjang User wajib diisi.',
            'jenjang.string' => 'Jenjang User harus berupa teks.',
            'visi.required' => 'Visi User wajib diisi.',
            'visi.string' => 'Visi User harus berupa teks.',
            'misi.required' => 'Misi User wajib diisi.',
            'misi.string' => 'Misi User harus berupa teks.',
        ]);

        try {
            $prodi = User::findOrFail($dosen->id);
            $prodi->update([
                'kode_prodi' => $request->kode_prodi,
                'nama_prodi' => $request->nama_prodi,
                'jenjang' => $request->jenjang,
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]);

            return response()->json(['message' => 'User berhasil diupdate.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(User $dosen) {
        try {
            $prodi = User::findOrFail($dosen->id);
            $prodi->delete();

            return response()->json(['message' => 'User berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
