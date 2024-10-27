<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'client_id',
        'number',
        'date',
        'due_date',
        'status',
        'currency',
        'amount',
        'notes',
        'items',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
