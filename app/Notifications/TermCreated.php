<?php

namespace App\Notifications;

use App\Models\Term;
use Illuminate\Notifications\Notification;

class TermCreated extends Notification
{
    public function __construct(public Term $term) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'term_created',
            'message'    => 'You created a new term',
            'date'       => $this->term->date,
            'start_time' => $this->term->start_time,
            'end_time'   => $this->term->end_time,
            'department' => $this->term->department?->name,
            'cabinet'    => $this->term->cabinet?->number,
        ];
    }
}
