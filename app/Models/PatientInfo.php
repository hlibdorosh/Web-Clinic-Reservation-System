<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInfo extends Model
{
    protected $table = 'patient_info';

    protected $fillable = [
        'user_id',
        'birth_date',
        'height',
        'weight',
        'sex',
        'health_data_consent_at',
    ];

    protected $casts = [
        'health_data_consent_at' => 'datetime',
        'birth_date' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
