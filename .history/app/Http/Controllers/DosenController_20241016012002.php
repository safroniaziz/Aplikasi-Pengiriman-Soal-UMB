<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index(){
        $dosens = User::where('role','dosen')->get();
        $prodis = ProgramStudi::all();
        return view('data_dosen.index',compact('dosens','prodis'));
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'kode_user' => 'required|string',
            'nidn' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',  // Validasi email
            'password' => 'required|string|min:8|confirmed',  // Validasi password dengan konfirmasi
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
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'prodi_id.exists' => 'Program studi tidak ditemukan.',
        ]);

        try {
            // Menyimpan data user
            $simpan = User::create([
                'kode_user' => $request->kode_user,
                'nidn' => $request->nidn,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'role' => $request->role,
                'prodi_id' => $request->prodi_id,  // Tambahkan prodi_id
                'password' => Hash::make($request->password),  // Hash password sebelum disimpan
                'role'
            ]);

            return response()->json([
                'message' => 'Dosen berhasil disimpan.',
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
            // Mengambil data User berdasarkan ID
            $data = User::findOrFail($dosen->id);

            // Mengembalikan data dalam format JSON
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Dosen tidak ditemukan!',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, User $dosen) {
        // Validasi data
        $validatedData = $request->validate([
            'kode_user' => 'required|string',
            'nidn' => 'required|string',
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $dosen->id,  // Mengabaikan email yang sama dengan user yang sedang diupdate
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
            $user = User::findOrFail($dosen->id);

            // Update data kecuali password
            $user->update([
                'kode_user' => $request->kode_user,
                'nidn' => $request->nidn,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'role' => $request->role,
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

    public function delete(User $dosen) {
        try {
            $data = User::findOrFail($dosen->id);
            $data->delete();

            return response()->json(['message' => 'Dosen berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
