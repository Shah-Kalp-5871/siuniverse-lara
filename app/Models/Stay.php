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
        'weekend_meals_price',
        'food_inclusion',
        'website_url'
    ];

    protected $casts = [
        'rules' => 'array',
        'amenities' => 'array',
        'distance' => 'float',
        'is_luxury' => 'boolean',
        'luxury_order' => 'integer',
        'single_sharing_rent' => 'string',
        'double_sharing_rent' => 'string',
        'triple_sharing_rent' => 'string',
        'weekday_meals_price' => 'string',
        'weekend_meals_price' => 'string'
    ];
}
