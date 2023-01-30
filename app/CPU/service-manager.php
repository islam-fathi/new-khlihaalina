<?php

namespace App\CPU;

use App\Model\Services;
use App\Model\Translation;
use Illuminate\Support\Facades\DB;

class ServiceManager
{
    public static function service_image_path($image_type)
    {
        $path = '';
        if ($image_type == 'thumbnail') {
            $path = asset('storage/app/public/services/thumbnail');
        } elseif ($image_type == 'services') {
            $path = asset('storage/app/public/services'); 
        }
        return $path;
    }
}
