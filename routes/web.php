<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\User\TermBrowseController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $notifications = $user->notifications()->latest()->take(30)->get();

    if ($user->role === 'admin') {
        return view('dashboard_admin', compact('notifications'));
    } elseif ($user->role === 'doctor') {
        return view('dashboard_doctor', compact('notifications'));
    } else {
        return view('dashboard', compact('notifications'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/notifications/mark-all-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return back();
})->middleware(['auth'])->name('notifications.markAllRead');

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


            Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])
                ->name('users.destroy');
        });


    Route::middleware(['auth', 'verified', 'role:doctor'])
        ->prefix('doctor')
        ->name('doctor.')
        ->group(function () {
            Route::get('terms/create', [\App\Http\Controllers\Doctor\TermController::class, 'create'])
                ->name('terms.create');

            Route::post('terms', [\App\Http\Controllers\Doctor\TermController::class, 'store'])
                ->name('terms.store');

            Route::get('terms', [\App\Http\Controllers\Doctor\TermController::class, 'index'])
                ->name('terms.index');
            Route::put('terms/{term}', [\App\Http\Controllers\Doctor\TermController::class, 'update']
            )
                ->name('doctor.terms.update');
            Route::get('terms/{term}/edit', [\App\Http\Controllers\Doctor\TermController::class, 'edit'])
                ->name('terms.edit');

            Route::put('terms/{term}', [\App\Http\Controllers\Doctor\TermController::class, 'update'])
                ->name('terms.update'); // ⚠️ без "doctor." внутри

            Route::delete('terms/{term}', [\App\Http\Controllers\Doctor\TermController::class, 'destroy'])
                ->name('terms.destroy');

            Route::patch('reservations/{reservation}/confirm', [\App\Http\Controllers\Doctor\ReservationController::class, 'confirm'])
                ->name('reservations.confirm');
            Route::patch('reservations/{reservation}/cancel', [\App\Http\Controllers\Doctor\ReservationController::class, 'cancel'])
                ->name('reservations.cancel');
        });

    Route::middleware(['auth', 'verified', 'role:patient'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('terms', [TermBrowseController::class, 'index'])->name('terms.index');

            // Reservations
            Route::get('reservations', [\App\Http\Controllers\User\ReservationController::class, 'index'])
                ->name('reservations.index');
            Route::get('reservations/create/{term}', [\App\Http\Controllers\User\ReservationController::class, 'create'])
                ->name('reservations.create');
            Route::post('reservations', [\App\Http\Controllers\User\ReservationController::class, 'store'])
                ->name('reservations.store');
            Route::delete('reservations/{reservation}', [\App\Http\Controllers\User\ReservationController::class, 'cancel'])
                ->name('reservations.cancel');
        });
    Route::middleware(['auth', 'verified'])
        ->prefix('doctors')
        ->name('doctors.')
        ->group(function () {
            Route::get('{user}', [\App\Http\Controllers\User\DoctorProfileController::class, 'show'])
                ->name('show');
        });



});






require __DIR__.'/auth.php';
