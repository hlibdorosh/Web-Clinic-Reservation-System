<?php

namespace App\Notifications;

use App\Models\Cabinet;
use Illuminate\Notifications\Notification;

class CabinetCreated extends Notification
{
    public function __construct(public Cabinet $cabinet) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'cabinet_created',
            'message'    => 'New cabinet created: ' . $this->cabinet->number,
            'number'     => $this->cabinet->number,
            'department' => $this->cabinet->department?->name,
            'description' => $this->cabinet->description,
        ];
    }
}

