<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    protected $fillable = [
        'name',
        'type',
        'single_sharing_rent',
        'double_sharing_rent',
        'triple_sharing_rent',
        'food_charges',
        'flat_rent',
        'deposit',
        'image_path',
        'link',
        'rules',
        'amenities',
        'distance',
        'sort_order',
        'visit_form_custom_fields'
    ];

    protected $casts = [
        'rules' => 'array',
        'amenities' => 'array',
        'distance' => 'float',
        'visit_form_custom_fields' => 'array',
        'sort_order' => 'integer',
    ];
}
