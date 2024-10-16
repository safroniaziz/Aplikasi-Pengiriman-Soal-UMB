<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\KopSoalUjianController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\UjianController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $jumlahProdi = ProgramStudi::count();
        $jumlahDosen = User::where('role','dosen')->count();
        return view('dashboard', compact('jumlahProdi','jumlahDosen'));
    })->middleware(['auth'])->name('dashboard');

    Route::middleware([AdminMiddleware::class])->group(function () {

        Route::prefix('program_studi')->group(function () {
            Route::get('/', [ProgramStudiController::class, 'index'])->name('prodi');
            Route::post('/', [ProgramStudiController::class, 'post'])->name('prodi.post');
            Route::get('/{programStudi}/edit', [ProgramStudiController::class, 'edit'])->name('prodi.edit');
            Route::patch('/{programStudi}', [ProgramStudiController::class, 'update'])->name('prodi.update');
            Route::delete('/{programStudi}', [ProgramStudiController::class, 'delete'])->name('prodi.delete');
        });

        Route::prefix('data_dosen')->group(function () {
            Route::get('/', [DosenController::class, 'index'])->name('dosen');
            Route::post('/', [DosenController::class, 'post'])->name('dosen.post');
            Route::get('/{dosen}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
            Route::patch('/{dosen}', [DosenController::class, 'update'])->name('dosen.update');
            Route::delete('/{dosen}', [DosenController::class, 'delete'])->name('dosen.delete');
        });

        Route::prefix('mata_kuliah')->group(function () {
            Route::get('/', [MataKuliahController::class, 'index'])->name('mataKuliah');
            Route::post('/', [MataKuliahController::class, 'post'])->name('mataKuliah.post');
            Route::get('/{mataKuliah}/edit', [MataKuliahController::class, 'edit'])->name('mataKuliah.edit');
            Route::patch('/{mataKuliah}', [MataKuliahController::class, 'update'])->name('mataKuliah.update');
            Route::delete('/{mataKuliah}', [MataKuliahController::class, 'delete'])->name('mataKuliah.delete');
        });
    });

    Route::prefix('ujian')->group(function () {
        Route::get('/', [UjianController::class, 'index'])->name('ujian');
        Route::post('/', [UjianController::class, 'post'])->name('ujian.post');
        Route::get('/{ujian}/edit', [UjianController::class, 'edit'])->name('ujian.edit');
        Route::patch('/{ujian}', [UjianController::class, 'update'])->name('ujian.update');
        Route::delete('/{ujian}', [UjianController::class, 'delete'])->name('ujian.delete');
        Route::post('ujian/{ujian}/kop-soal/upload', [UjianController::class, 'uploadKopSoal'])->name('ujian.upload');
        Route::get('ujian/{ujian}/kop-soal', [UjianController::class, 'getKopSoal'])->name('ujian.getKopSoal');
        Route::patch('ujian/{ujian}/kop-soal/update', [UjianController::class, 'updateKopSoal'])->name('ujian.updateKopSoal');
        Route::get('get-dosen/{prodi_id}', [UjianController::class, 'getDosenByProdi'])->name('ujian.getDosenByProdi');

        Route::post('ujian/{ujian}/soal/upload', [UjianController::class, 'uploadSoal'])->name('ujian.uploadSoal');
        Route::get('ujian/{ujian}/soal', [UjianController::class, 'getSoal'])->name('ujian.getSoal');
        Route::patch('ujian/{ujian}/soal/update', [UjianController::class, 'updateSoal'])->name('ujian.updateSoal');
    });
});

require __DIR__.'/auth.php';
