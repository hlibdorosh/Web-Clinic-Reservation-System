<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_id',
        'patient_id',
        'serv_id',
        'state',
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'serv_id');
    }
}
