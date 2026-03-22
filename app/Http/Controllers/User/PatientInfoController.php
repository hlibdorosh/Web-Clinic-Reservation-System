<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PatientInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientInfoController extends Controller
{

    public function edit()
    {
        $user = Auth::user();
        $patientInfo = $user->patientInfo ?? new PatientInfo();

        return view('user.patient-info.edit', [
            'user' => $user,
            'patientInfo' => $patientInfo,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'birth_date' => 'nullable|date',
            'height' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',
            'sex' => 'nullable|in:М,Ж',
        ]);

        $user = Auth::user();
        $patientInfo = $user->patientInfo ?? new PatientInfo();

        $patientInfo->fill($validated);
        $patientInfo->user_id = $user->id;
        $patientInfo->save();

        return redirect()->route('user.patient-info.edit')
            ->with('status', 'patient-info-updated');
    }
}
