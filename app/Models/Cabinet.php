<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'desc', 'dep_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }

    public function terms()
    {
        return $this->hasMany(Term::class, 'cab_id');
    }
}
