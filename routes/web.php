<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return view('dashboard_admin');
    } elseif ($role === 'doctor') {
        return view('dashboard_doctor');
    } else {
        return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('departments', DepartmentController::class);
        });

});




require __DIR__.'/auth.php';
