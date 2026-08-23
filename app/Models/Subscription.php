<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'type_id', 'provider', 'price', 'currency',
        'billing_cycle', 'start_date', 'end_date', 'status', 'reminder_days',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(SubscriptionType::class, 'type_id');
    }
}