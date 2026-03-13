<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'stay_id',
        'user_name',
        'contact_number',
        'visit_date',
        'visit_time',
        'custom_data'
    ];

    protected $casts = [
        'visit_date' => 'date',
        'custom_data' => 'array',
    ];

    public function stay(): BelongsTo
    {
        return $this->belongsTo(Stay::class);
    }
}
