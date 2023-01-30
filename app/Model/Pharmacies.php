<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Pharmacies extends Authenticatable
{
    use Notifiable, HasApiTokens;  

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function cities()
    {
        return $this->belongsTo(City::class ,'city');
    }

    public function reviews()
    {
        return $this->hasMany(ReviewsOtherType::class,'type_id')->where('type','pharmacy'); 
    }

    public function rating()
    {
        return $this->hasMany(ReviewsOtherType::class)
            ->select(DB::raw('avg(rating) average, type_id'))
            ->where('type','pharmacy')
            ->groupBy('type_id');
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
