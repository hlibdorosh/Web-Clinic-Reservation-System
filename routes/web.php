<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\User\TermBrowseController;
use Illuminate\Support\Facades\Auth;

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

            // UPDATE USER ROLE
            Route::patch('users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])
                ->name('users.updateRole');

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
            Route::get('terms', [\App\Http\Controllers\Doctor\TermController::class, 'index'])
                ->name('terms.index');

            Route::get('terms/calendar', [\App\Http\Controllers\Doctor\TermController::class, 'calendar'])
                ->name('terms.calendar');

            Route::get('terms/create', [\App\Http\Controllers\Doctor\TermController::class, 'create'])
                ->name('terms.create');

            Route::post('terms', [\App\Http\Controllers\Doctor\TermController::class, 'store'])
                ->name('terms.store');

            Route::get('terms/{term}/edit', [\App\Http\Controllers\Doctor\TermController::class, 'edit'])
                ->name('terms.edit');

            Route::put('terms/{term}', [\App\Http\Controllers\Doctor\TermController::class, 'update'])
                ->name('terms.update');

            Route::delete('terms/{term}', [\App\Http\Controllers\Doctor\TermController::class, 'destroy'])
                ->name('terms.destroy');

            Route::patch('reservations/{reservation}/confirm', [\App\Http\Controllers\Doctor\ReservationController::class, 'confirm'])
                ->name('reservations.confirm');
            Route::patch('reservations/{reservation}/cancel', [\App\Http\Controllers\Doctor\ReservationController::class, 'cancel'])
                ->name('reservations.cancel');

            Route::get('reservations/{reservation}/info', [\App\Http\Controllers\Doctor\ReservationController::class, 'showInfo'])
                ->name('reservations.showInfo');
            Route::patch('reservations/{reservation}/info', [\App\Http\Controllers\Doctor\ReservationController::class, 'updateInfo'])
                ->name('reservations.updateInfo');

            // Patient Info
            Route::get('patients/{user}/info', [\App\Http\Controllers\Doctor\PatientInfoController::class, 'show'])
                ->name('patients.info');
        });

    Route::middleware(['auth', 'verified', 'role:patient'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('terms', [TermBrowseController::class, 'index'])->name('terms.index');

            // Patient Info
            Route::get('patient-info', [\App\Http\Controllers\User\PatientInfoController::class, 'edit'])->name('patient-info.edit');
            Route::put('patient-info', [\App\Http\Controllers\User\PatientInfoController::class, 'update'])->name('patient-info.update');

            // Reservations
            Route::get('reservations', [\App\Http\Controllers\User\ReservationController::class, 'index'])
                ->name('reservations.index');
            Route::get('reservations/create/{term}', [\App\Http\Controllers\User\ReservationController::class, 'create'])
                ->name('reservations.create');
            Route::post('reservations', [\App\Http\Controllers\User\ReservationController::class, 'store'])
                ->name('reservations.store');
            Route::delete('reservations/{reservation}', [\App\Http\Controllers\User\ReservationController::class, 'cancel'])
                ->name('reservations.cancel');
            Route::get('reservations/{reservation}/info', [\App\Http\Controllers\Doctor\ReservationController::class, 'showInfo'])
                ->name('reservations.showInfo');
        });
    Route::middleware(['auth', 'verified'])
        ->prefix('doctors')
        ->name('doctors.')
        ->group(function () {
            Route::get('{user}', [\App\Http\Controllers\User\DoctorProfileController::class, 'show'])
                ->name('show');
        });

});

// Clinic Info Page - accessible to all authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('about', [\App\Http\Controllers\User\ClinicInfoController::class, 'index'])->name('clinic.about');
});

require __DIR__.'/auth.php';


