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
        $user = Auth::user();
        $patientInfo = $user->patientInfo ?? new PatientInfo();

        // Health-related data needs explicit consent. Ask once; keep the timestamp as proof.
        $consentRequired = $patientInfo->health_data_consent_at === null;

        $validated = $request->validate([
            'birth_date' => 'nullable|date',
            'height' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',
            'sex' => 'nullable|in:М,Ж',
            'health_data_consent' => $consentRequired ? 'accepted' : 'nullable',
        ], [
            'health_data_consent.accepted' => 'Please confirm that you agree to the processing of this health information.',
        ]);

        $patientInfo->fill(collect($validated)->except('health_data_consent')->all());
        if ($consentRequired) {
            $patientInfo->health_data_consent_at = now();
        }
        $patientInfo->user_id = $user->id;
        $patientInfo->save();

        return redirect()->route('user.patient-info.edit')
            ->with('status', 'patient-info-updated');
    }
}
