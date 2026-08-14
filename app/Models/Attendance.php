<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = [
        'student_id', 'module_id', 'date', 'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function type ()
    {
        return $this->belongsTo(SubscriptionType::class);
    }
}
