<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ReviewsOtherType extends Model
{
    protected $casts = [
        'type_id'     => 'integer',
        'customer_id' => 'integer',
        'rating'      => 'integer',
        'status'      => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    
}
