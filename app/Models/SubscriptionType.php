<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    //
    public function subscriptions ()
    {
        return $this->hasMany(Subscription::class);
    }
}
