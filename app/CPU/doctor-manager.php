<?php

namespace App\CPU;

use App\Model\Doctors;
use App\Model\Translation;
use Illuminate\Support\Facades\DB;

class DoctorManager
{
    public static function doctor_image_path($image_type)
    {
        $path = '';
        if ($image_type == 'thumbnail') {
            $path = asset('storage/app/public/doctors/thumbnail');
        } elseif ($image_type == 'doctors') {
            $path = asset('storage/app/public/doctors');
        }
        return $path;
    }
}
