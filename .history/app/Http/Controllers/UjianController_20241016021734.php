<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Ujian;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function index(){
        // Ambil semua data ujian dengan relasi ke mata kuliah
        $ujians = Ujian::with('mataKuliah')->orderBy('created_at', 'desc')->get();
        $mataKuliahs = MataKuliah::all();  // Untuk form dropdown

        return view('ujian.index', compact('ujians', 'mataKuliahs'));
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',  // Validasi mata_kuliah_id harus ada di tabel mata_kuliahs
            'tanggal_dilaksanakan' => 'required|date',  // Validasi tanggal
            'waktu_mulai' => 'required|date_format:H:i',  // Validasi waktu mulai dalam format H:i
            'waktu_selesai' => 'required|date_format:H:i',  // Validasi waktu selesai dalam format H:i
            'ruangan' => 'required|string',  // Validasi ruangan harus berupa teks
            'batas_waktu_upload_soal' => 'required|date',  // Validasi batas waktu upload soal
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak ditemukan.',
            'tanggal_dilaksanakan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'ruangan.required' => 'Ruangan wajib diisi.',
            'batas_waktu_upload_soal.required' => 'Batas waktu upload soal wajib diisi.',
        ]);

        try {
            // Menyimpan data ujian
            $simpan = Ujian::create([
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'tanggal_dilaksanakan' => $request->tanggal_dilaksanakan,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'ruangan' => $request->ruangan,
                'batas_waktu_upload_soal' => $request->batas_waktu_upload_soal,
            ]);

            return response()->json([
                'message' => 'Ujian berhasil disimpan.',
                'data' => $simpan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Ujian $ujian)
    {
        try {
            // Mengambil data Ujian berdasarkan ID
            $data = Ujian::findOrFail($ujian->id);

            // Mengembalikan data dalam format JSON
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ujian tidak ditemukan!',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function update(Request $request, Ujian $ujian) {
        // Validasi data
        $validatedData = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',  // Validasi mata_kuliah_id
            'tanggal_dilaksanakan' => 'required|date',  // Validasi tanggal
            'waktu_mulai' => 'required|date_format:H:i',  // Validasi waktu mulai
            'waktu_selesai' => 'required|date_format:H:i',  // Validasi waktu selesai
            'ruangan' => 'required|string',  // Validasi ruangan
            'batas_waktu_upload_soal' => 'required|date',  // Validasi batas waktu upload soal
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak ditemukan.',
            'tanggal_dilaksanakan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'ruangan.required' => 'Ruangan wajib diisi.',
            'batas_waktu_upload_soal.required' => 'Batas waktu upload soal wajib diisi.',
        ]);

        try {
            // Temukan ujian berdasarkan ID
            $ujian->update([
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'tanggal_dilaksanakan' => $request->tanggal_dilaksanakan,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'ruangan' => $request->ruangan,
                'batas_waktu_upload_soal' => $request->batas_waktu_upload_soal,
            ]);

            return response()->json([
                'message' => 'Ujian berhasil diperbarui.',
                'data' => $ujian,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Ujian $ujian) {
        try {
            $data = Ujian::findOrFail($ujian->id);
            $data->delete();

            return response()->json(['message' => 'Ujian berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }


}
