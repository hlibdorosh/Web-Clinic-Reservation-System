<?php

namespace App\Notifications;

use App\Models\Department;
use Illuminate\Notifications\Notification;

class DepartmentCreated extends Notification
{
    public function __construct(public Department $department) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'department_created',
            'message'    => 'New department created: ' . $this->department->name,
            'name'       => $this->department->name,
            'description' => $this->department->description,
        ];
    }
}

