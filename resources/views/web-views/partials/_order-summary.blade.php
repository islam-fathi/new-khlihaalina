<style>
    .cart_title {
        font-weight: 400 !important;
        font-size: 16px;
    }

    .cart_value {
        font-weight: 600 !important;
        font-size: 16px;
    }

    .cart_total_value {
        font-weight: 700 !important;
        font-size: 25px !important;
        color: {{$web_config['primary_color']}}     !important;
    }
</style>

<aside class="col-lg-4 pt-4 pt-lg-0">
    <div class="cart_total">
        @php($sub_total=0)
        @php($total_tax=0)
        @php($total_shipping_cost=0)
        @php($total_discount_on_product=0)
        @php($cart=\App\CPU\CartManager::get_cart())
        @php($shipping_cost=\App\CPU\CartManager::get_shipping_cost())
        @if($cart->count() > 0)
            @foreach($cart as $key => $cartItem)
                @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
                @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
            @endforeach
            @php($total_shipping_cost=$shipping_cost)
        @else
            <span>{{\App\CPU\translate('empty_cart')}}</span>
        @endif
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('sub_total')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($sub_total)}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('tax')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($total_tax)}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('shipping')}}</span>
            <span class="cart_value">
                {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
            </span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('discount_on_product')}}</span>
            <span class="cart_value">
                - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}
            </span>
        </div>
        @if(session()->has('coupon_discount'))
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{\App\CPU\translate('coupon_discount')}}</span>
                <span class="cart_value" id="coupon-discount-amount">
                    - {{session()->has('coupon_discount')?\App\CPU\Helpers::currency_converter(session('coupon_discount')):0}}
                </span>
            </div>
            @php($coupon_dis=session('coupon_discount'))
        @else
            <div class="mt-2">
                <form class="needs-validation" action="javascript:" method="post" novalidate id="coupon-code-ajax">
                    <div class="form-group">
                        <input class="form-control input_code" type="text" name="code" placeholder="{{\App\CPU\translate('Coupon code')}}"
                               required>
                        <div class="invalid-feedback">{{\App\CPU\translate('please_provide_coupon_code')}}</div>
                    </div>
                    <button class="btn btn-primary btn-block" type="button" onclick="couponCode()">{{\App\CPU\translate('apply_code')}}
                    </button>
                </form>
            </div>
            @php($coupon_dis=0)
        @endif
        <hr class="mt-2 mb-2">
        <div class="d-flex justify-content-between">
            <span class="cart_title">{{\App\CPU\translate('total')}}</span>
            <span class="cart_value">
               {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)}}
            </span>
        </div>

        {{-- <div class="d-flex justify-content-center">
            <span class="cart_total_value mt-2">
                {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)}}
            </span>
        </div> --}}
    </div>
    <div class="container mt-2">
        <div class="row p-0">
            <div class="col-md-3 p-0 text-center mobile-padding">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/delivery.png")}}" alt="">
                <div class="deal-title">3 {{\App\CPU\translate('days_free_delivery')}} </div>
            </div>

            <div class="col-md-3 p-0 text-center">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/money.png")}}" alt="">
                <div class="deal-title">{{\App\CPU\translate('money_back_guarantee')}}</div>
            </div>
            <div class="col-md-3 p-0 text-center">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/Genuine.png")}}" alt="">
                <div class="deal-title">100% {{\App\CPU\translate('genuine')}} {{\App\CPU\translate('product')}}</div>
            </div>
            <div class="col-md-3 p-0 text-center">
                <img class="order-summery-footer-image" src="{{asset("public/assets/front-end/png/Payment.png")}}" alt="">
                <div class="deal-title">{{\App\CPU\translate('authentic_payment')}}</div>
            </div>
        </div>
    </div>
</aside>
