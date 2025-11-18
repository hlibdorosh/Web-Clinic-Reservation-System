<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'desc'];

    // One department has many cabinets
    public function cabinets()
    {
        return $this->hasMany(Cabinet::class, 'dep_id');
    }

    // One department has many services
    public function services()
    {
        return $this->hasMany(Service::class, 'dep_id');
    }

    // One department has many terms
    public function terms()
    {
        return $this->hasMany(Term::class, 'dep_id');
    }
}
