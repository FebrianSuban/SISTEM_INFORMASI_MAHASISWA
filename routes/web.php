<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\MahasiswaPublicController;
use Illuminate\Support\Facades\Route;

// Halaman public untuk melihat data mahasiswa (tanpa login)
Route::get('/', [MahasiswaPublicController::class, 'index'])->name('home');
Route::get('/mahasiswa/{mahasiswa}', [MahasiswaPublicController::class, 'show'])->name('mahasiswa.show');
Route::get('/mahasiswa/{mahasiswa}/print', [MahasiswaPublicController::class, 'print'])->name('mahasiswa.print');

Route::middleware('auth')->group(function () {
    // Halaman dashboard umum setelah login
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Admin (harus login dan role admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalMahasiswa = \App\Models\Mahasiswa::count();
        return view('admin.dashboard', compact('totalMahasiswa'));
    })->name('dashboard');

    Route::resource('mahasiswa', MahasiswaController::class);
    // Print biodata (print-friendly view)
    Route::get('mahasiswa/{mahasiswa}/print', [MahasiswaController::class, 'print'])->name('mahasiswa.print');
});

require __DIR__.'/auth.php';
