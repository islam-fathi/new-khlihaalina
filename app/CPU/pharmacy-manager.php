<?php

namespace App\CPU;

use App\Model\Pharmacies;
use App\Model\Translation;
use Illuminate\Support\Facades\DB;

class PharmacyManager
{
    public static function pharmacy_image_path($image_type)
    {
        $path = '';
        if ($image_type == 'thumbnail') {
            $path = asset('storage/app/public/pharmacies/thumbnail');
        } elseif ($image_type == 'pharmacies') {
            $path = asset('storage/app/public/pharmacies'); 
        }
        return $path;
    }
}
