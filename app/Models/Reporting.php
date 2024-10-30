<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporting extends Model
{
    protected $fillable = [
        'period_start',
        'period_end',
        'currency',
        'amount',
        'notes',
    ];
}
