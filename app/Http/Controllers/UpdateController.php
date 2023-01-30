<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Model\AdminWallet;
use App\User;
use App\Model\BusinessSetting;
use App\Model\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function update_software_index()
    {
        return view('update.update-software');
    }

    public function update_software(Request $request)
    {
        Helpers::setEnvironmentValue('SOFTWARE_ID', 'MzE0NDg1OTc=');
        Helpers::setEnvironmentValue('BUYER_USERNAME', $request['username']);
        Helpers::setEnvironmentValue('PURCHASE_CODE', $request['purchase_key']);
        Helpers::setEnvironmentValue('SOFTWARE_VERSION', '9.0');
        Helpers::setEnvironmentValue('APP_MODE', 'live');
        Helpers::setEnvironmentValue('APP_NAME', '6valley' . time());
        Helpers::setEnvironmentValue('SESSION_LIFETIME', '60');

        $data = Helpers::requestSender();
        if (!$data['active']) {
            return redirect(base64_decode('aHR0cHM6Ly82YW10ZWNoLmNvbS9zb2Z0d2FyZS1hY3RpdmF0aW9u'));
        }

        Artisan::call('migrate', ['--force' => true]);
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        Artisan::call('config:cache');
        Artisan::call('config:clear');

        /*if (BusinessSetting::where(['type' => 'fcm_topic'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'fcm_topic',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'fcm_project_id'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'fcm_project_id',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'push_notification_key'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'push_notification_key',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_pending_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_pending_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_confirmation_msg'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_confirmation_msg',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_processing_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_processing_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'out_for_delivery_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'out_for_delivery_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_delivered_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_delivered_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_returned_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_returned_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_failed_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_failed_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'delivery_boy_assign_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'delivery_boy_assign_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'delivery_boy_start_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'delivery_boy_start_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'delivery_boy_delivered_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'delivery_boy_delivered_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'terms_and_conditions'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'terms_and_conditions',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'minimum_order_value'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'minimum_order_value'], [
                'value' => 1
            ]);
        }
        if (BusinessSetting::where(['type' => 'about_us'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'about_us'], [
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'privacy_policy'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'privacy_policy'], [
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'terms_and_conditions'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'terms_and_conditions'], [
                'value' => ''
            ]);
        }*/

        if (BusinessSetting::where(['type' => 'seller_registration'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'seller_registration'], [
                'value' => 1
            ]);
        }
        if (BusinessSetting::where(['type' => 'pnc_language'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'pnc_language'], [
                'value' => json_encode(['en']),
            ]);
        }

        if (BusinessSetting::where(['type' => 'language'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'language'], [
                'value' => '[{"id":"1","name":"english","direction":"ltr","code":"en","status":1,"default":true}]',
            ]);
        }

        if (BusinessSetting::where(['type' => 'razor_pay'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'razor_pay',
                'value' => '{"status":"1","razor_key":"","razor_secret":""}'
            ]);
        }

        if (BusinessSetting::where(['type' => 'paystack'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'paystack',
                'value' => '{"status":"0","publicKey":"","secretKey":"","paymentUrl":"","merchantEmail":""}'
            ]);
        }
        if (BusinessSetting::where(['type' => 'senang_pay'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'senang_pay',
                'value' => '{"status":"0","secret_key":"","merchant_id":""}'
            ]);
        }
        if (BusinessSetting::where(['type' => 'paymob_accept'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'paymob_accept',
                'value' => '{"status":"0","api_key":"","iframe_id":"","integration_id":"","hmac":""}'
            ]);
        }

        if (BusinessSetting::where(['type' => 'social_login'])->first() == false) {
            DB::table('business_settings')->insert([
                'type' => 'social_login',
                'value' => '[{"login_medium":"google","client_id":"","client_secret":"","status":""},{"login_medium":"facebook","client_id":"","client_secret":"","status":""}]',
            ]);
        }
        if (BusinessSetting::where(['type' => 'digital_payment'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'digital_payment'], [
                'value' => '{"status":"1"}',
            ]);
        }

        if (BusinessSetting::where(['type' => 'currency_model'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'currency_model'], [
                'value' => 'multi_currency',
            ]);
        }

        if (BusinessSetting::where(['type' => 'phone_verification'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'phone_verification'], [
                'value' => 0
            ]);
        }

        if (BusinessSetting::where(['type' => 'email_verification'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'email_verification'], [
                'value' => 0
            ]);
        }

        // stock limit
        if (BusinessSetting::where(['type' => 'stock_limit'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'stock_limit'], [
                'value' => 10
            ]);
        }

        if (BusinessSetting::where(['type' => 'order_verification'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'order_verification'], [
                'value' => 0
            ]);
        }

        if (BusinessSetting::where(['type' => 'country_code'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'country_code'], [
                'value' => 'BD'
            ]);
        }

        if (BusinessSetting::where(['type' => 'pagination_limit'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'pagination_limit'], [
                'value' => 10
            ]);
        }

        if (BusinessSetting::where(['type' => 'shipping_method'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'shipping_method'], [
                'value' => 'inhouse_shipping'
            ]);
        }

        if (BusinessSetting::where(['type' => 'seller_pos'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'seller_pos'], [
                'value' => 0
            ]);
        }
        if(BusinessSetting::where(['type' => 'refund_day_limit'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'refund_day_limit'], [
                'value' => 0
            ]);
        }
        if(BusinessSetting::where(['type' => 'business_mode'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'business_mode'], [
                'value' => 'multi'
            ]);
        }

        if(BusinessSetting::where(['type' => 'decimal_point_settings'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'decimal_point_settings'], [
                'value' => 2
            ]);
        }

        if(BusinessSetting::where(['type' => 'shop_address'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'shop_address'], [
                'value' => ''
            ]);
        }

        if(BusinessSetting::where(['type' => 'billing_input_by_customer'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'billing_input_by_customer'], [
                'value' => 1
            ]);
        }

        if (BusinessSetting::where(['type' => 'flutterwave'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'flutterwave'], [
                'value' => json_encode([
                    'status' => 1,
                    'public_key' => '',
                    'secret_key' => '',
                    'hash' => '',
                ])
            ]);
        }

        if (BusinessSetting::where(['type' => 'mercadopago'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'mercadopago'], [
                'value' => json_encode([
                    'status' => 1,
                    'public_key' => '',
                    'access_token' => '',
                ])
            ]);
        }

        if (Color::where(['name' => 'Cyan'])->first() == true) {
            Color::where(['name' => 'Cyan'])->delete();
        }

        if (BusinessSetting::where(['type' => 'forgot_password_verification'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'forgot_password_verification'], [
                'value' => 'email'
            ]);
        }

        if (User::where(['id' => 0])->first() == false) {
            User::insert([
                'name' => 'walking customer',
                'f_name' => 'walking',
                'l_name' => 'customer',
                'email' => 'walking@customer.com',
                'phone' => '000000000000'
            ]);
            User::where('phone', '000000000000')->update(['id' => 0]);
        }

        if (BusinessSetting::where(['type' => 'announcement'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'announcement'], [
                'value' => json_encode(
                    ['status' => $request['announcement_status'],
                        'color' => $request['announcement_color'],
                        'text_color' => $request['text_color'],
                        'announcement' => $request['announcement'],
                    ]),
            ]);
        }

        if(BusinessSetting::where(['type' => 'mail_config'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'mail_config'], [
                'value' => json_encode([
                    "status" => 0,
                    "name" => '',
                    "host" => '',
                    "driver" => '',
                    "port" => '',
                    "username" => '',
                    "email_id" => '',
                    "encryption" => '',
                    "password" => ''
                ])
            ]);
        }else{
            $mail_config = Helpers::get_business_settings('mail_config');
            DB::table('business_settings')->updateOrInsert(['type' => 'mail_config'], [
                'value' => json_encode([
                    "status" => $mail_config['status']??0,
                    "name" => $mail_config['name']??'',
                    "host" => $mail_config['host']??'',
                    "driver" => $mail_config['driver']??'',
                    "port" => $mail_config['port']??'',
                    "username" => $mail_config['username']??'',
                    "email_id" => $mail_config['email_id']??'',
                    "encryption" => $mail_config['encryption']??'',
                    "password" => $mail_config['password']??''
                ])
            ]);
        }

        if(BusinessSetting::where(['type' => 'mail_config_sendgrid'])->first() == false)
        {
            DB::table('business_settings')->updateOrInsert(['type' => 'mail_config_sendgrid'], [
                'value' => json_encode([
                    "status" => 0,
                    "name" => '',
                    "host" => '',
                    "driver" => '',
                    "port" => '',
                    "username" => '',
                    "email_id" => '',
                    "encryption" => '',
                    "password" => ''
                ])
            ]);
        }

        $ssl_commerz_payment = Helpers::get_business_settings('ssl_commerz_payment');

        DB::table('business_settings')->updateOrInsert(['type' => 'ssl_commerz_payment'],[

            'value' => json_encode([
                'status' => $ssl_commerz_payment['status']??0,
                'environment'=> $ssl_commerz_payment['environment']??'sandbox',
                'store_id' => $ssl_commerz_payment['store_id']??'',
                'store_password' => $ssl_commerz_payment['store_password']??'',
            ]),
            'updated_at' => now()
        ]);


        $paypal = Helpers::get_business_settings('paypal');

        DB::table('business_settings')->updateOrInsert(['type' => 'paypal'],[
            'value' => json_encode([
                'status' => $paypal['status']??0,
                'environment'=>$paypal['environment']??'sandbox',
                'paypal_client_id' => $paypal['paypal_client_id']??'',
                'paypal_secret' => $paypal['paypal_secret']??'',
            ]),
            'updated_at' => now()
        ]);

        $paytm = Helpers::get_business_settings('paytm');

        DB::table('business_settings')->updateOrInsert(['type' => 'paytm'], [
            'value' => json_encode([
                'status' => $paytm['status']??0,
                'environment'=>$paytm['environment']??'sandbox',
                'paytm_merchant_key' => $paytm['paytm_merchant_key']??'',
                'paytm_merchant_mid' => $paytm['paytm_merchant_mid']??'',
                'paytm_merchant_website' => $paytm['paytm_merchant_website']??'',
                'paytm_refund_url' => $paytm['paytm_refund_url']??'',
            ]),
            'updated_at' => now()
        ]);

        $bkash = Helpers::get_business_settings('bkash');
        DB::table('business_settings')->updateOrInsert(['type' => 'bkash'], [
            'value' => json_encode([
                'status' => $bkash['status']??0,
                'environment'=>$bkash['environment']??'sandbox',
                'api_key' => $bkash['api_key']??'',
                'api_secret' => $bkash['api_secret']??'',
                'username' => $bkash['username']??'',
                'password' => $bkash['password']??'',
            ]),
            'updated_at' => now()
        ]);

        if (BusinessSetting::where(['type' => 'fawry_pay'])->first() == false) {
            DB::table('business_settings')->insert([
                'type' => 'fawry_pay',
                'value' => json_encode([
                    'status' => 0,
                    'merchant_code' => '',
                    'security_key' => ''
                ]),
                'updated_at' => now()
            ]);
        }

        if (BusinessSetting::where(['type' => 'paytabs'])->first() == false) {
            DB::table('business_settings')->insert([
                'type' => 'paytabs',
                'value' => json_encode([
                    'status' => 0,
                    'profile_id' => '',
                    'server_key' => '',
                    'base_url' => 'https://secure-egypt.paytabs.com/'
                ]),
                'updated_at' => now()
            ]);
        }

        if (BusinessSetting::where(['type' => 'recaptcha'])->first() == false) {
            DB::table('business_settings')->insert([
                'type' => 'recaptcha',
                'value' => json_encode([
                    'status' => 0,
                    'site_key' => '',
                    'secret_key' => '',
                ]),
                'updated_at' => now()
            ]);
        }

        if (AdminWallet::where(['admin_id' => 1])->first() == false) {
            DB::table('admin_wallets')->insert([
                'admin_id' => 1,
                'withdrawn' => 0,
                'commission_earned' => 0,
                'inhouse_earning' => 0,
                'delivery_charge_earned' => 0,
                'pending_amount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (BusinessSetting::where(['type' => 'paytm'])->first() == false || env('SOFTWARE_VERSION') <= 7) {
            DB::table('business_settings')->updateOrInsert(['type' => 'paytm'], [
                'value' => json_encode([
                    'status' => 0,
                    'paytm_merchant_key' => '',
                    'paytm_merchant_mid' => '',
                    'paytm_merchant_website' => '',
                    'paytm_refund_url' => null
                ])
            ]);
        }

        if (BusinessSetting::where(['type' => 'liqpay'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'liqpay'], [
                'value' => json_encode([
                    'status' => 0,
                    'public_key' => '',
                    'private_key' => ''
                ])
            ]);
        }

        return redirect('/admin/auth/login');
    }
}
