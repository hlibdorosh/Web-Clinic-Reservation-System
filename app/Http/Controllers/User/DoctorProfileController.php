<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class DoctorProfileController extends Controller
{
    public function show(User $user)
    {
        abort_if($user->role !== 'doctor', 404);

        $terms = $user->terms()
            ->with(['cabinet', 'department'])
            ->where('is_taken', false)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('user.doctors.show', compact('user', 'terms'));
    }
}

