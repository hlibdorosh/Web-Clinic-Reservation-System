<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;

class PatientInfoController extends Controller
{
    public function show(User $user)
    {
        if ($user->role !== 'patient') {
            abort(403, 'Unauthorized');
        }

        return view('doctor.patient-info.show', [
            'user' => $user,
            'patientInfo' => $user->patientInfo,
        ]);
    }
}
