<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(){
        $prodis = User::where('role','dosen')->get();
        return view('program_studi.index',compact('prodis'));
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'kode_user' => 'required|string',
            'nidn' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',  // Validasi email dan unik di tabel users
            'role' => 'required|in:admin,dosen,kaprodi', // Validasi role harus sesuai dengan salah satu nilai
            'password' => 'required|string|min:8', // Validasi password harus minimal 8 karakter
        ], [
            'kode_user.required' => 'Kode user wajib diisi.',
            'kode_user.string' => 'Kode user harus berupa teks.',
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.string' => 'NIDN harus berupa teks.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
        ]);

        try {
            // Menyimpan data user
            $simpan = User::create([
                'kode_user' => $request->kode_user,
                'nidn' => $request->nidn,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),  // Hash password sebelum disimpan
            ]);

            return response()->json([
                'message' => 'User berhasil disimpan.',
                'data' => $simpan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function edit(User $dosen)
    {
        try {
            // Mengambil data program studi berdasarkan ID
            $prodi = User::findOrFail($programStudi->id);

            // Mengembalikan data dalam format JSON
            return response()->json($prodi, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Program studi tidak ditemukan!',
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
            $prodi = User::findOrFail($programStudi->id);
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

    public function delete(User $dosen) {
        try {
            $prodi = User::findOrFail($programStudi->id);
            $prodi->delete();

            return response()->json(['message' => 'Program Studi berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
