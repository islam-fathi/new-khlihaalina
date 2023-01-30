<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{

    protected $casts = [
        'amount' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function seller(){
        return $this->belongsTo(Seller::class,'seller_id');
    }
}
