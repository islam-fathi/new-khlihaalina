<?php

namespace App\Model;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Doctor extends Model
{
    protected $casts = [
        'speciality' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function translations() 
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->translations[0]->value ?? $name;
    }

    public function specialities()
    {
        return $this->belongsTo(DoctorsSpecialties::class,'speciality');
    }

    public function cities() 
    {
        return $this->belongsTo(City::class ,'city'); 
    }

    public function reviews()
    {
        return $this->hasMany(ReviewsOtherType::class,'type_id')->where('type','doctor'); 
    }

    public function rating()
    {
        return $this->hasMany(ReviewsOtherType::class)
            ->select(DB::raw('avg(rating) average, type_id'))
            ->where('type','doctor')
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
