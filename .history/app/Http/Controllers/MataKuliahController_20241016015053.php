<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(){
        $mataKuliahs = MataKuliah::orderBy('created_at','desc')->get();
        $prodis = ProgramStudi::all();
        return view('mata_kuliah.index',compact('mataKuliahs','prodis'));
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'prodi_id' => 'required|exists:program_studis,id',  // Validasi prodi_id harus ada di tabel program_studis
            'kode_mata_kuliah' => 'required|string|unique:mata_kuliah,kode_mata_kuliah',  // Validasi kode mata kuliah harus unik
            'nama_mata_kuliah' => 'required|string',  // Validasi nama mata kuliah
        ], [
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'prodi_id.exists' => 'Program studi tidak ditemukan.',
            'kode_mata_kuliah.required' => 'Kode mata kuliah wajib diisi.',
            'kode_mata_kuliah.string' => 'Kode mata kuliah harus berupa teks.',
            'kode_mata_kuliah.unique' => 'Kode mata kuliah sudah terdaftar.',
            'nama_mata_kuliah.required' => 'Nama mata kuliah wajib diisi.',
            'nama_mata_kuliah.string' => 'Nama mata kuliah harus berupa teks.',
        ]);

        try {
            // Menyimpan data mata kuliah
            $simpan = MataKuliah::create([
                'prodi_id' => $request->prodi_id,  // Menyimpan prodi_id
                'kode_mata_kuliah' => $request->kode_mata_kuliah,  // Menyimpan kode mata kuliah
                'nama_mata_kuliah' => $request->nama_mata_kuliah,  // Menyimpan nama mata kuliah
            ]);

            return response()->json([
                'message' => 'Mata kuliah berhasil disimpan.',
                'data' => $simpan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(MataKuliah $mataKuliah)
    {
        try {
            // Mengambil data MataKuliah berdasarkan ID
            $data = MataKuliah::findOrFail($mataKuliah->id);

            // Mengembalikan data dalam format JSON
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Dosen tidak ditemukan!',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, User $mataKuliah) {
        // Validasi data
        $validatedData = $request->validate([
            'kode_user' => 'required|string',
            'nidn' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $mataKuliah->id,  // Mengabaikan email yang sama dengan user yang sedang diupdate
            'password' => 'nullable|string|min:8|confirmed',  // Password tidak wajib, tapi harus minimal 8 karakter dan konfirmasi jika diisi
            'prodi_id'  =>  'required|exists:program_studis,id',  // Validasi prodi_id harus ada di tabel program_studis
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
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'prodi_id.exists' => 'Program studi tidak ditemukan.',
        ]);

        try {
            // Temukan user berdasarkan ID
            $user = User::findOrFail($mataKuliah->id);

            // Update data kecuali password
            $user->update([
                'kode_user' => $request->kode_user,
                'nidn' => $request->nidn,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'prodi_id' => $request->prodi_id,  // Tambahkan prodi_id
            ]);

            // Jika password diisi dan valid, update password
            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            return response()->json([
                'message' => 'User berhasil diperbarui.',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(User $mataKuliah) {
        try {
            $data = User::findOrFail($mataKuliah->id);
            $data->delete();

            return response()->json(['message' => 'Dosen berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
