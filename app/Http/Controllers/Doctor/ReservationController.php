<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Notifications\ReservationConfirmed;
use App\Notifications\ReservationCancelledByDoctor;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function confirm(Reservation $reservation)
    {
        abort_if($reservation->term->doc_id !== auth()->id(), 403);

        $reservation->load(['patient', 'service', 'term.doctor', 'term.department', 'term.cabinet']);

        $reservation->update(['state' => 'confirmed']);

        // Send email notification
        $reservation->patient->notify(new ReservationConfirmed($reservation));

        // Add to patient's Google Calendar if connected
        try {
            \Log::info('Starting Google Calendar event creation for reservation ' . $reservation->id);
            \Log::info('Patient: ' . $reservation->patient->email);

            $googleCalendar = new GoogleCalendarService($reservation->patient);
            \Log::info('GoogleCalendarService initialized');

            if ($googleCalendar->isConnected()) {
                \Log::info('Patient has Google Calendar connected');

                $term = $reservation->term;

                // Format date explicitly to ensure Y-m-d format
                $dateStr = $term->date instanceof \Carbon\Carbon
                    ? $term->date->format('Y-m-d')
                    : (is_string($term->date) ? $term->date : Carbon::now()->format('Y-m-d'));

                // Get properly formatted times, removing seconds if present
                $startTimeStr = $term->start_time instanceof \Carbon\Carbon
                    ? $term->start_time->format('H:i')
                    : (is_string($term->start_time) ? $term->start_time : '00:00');

                $endTimeStr = $term->end_time instanceof \Carbon\Carbon
                    ? $term->end_time->format('H:i')
                    : (is_string($term->end_time) ? $term->end_time : '00:00');

                // Remove seconds if present (e.g., "15:00:00" -> "15:00")
                $startTimeStr = substr($startTimeStr, 0, 5);
                $endTimeStr = substr($endTimeStr, 0, 5);

                // Pad time if necessary (handle cases like "9:30" -> "09:30")
                if (strlen($startTimeStr) < 5) {
                    $parts = explode(':', $startTimeStr);
                    $startTimeStr = str_pad($parts[0], 2, '0', STR_PAD_LEFT) . ':' . str_pad($parts[1] ?? '0', 2, '0', STR_PAD_LEFT);
                }
                if (strlen($endTimeStr) < 5) {
                    $parts = explode(':', $endTimeStr);
                    $endTimeStr = str_pad($parts[0], 2, '0', STR_PAD_LEFT) . ':' . str_pad($parts[1] ?? '0', 2, '0', STR_PAD_LEFT);
                }

                try {
                    \Log::info('Date string: ' . $dateStr . ', Start time: ' . $startTimeStr . ', End time: ' . $endTimeStr);
                    $startTime = Carbon::createFromFormat('Y-m-d H:i', $dateStr . ' ' . $startTimeStr, 'UTC');
                    $endTime = Carbon::createFromFormat('Y-m-d H:i', $dateStr . ' ' . $endTimeStr, 'UTC');
                } catch (\Exception $e) {
                    \Log::error('Failed to parse times. Date: ' . $dateStr . ', Start: ' . $startTimeStr . ', End: ' . $endTimeStr . ', Error: ' . $e->getMessage());
                    throw $e;
                }

                $eventTitle = $reservation->service?->name ?? 'Medical Appointment';
                $eventDescription = "Doctor: " . $term->doctor->name . "\n" .
                                  "Department: " . ($term->department?->name ?? 'N/A') . "\n" .
                                  "Cabinet: " . ($term->cabinet?->number ?? 'N/A');

                \Log::info('Creating calendar event: ' . $eventTitle . ' from ' . $startTime . ' to ' . $endTime);

                $result = $googleCalendar->createEvent($eventTitle, $eventDescription, $startTime, $endTime, $reservation->patient->email);

                if ($result) {
                    \Log::info('Calendar event created successfully: ' . $result->id);
                } else {
                    \Log::warning('Calendar event creation returned false');
                }
            } else {
                \Log::info('Patient does not have Google Calendar connected');
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to add event to patient Google Calendar: ' . $e->getMessage());
            \Log::warning('Stack trace: ' . $e->getTraceAsString());
            // Don't fail the confirmation if calendar update fails
        }

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
