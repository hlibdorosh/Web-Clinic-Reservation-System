<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class UserCreated extends Notification
{
    public function __construct(public User $user) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'user_created',
            'message' => 'New user registered: ' . $this->user->name,
            'name'    => $this->user->name,
            'email'   => $this->user->email,
            'role'    => $this->user->role,
        ];
    }
}

