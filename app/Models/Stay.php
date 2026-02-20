<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    protected $fillable = [
        'name',
        'type',
        'rent',
        'image_path',
        'link',
        'broker_number',
        'broker_name',
        'rules',
        'amenities',
        'distance'
    ];

    protected $casts = [
        'rules' => 'array',
        'amenities' => 'array',
        'distance' => 'float',
    ];
}
