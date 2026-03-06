<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Term;
use App\Models\Service;
use App\Notifications\ReservationMade;
use App\Notifications\ReservationCancelledByPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('patient_id', auth()->id())
            ->with(['term.doctor', 'term.cabinet', 'term.department', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.reservations.index', compact('reservations'));
    }

    public function create(Term $term)
    {
        // Check if term is already taken
        if ($term->is_taken) {
            return back()->with('error', 'This term is already booked');
        }

        // Get services for the department
        $services = Service::where('dep_id', $term->dep_id)
            ->orderBy('name')
            ->get();

        return view('user.reservations.create', compact('term', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'term_id' => 'required|exists:terms,id',
            'serv_id' => 'required|exists:services,id',
        ]);

        $term = Term::findOrFail($request->term_id);

        // Check if term is already taken
        if ($term->is_taken) {
            return back()->with('error', 'This term is already booked');
        }

        // Check if user already has a reservation for this term
        $existingReservation = Reservation::where('term_id', $request->term_id)
            ->where('patient_id', auth()->id())
            ->first();

        if ($existingReservation) {
            return back()->with('error', 'You already have a reservation for this term');
        }

        DB::beginTransaction();
        try {
            $reservation = Reservation::create([
                'term_id' => $request->term_id,
                'patient_id' => auth()->id(),
                'serv_id' => $request->serv_id,
                'state' => 'pending',
            ]);

            // Mark term as taken
            $term->update(['is_taken' => true]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create reservation');
        }

        // Notify the doctor (outside transaction so a failure doesn't roll back the booking)
        try {
            $reservation->load(['patient', 'service', 'term.doctor', 'term.department', 'term.cabinet']);
            $term->doctor->notify(new ReservationMade($reservation));
        } catch (\Exception $e) {
            // Notification failure should not affect the booking
        }

        return redirect()->route('user.reservations.index')
            ->with('success', 'Reservation created successfully');
    }

    public function cancel(Reservation $reservation)
    {
        // Check if user owns this reservation
        if ($reservation->patient_id !== auth()->id()) {
            abort(403);
        }

        $reservation->load(['patient', 'service', 'term.doctor', 'term.department', 'term.cabinet']);
        $term = $reservation->term;

        // Notify the doctor before deleting
        try {
            $term->doctor->notify(new ReservationCancelledByPatient($reservation));
        } catch (\Exception $e) {
            // Notification failure should not affect the cancellation
        }

        DB::beginTransaction();
        try {
            $reservation->delete();
            $term->update(['is_taken' => false]);
            DB::commit();

            return back()->with('success', 'Reservation cancelled successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel reservation');
        }
    }
}
