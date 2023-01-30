<?php

namespace App\Providers;

use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $data_smtp = BusinessSetting::where(['type' => 'mail_config'])->first();
            $emailServices_smtp = json_decode($data_smtp['value'], true);

            $data_sendgrid = BusinessSetting::where(['type' => 'mail_config_sendgrid'])->first();
            $emailServices_sendgrid = json_decode($data_sendgrid['value'], true);

            
            if ($emailServices_smtp && $emailServices_smtp['status']==1) {
                
                    $config = array(
                        'driver' => $emailServices_smtp['driver'],
                        'host' => $emailServices_smtp['host'],
                        'port' => $emailServices_smtp['port'],
                        'username' => $emailServices_smtp['username'],
                        'password' => $emailServices_smtp['password'],
                        'encryption' => $emailServices_smtp['encryption'],
                        'from' => array('address' => $emailServices_smtp['email_id'], 'name' => $emailServices_smtp['name']),
                        'sendmail' => '/usr/sbin/sendmail -bs',
                        'pretend' => false,
                    );
                
                
                Config::set('mail', $config);
            }

            

            if ($emailServices_sendgrid && $emailServices_sendgrid['status']==1) {
                
                    $config = array(
                        'driver' => $emailServices_sendgrid['driver'],
                        'host' => $emailServices_sendgrid['host'],
                        'port' => $emailServices_sendgrid['port'],
                        'username' => $emailServices_sendgrid['username'],
                        'password' => $emailServices_sendgrid['password'],
                        'encryption' => $emailServices_sendgrid['encryption'],
                        'from' => array('address' => $emailServices_sendgrid['email_id'], 'name' => $emailServices_sendgrid['name']),
                        'sendmail' => '/usr/sbin/sendmail -bs',
                        'pretend' => false,
                    );
                
                //dd($config);
                Config::set('mail', $config);
            }
        } catch (\Exception $ex) {

        }

    }
}
