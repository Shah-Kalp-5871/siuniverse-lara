<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    protected $fillable = [
        'name',
        'type',
        'deposit',
        'image_path',
        'distance',
        'rules',
        'amenities',
        'visiting_schedule',
        'is_luxury',
        'luxury_order',
        'area',
        'gender',
        'single_sharing_rent',
        'double_sharing_rent',
        'triple_sharing_rent',
        'food_type',
        'weekday_meals_price',
        'weekend_meals_price'
    ];

    protected $casts = [
        'rules' => 'array',
        'amenities' => 'array',
        'distance' => 'float',
        'deposit' => 'integer',
        'is_luxury' => 'boolean',
        'luxury_order' => 'integer',
        'single_sharing_rent' => 'integer',
        'double_sharing_rent' => 'integer',
        'triple_sharing_rent' => 'integer',
        'weekday_meals_price' => 'integer',
        'weekend_meals_price' => 'integer'
    ];
}
