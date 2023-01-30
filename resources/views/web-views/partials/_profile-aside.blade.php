<style>
    body {
        font-family: sans-serif;
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #6A6A6A;
    }

    label {
        font-size: 16px;
    }

    .divider-role {
        border-bottom: 1px solid whitesmoke;
    }

    .sidebarL h3:hover + .divider-role {
        border-bottom: 3px solid {{$web_config['secondary_color']}}    !important;
        transition: .2s ease-in-out;
    }

    .price_sidebar {
        padding: 20px;
    }

    @media (max-width: 600px) {

        .sidebar_heading h1 {
            text-align: center;
            color: aliceblue;
            padding-bottom: 17px;
            font-size: 19px;
        }

        .sidebarR {
            padding: 24px;
        }

        .price_sidebar {
            padding: 20px;
        }
    }

</style>

<div class="sidebarR col-lg-3 col-md-3">
    <!--Price Sidebar-->
    <div class="price_sidebar rounded-lg box-shadow-sm" id="shop-sidebar" style="margin-bottom: -10px;background: white">
        <div class="box-shadow-sm">

        </div>
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-order*') || Request::is('account-order-details*') ? 'active-menu' :''}}" href="{{route('account-order') }} ">{{\App\CPU\translate('my_order')}}</a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('doctor-appointments*') || Request::is('doctor-appointment-details*') ? 'active-menu' :''}}" href="{{route('doctor-appointments') }} ">{{\App\CPU\translate('my_doctor_appointments')}}</a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('pharmacy-orders*') || Request::is('pharmacy-order-details*') ? 'active-menu' :''}}" href="{{route('pharmacy-orders') }} ">{{\App\CPU\translate('my_pharmacy_orders')}}</a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0" style="padding-top: 12px;">
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('service-orders*') || Request::is('service-order-details*') ? 'active-menu' :''}}" href="{{route('service-orders') }} ">{{\App\CPU\translate('my_service_orders')}}</a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('track-order*')?'active-menu':''}}" href="{{route('track-order.index') }} ">{{\App\CPU\translate('track_your_order')}}</a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0">
            <!-- Filter by price-->
            <div class="sidebarL">
                <h3 class="widget-title btnF " style="font-weight: 700;">
                    <a class="{{Request::is('wishlists*')?'active-menu':''}}" href="{{route('wishlists')}}"> {{\App\CPU\translate('wish_list')}}  </a></h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>

        {{--to do--}}
        @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
        @if ($business_mode == 'multi')
            <div class="pb-0">
                <!-- Filter by price-->
                <div class="sidebarL">
                    <h3 class="widget-title btnF" style="font-weight: 700;">
                        <a class="{{Request::is('chat*')?'active-menu':''}}" href="{{route('chat-with-seller')}}">{{\App\CPU\translate('chat_with_seller')}}</a>
                    </h3>
                    <div class="divider-role"
                        style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                    </div>
                </div>
            </div>
        @endif

        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('user-account*')?'active-menu':''}}" href="{{route('user-account')}}">
                        {{\App\CPU\translate('profile_info')}}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-address*')?'active-menu':''}}"
                       href="{{ route('account-address') }}">{{\App\CPU\translate('address')}} </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        <div class="pb-0">
            <!-- Filter by price-->
            <div class=" sidebarL">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{(Request::is('account-ticket*') || Request::is('support-ticket*'))?'active-menu':''}}"
                       href="{{ route('account-tickets') }}">{{\App\CPU\translate('support_ticket')}}</a></h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;">
                </div>
            </div>
        </div>
        {{--<div class="pb-0" style="padding-top: 12px;">
            <!-- Filter by price-->
            <div class="sidebarL ">
                <h3 class="widget-title btnF" style="font-weight: 700;">
                    <a class="{{Request::is('account-transaction*')?'active-menu':''}}"
                       href="{{ route('account-transaction') }}">
                       {{\App\CPU\translate('tansction_history')}}
                    </a>
                </h3>
                <div class="divider-role"
                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>
            </div>
        </div>--}}
    </div>
</div>


















