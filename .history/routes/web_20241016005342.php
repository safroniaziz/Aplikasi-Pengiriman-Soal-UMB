<?php

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

    Route::prefix('program_studi')->group(function () {
        Route::get('/', [Dosen::class, 'index'])->name('prodi');
        Route::post('/', [Dosen::class, 'post'])->name('prodi.post');
        Route::get('/{programStudi}/edit', [Dosen::class, 'edit'])->name('prodi.edit');
        Route::patch('/{programStudi}', [Dosen::class, 'update'])->name('prodi.update');
        Route::delete('/{programStudi}', [Dosen::class, 'delete'])->name('prodi.delete');
    });
});

require __DIR__.'/auth.php';
