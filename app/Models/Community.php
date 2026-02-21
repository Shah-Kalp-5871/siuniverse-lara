<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
        'name',
        'category',
        'invite_link',
        'status',
        'mess',
        'gym',
        'origin',
    ];
}
