<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CPU\Helpers;
use Brian2694\Toastr\Facades\Toastr;

class EnvironmentSettingsController extends Controller
{
    public function environment_index()
    {
        return view('admin-views.business-settings.environment-index');
    }
    public function environment_setup(Request $request)
    {

        //Helpers::setEnvironmentValue('DB_DATABASE', "'".$request['db_database']."'" ?? env('DB_DATABASE'));

        try {
            Helpers::setEnvironmentValue('APP_DEBUG', $request['app_debug'] ?? env('APP_DEBUG'));
            //Helpers::setEnvironmentValue('APP_NAME', $request['app_name'] ?? env('APP_NAME'));
            //Helpers::setEnvironmentValue('APP_URL', $request['app_url'] ?? env('APP_URL'));
            Helpers::setEnvironmentValue('APP_MODE', $request['app_mode'] ?? env('APP_MODE'));
            //Helpers::setEnvironmentValue('DB_CONNECTION', $request['db_connection'] ?? env('DB_CONNECTION'));
            //Helpers::setEnvironmentValue('DB_HOST', $request['db_host'] ?? env('DB_HOST'));
            //Helpers::setEnvironmentValue('DB_PORT', $request['db_port'] ?? env('DB_PORT'));
            //Helpers::setEnvironmentValue('DB_DATABASE', $request['db_database'] ?? env('DB_DATABASE'));
            //Helpers::setEnvironmentValue('DB_USERNAME', $request['db_username'] ?? env('DB_USERNAME'));
            //Helpers::setEnvironmentValue('DB_PASSWORD', $request['db_password'] ?? env('DB_PASSWORD'));

        } catch (\Exception $exception) {
            Toastr::error('Environment variables updated failed!');
            return back();
        }

        Toastr::success('Environment variables updated successfully!');
        return back();
    }
}
