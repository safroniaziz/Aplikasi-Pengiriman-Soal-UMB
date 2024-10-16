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

    Route::prefix('program_studi')->name('program_studi.')->group(function () {
        Route::get('/', [ProgramStudiController::class, 'index'])->name('index');
        Route::post('/', [ProgramStudiController::class, 'store'])->name('store');
        Route::put('/{programStudi}', [ProgramStudiController::class, 'update'])->name('update');
        Route::delete('/{programStudi}', [ProgramStudiController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';