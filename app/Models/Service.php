<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'dep_id', 'price', 'desc'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'serv_id');
    }
}
