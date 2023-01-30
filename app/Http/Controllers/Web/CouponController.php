<?php

namespace App\Http\Controllers\Web;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Coupon;
use App\Model\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $couponLimit = Order::where('customer_id', auth('customer')->id())
            ->where('coupon_code', $request['code'])->count();
        $default_city = Helpers::default_city();
        $coupon = Coupon::where(['code' => $request['code']]) 
            ->where('city', $default_city)
            ->where('limit', '>', $couponLimit)
            ->where('status', '=', 1)
            ->whereDate('start_date', '<=', date('y-m-d'))
            ->whereDate('expire_date', '>=', date('y-m-d'))->first();
    
        if ($coupon) {
            $total = 0;
            foreach (CartManager::get_cart() as $cart) {
                $product_subtotal = $cart['price'] * $cart['quantity'];
                $total += $product_subtotal;
            }
            if ($total >= $coupon['min_purchase']) {
                if ($coupon['discount_type'] == 'percentage') {
                    $discount = (($total / 100) * $coupon['discount']) > $coupon['max_discount'] ? $coupon['max_discount'] : (($total / 100) * $coupon['discount']);
                } else {
                    $discount = $coupon['discount'];
                }

                session()->put('coupon_code', $request['code']);
                session()->put('coupon_discount', $discount);

                return response()->json([
                    'status' => 1,
                    'discount' => Helpers::currency_converter($discount),
                    'total' => Helpers::currency_converter($total - $discount),
                    'messages' => ['0' => 'Coupon Applied Successfully!']
                ]);
            }
        }

        return response()->json([
            'status' => 0,
            'messages' => ['0' => 'Invalid Coupon']
        ]);
    }
}
