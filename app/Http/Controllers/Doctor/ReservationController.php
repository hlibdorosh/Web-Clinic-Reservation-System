<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Notifications\ReservationConfirmed;
use App\Notifications\ReservationCancelledByDoctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function confirm(Reservation $reservation)
    {
        abort_if($reservation->term->doc_id !== auth()->id(), 403);

        $reservation->load(['patient', 'service', 'term.doctor', 'term.department', 'term.cabinet']);

        $reservation->update(['state' => 'confirmed']);

        $reservation->patient->notify(new ReservationConfirmed($reservation));

        return back()->with('success', 'Reservation confirmed.');
    }

    public function cancel(Reservation $reservation)
    {
        abort_if($reservation->term->doc_id !== auth()->id(), 403);

        $reservation->load(['patient', 'service', 'term.doctor', 'term.department', 'term.cabinet']);

        try {
            $reservation->patient->notify(new ReservationCancelledByDoctor($reservation));
        } catch (\Exception $e) {
            // Notification failure should not affect the cancellation
        }

        DB::transaction(function () use ($reservation) {
            $reservation->term->update(['is_taken' => false]);
            $reservation->update(['state' => 'cancelled']);
        });

        return back()->with('success', 'Reservation cancelled.');
    }

    public function showInfo(Reservation $reservation)
    {
        // Allow doctor who made this reservation or the patient to view
        $isDoctor = $reservation->term->doc_id === auth()->id();
        $isPatient = $reservation->patient_id === auth()->id();

        abort_if(!$isDoctor && !$isPatient, 403);

        $reservation->load(['patient', 'service', 'term']);
        $isReadOnly = $isPatient; // Patients can only view, not edit

        return view('doctor.reservations.info', compact('reservation', 'isReadOnly'));
    }

    public function updateInfo(Request $request, Reservation $reservation)
    {
        abort_if($reservation->term->doc_id !== auth()->id(), 403);

        $request->validate([
            'info' => ['nullable', 'string', 'max:5000'],
        ]);

        $reservation->update([
            'info' => $request->info,
        ]);

        return back()->with('success', 'Visit info updated successfully.');
    }
}
