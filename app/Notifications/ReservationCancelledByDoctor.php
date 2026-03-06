<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Notifications\Notification;

class ReservationCancelledByDoctor extends Notification
{
    public function __construct(public Reservation $reservation) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $term = $this->reservation->term;
        return [
            'type'        => 'reservation_cancelled_doctor',
            'message'     => 'Your reservation was cancelled by Dr. ' . $term->doctor->name,
            'doctor_name' => $term->doctor->name,
            'service'     => $this->reservation->service?->name,
            'date'        => $term->date,
            'start_time'  => $term->start_time,
            'end_time'    => $term->end_time,
            'department'  => $term->department?->name,
            'cabinet'     => $term->cabinet?->number,
        ];
    }
}
