<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'institute',
        'course',
        'section',
        'datestamp',
        'campus_location',
        'current_study_year',
        'gym_choice',
        'origin',
        'branch',
        'mess',
        'country',
        'accommodation',
    ];

    // hide sensitive fields when serializing
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'datestamp' => 'datetime',
    ];
}
