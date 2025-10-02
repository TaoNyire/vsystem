<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    protected $fillable = [
        'voter_registration_number',
        'last_name',
        'first_name',
        'gender',
        'status',
        'registration_date',
        'categories',
        'constituency_ward',
    ];

    // Relationship example if needed
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
