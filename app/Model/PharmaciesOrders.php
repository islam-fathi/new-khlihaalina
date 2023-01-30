<?php

namespace App\Model;

use App\CPU\Helpers;
use App\Model\Pharmacies;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PharmaciesOrders extends Model 
{
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function translations() 
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacies::class,'pharmacy_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'request_by_id'); 
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                if (strpos(url()->current(), '/api')){
                    return $query->where('locale', App::getLocale());
                }else{
                    return $query->where('locale', Helpers::default_lang());
                }
            }]);
        });
    }
}
