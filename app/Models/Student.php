<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
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

    protected $casts = [
        'datestamp' => 'datetime',
    ];
}
