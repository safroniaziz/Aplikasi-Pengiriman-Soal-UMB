<?php

namespace App\Http\Controllers;

use App\Models\KopSoalUjian;
use App\Models\MataKuliah;
use App\Models\SoalUjian;
use App\Models\Ujian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UjianController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == "admin") {
            $ujians = Ujian::with(['mataKuliah.prodi', 'kopSoalUjian', 'soalUjian', 'pengupload'])
                        ->orderBy('created_at', 'desc')
                        ->get();
            $mataKuliahs = MataKuliah::all();  // Untuk form dropdown
            return view('data_ujian.index', compact('ujians', 'mataKuliahs'));
        } else {
            $ujians = Ujian::with(['mataKuliah.prodi', 'kopSoalUjian', 'soalUjian', 'pengupload'])
                        ->where('pengupload_id',Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
            return view('data_ujian.index', compact('ujians'));
        }
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',  // Validasi mata_kuliah_id harus ada di tabel mata_kuliahs
            'tanggal_dilaksanakan' => 'required|date',  // Validasi tanggal
            'waktu_mulai' => 'required|date_format:H:i',  // Validasi waktu mulai dalam format H:i
            'waktu_selesai' => 'required|date_format:H:i',  // Validasi waktu selesai dalam format H:i
            'ruangan' => 'required|string',  // Validasi ruangan harus berupa teks
            'batas_waktu_upload_soal' => 'required|date',  // Validasi batas waktu upload soal
            'pengupload_id' => 'required|exists:users,id',  // Validasi dosen_id harus valid
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak ditemukan.',
            'tanggal_dilaksanakan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'ruangan.required' => 'Ruangan wajib diisi.',
            'batas_waktu_upload_soal.required' => 'Batas waktu upload soal wajib diisi.',
            'pengupload_id.required' => 'Dosen pengupload wajib dipilih.',
            'pengupload_id.exists' => 'Dosen pengupload tidak ditemukan.',
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
                'pengupload_id' => $request->pengupload_id,
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
            'batas_waktu_upload_soal' => 'required',
            'pengupload_id' => 'required|exists:users,id',  // Validasi dosen_id harus valid
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih.',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak ditemukan.',
            'tanggal_dilaksanakan.required' => 'Tanggal pelaksanaan wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'ruangan.required' => 'Ruangan wajib diisi.',
            'batas_waktu_upload_soal.required' => 'Batas waktu upload soal wajib diisi.',
            'pengupload_id.required' => 'Dosen pengupload wajib dipilih.',
            'pengupload_id.exists' => 'Dosen pengupload tidak ditemukan.',
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
                'pengupload_id' => $request->pengupload_id,
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

    public function uploadKopSoal(Request $request, Ujian $ujian) {
        $request->validate([
            'nama_file' => 'required|string|max:255',  // Nama file harus berupa string dan tidak lebih dari 255 karakter
            'file_kop_soal' => 'required|file|mimes:pdf|max:10000',  // Hanya file PDF dengan ukuran maksimal 2MB
        ]);

        // Mendapatkan informasi file yang diupload
        $file = $request->file('file_kop_soal');
        $pathFile = $file->storeAs('kop_soal_ujians', $file->hashName(), 'public');  // Simpan dengan hash name untuk keamanan

        // Simpan data ke dalam database dengan nama file dari input user
        KopSoalUjian::create([
            'ujian_id' => $ujian->id,
            'nama_file' => $request->nama_file,  // Nama file dari input user
            'path_file' => $pathFile,  // Path file yang disimpan
        ]);

        return response()->json([
            'message' => 'template soal berhasil diupload.',
        ], 200);
    }

    public function getKopSoal(Ujian $ujian)
    {
        // Mengambil data template soal ujian yang terkait dengan ujian ini
        $kopSoal = $ujian->kopSoalUjian;

        // Cek apakah template soal ada
        if (!$kopSoal) {
            return response()->json([
                'message' => 'template soal tidak ditemukan!',
            ], 404);
        }

        // Mengirimkan data template soal dalam format JSON
        return response()->json([
            'ujian_id' => $ujian->id,
            'nama_file' => $kopSoal->nama_file,
            'path_file' => $kopSoal->path_file,
        ], 200);
    }


    public function updateKopSoal(Request $request, Ujian $ujian) {
        $request->validate([
            'nama_file' => 'required|string|max:255',  // Nama file harus berupa string
            'file_kop_soal' => 'required|file|mimes:pdf|max:2048',  // Optional file PDF dengan ukuran maksimal 2MB
        ]);

        $kopSoal = $ujian->kopSoalUjian;

        if (!$kopSoal) {
            return response()->json([
                'message' => 'template soal tidak ditemukan!',
            ], 404);
        }

        // Update nama file
        $kopSoal->nama_file = $request->nama_file;

        // Jika ada file baru, update path filenya
        if ($request->hasFile('file_kop_soal')) {
            // Hapus file lama
            Storage::delete('public/' . $kopSoal->path_file);

            // Upload file baru
            $file = $request->file('file_kop_soal');
            $pathFile = $file->storeAs('kop_soal_ujians', $file->hashName(), 'public');
            $kopSoal->path_file = $pathFile;
        }

        // Simpan perubahan
        $kopSoal->save();

        return response()->json([
            'message' => 'template soal berhasil diupdate.',
        ], 200);
    }

    public function getDosenByProdi($prodi_id)
    {
        // Ambil dosen yang memiliki prodi_id sesuai dengan mata kuliah yang dipilih
        $dosens = User::where('prodi_id', $prodi_id)
                    ->where('role', 'dosen')
                    ->get();

        return response()->json($dosens);
    }

    public function uploadSoal(Request $request, Ujian $ujian) {
        $request->validate([
            'judul_soal' => 'required|string|max:255',  // Nama file harus berupa string dan tidak lebih dari 255 karakter
            'file_soal' => 'required|file|mimes:pdf|max:2048',  // Hanya file PDF dengan ukuran maksimal 2MB
        ]);

        // Mendapatkan informasi file yang diupload
        $file = $request->file('file_soal');
        $pathFile = $file->storeAs('soal_ujians', $file->hashName(), 'public');  // Simpan dengan hash name untuk keamanan

        // Simpan data ke dalam database dengan nama file dari input user
        SoalUjian::create([
            'ujian_id' => $ujian->id,
            'dosen_id' => Auth::user()->id,
            'judul_soal' => $request->judul_soal,  // Nama file dari input user
            'path_file' => $pathFile,  // Path file yang disimpan
        ]);

        return response()->json([
            'message' => 'template soal berhasil diupload.',
        ], 200);
    }

    public function getSoal(Ujian $ujian)
    {
        // Mengambil data template soal ujian yang terkait dengan ujian ini
        $soal = $ujian->soalUjian;

        // Cek apakah template soal ada
        if (!$soal) {
            return response()->json([
                'message' => 'Soal Ujian tidak ditemukan!',
            ], 404);
        }

        // Mengirimkan data template soal dalam format JSON
        return response()->json([
            'ujian_id' => $ujian->id,
            'judul_soal' => $soal->judul_soal,
            'path_file' => $soal->path_file,
        ], 200);
    }


    public function updateSoal(Request $request, Ujian $ujian) {
        $request->validate([
            'judul_soal' => 'required|string|max:255',  // Nama file harus berupa string
            'file_soal' => 'required|file|mimes:pdf|max:2048',  // Optional file PDF dengan ukuran maksimal 2MB
        ]);

        $soal = $ujian->soalUjian;

        if (!$soal) {
            return response()->json([
                'message' => 'Soal Ujian tidak ditemukan!',
            ], 404);
        }

        // Update nama file
        $soal->judul_soal = $request->judul_soal;

        // Jika ada file baru, update path filenya
        if ($request->hasFile('file_soal')) {
            // Hapus file lama
            Storage::delete('public/' . $soal->path_file);

            // Upload file baru
            $file = $request->file('file_soal');
            $pathFile = $file->storeAs('soal_ujians', $file->hashName(), 'public');
            $soal->path_file = $pathFile;
        }

        // Simpan perubahan
        $soal->save();

        return response()->json([
            'message' => 'Soal Ujian berhasil diupdate.',
        ], 200);
    }

}
