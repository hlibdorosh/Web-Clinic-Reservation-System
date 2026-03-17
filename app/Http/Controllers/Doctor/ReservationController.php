<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Notifications\ReservationConfirmed;
use App\Notifications\ReservationCancelledByDoctor;
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
}
