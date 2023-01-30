<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Model\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SharedController extends Controller
{
    public function lang($local)
    {
        $direction = 'ltr';
        $language = BusinessSetting::where('type', 'language')->first();
        foreach (json_decode($language['value'], true) as $key => $data) {
            if ($data['code'] == $local) {
                $direction = isset($data['direction']) ? $data['direction'] : 'ltr';
            }
        }
        session()->forget('language_settings'); 
        Helpers::language_load();
        session()->put('local', $local);
        Session::put('direction', $direction);
        return redirect()->back();
    }

    public function city($id)
    {
        $default_city = BusinessSetting::where('type', 'default_city')->first();
        session()->forget('default_city_settings');
        Helpers::default_city_load();
        session()->put('default_city_settings', $id);
        Session::put('default_city_settings', $id);
        return redirect()->back();
    }
}
