<?php

use App\Http\Controllers\ProfileController;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $jumlahProdi = ProgramStudi::count();
        $jumlahDosen = ProgramStudi::count();
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');


});

require __DIR__.'/auth.php';
