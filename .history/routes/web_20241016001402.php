<?php

use App\Http\Controllers\ProfileController;
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
});

require __DIR__.'/auth.php';
