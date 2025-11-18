<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_id',
        'dep_id',
        'cab_id',
        'start_time',
        'end_time',
        'is_taken',
        'desc',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doc_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class, 'cab_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'term_id');
    }
}
