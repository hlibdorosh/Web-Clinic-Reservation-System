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
            Route::resource('cabinets', \App\Http\Controllers\Admin\CabinetController::class);
            Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
            Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
                ->name('users.index');

            Route::get('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])
                ->name('users.show');

            // DELETE TERM
            Route::delete('terms/{term}', [\App\Http\Controllers\Admin\UserController::class, 'deleteTerm'])
                ->name('users.term.delete');
        });

});




require __DIR__.'/auth.php';
