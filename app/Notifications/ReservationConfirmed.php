<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationConfirmed extends Notification
{
    public function __construct(public Reservation $reservation) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $term = $this->reservation->term;

        return (new MailMessage)
            ->subject('Reservation Confirmed - ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your reservation has been confirmed by Dr. ' . $term->doctor->name . '.')
            ->line('')
            ->line('**Reservation Details:**')
            ->line('Date: ' . $term->date)
            ->line('Time: ' . $term->start_time . ' - ' . $term->end_time)
            ->line('Service: ' . ($this->reservation->service?->name ?? 'N/A'))
            ->line('Department: ' . ($term->department?->name ?? 'N/A'))
            ->line('Room: ' . ($term->cabinet?->number ?? 'N/A'))
            ->action('View Reservation', url('/user/reservations'))
            ->line('Thank you for using our service!');
    }

    public function toArray(object $notifiable): array
    {
        $term = $this->reservation->term;
        return [
            'type'        => 'reservation_confirmed',
            'message'     => 'Your reservation has been confirmed by Dr. ' . $term->doctor->name,
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
