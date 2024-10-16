<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramStudiController;
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

    Route::prefix('data_dosen')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('dosen');
        Route::post('/', [DosenController::class, 'post'])->name('dosen.post');
        Route::get('/{dosen}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
        Route::patch('/{dosen}', [DosenController::class, 'update'])->name('dosen.update');
        Route::delete('/{dosen}', [DosenController::class, 'delete'])->name('dosen.delete');
    });
});

require __DIR__.'/auth.php';
