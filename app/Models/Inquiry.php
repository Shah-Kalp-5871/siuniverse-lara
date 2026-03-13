<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'stay_id',
        'user_name',
        'user_contact_number',
        'visit_date',
        'visit_time',
        'visiting_schedule'
    ];

    public function stay()
    {
        return $this->belongsTo(Stay::class);
    }
}
