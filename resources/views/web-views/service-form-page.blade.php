@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Service Page'))

@push('css_or_js')
    @if($service['id'] != 0)
        <meta property="og:image" content="{{asset('storage/app/public/service')}}/{{$service->image}}"/>
        <meta property="og:title" content="{{ $service->name}} "/>
        <meta property="og:url" content="{{route('serviceView',[$service['id']])}}">
    @else
        <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"/>
        <meta property="og:title" content="{{ $service['name']}} "/>
        <meta property="og:url" content="{{route('serviceView',[$service['id']])}}">
    @endif
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}"> 

    @if($service['id'] != 0)
        <meta property="twitter:card" content="{{asset('storage/app/public/service')}}/{{$service->image}}"/>
        <meta property="twitter:title" content="{{route('serviceView',[$service['id']])}}"/>
        <meta property="twitter:url" content="{{route('serviceView',[$service['id']])}}">
    @else
        <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"/>
        <meta property="twitter:title" content="{{route('serviceView',[$service['id']])}}"/>
        <meta property="twitter:url" content="{{route('serviceView',[$service['id']])}}">
    @endif
    <meta name="description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link href="{{asset('public/assets/front-end')}}/css/home.css" rel="stylesheet">
    <style>
        .msg-option { 
            display: none;
        }

        .chatInputBox {
            width: 100%;
        }

        .go-to-chatbox {
            width: 100%;
            text-align: center;
            padding: 5px 0px;
            display: none;
        }

        .feature_header {
            display: flex;
            justify-content: center;
        }

        .btn-number:hover {
            color: #f58300;

        }

        .for-total-price {
            margin-left: -30%;
        }

        .feature_header span {
            padding-left: 15px;
            font-weight: 700;
            font-size: 25px;
            background-color: #ffffff;
            text-transform: uppercase;
        }

        .flash-deals-background-image {
            background: #3b71de10;
            border-radius: 5px;
            width: 125px;
            height: 125px;
        }

        @media (max-width: 768px) {
            .feature_header span {
                margin-bottom: -40px;
            }

            .for-total-price {
                padding-left: 30%;
            }

            .product-quantity {
                padding-left: 4%;
            }

            .for-margin-bnt-mobile {
                margin-right: 7px;
            }

            .font-for-tab {
                font-size: 11px !important;
            }

            .pro {
                font-size: 13px;
            }
        }

        @media (max-width: 375px) {
            .for-margin-bnt-mobile {
                margin-right: 3px;
            }

            .for-discount {
                margin-left: 10% !important;
            }

            .for-dicount-div {
                margin-top: -5%;
                margin-right: -7%;
            }

            .product-quantity {
                margin-left: 4%;
            }

        }

        @media (max-width: 500px) {
            .for-dicount-div {
                margin-top: -4%;
                margin-right: -5%;
            }

            .for-total-price {
                margin-left: -20%;
            }

            .view-btn-div {

                margin-top: -9%;
                float: right;
            }

            .for-discount {
                margin-left: 7%;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }

            .feature_header span {
                margin-bottom: -7px;
            }

            .for-mobile-capacity {
                margin-left: 7%;
            }
        }
        th,
        td {
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }

        thead {
            background: #3b71de !important;
            color: white;
        }

        .product-details-shipping-details {
            background: #ffffff;
            border-radius: 5px;
            font-size: 14;
            font-weight: 400;
            color: #212629;
        }

        .shipping-details-bottom-border {
            border-bottom: 1px #F9F9F9 solid;
        }
        body {
            background-color: #f7f8fa94;
        }

        .rtl {
            direction: ltr;
        }

        .password-toggle-btn .password-toggle-indicator:hover {
            color: #3b71de;
        }

        .password-toggle-btn .custom-control-input:checked~.password-toggle-indicator {
            color: #f58300;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            color: #3b71de;
            text-decoration: none;
            background-color: rgba(0, 0, 0, 0)
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: #f58300;
            text-decoration: none;
            background-color: rgba(0, 0, 0, 0)
        }

        .topbar a {
            color: black !important;
        }

        .navbar-light .navbar-tool-icon-box {
            color: #3b71de;
        }

        .search_button {
            background-color: #3b71de;
            border: none;
        }

        .nav-link {
            color: white !important;
        }

        .navbar-stuck-menu {
            background-color: #3b71de;
            min-height: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        .mega-nav {
            background: white;
            position: relative;
            margin-top: 6px;
            line-height: 17px;
            width: 304px;
            border-radius: 3px;
        }

        .mega-nav .nav-item .nav-link {
            padding-top: 11px !important;
            color: #3b71de !important;
            font-size: 20px;
            font-weight: 600;
            padding-left: 20px !important;
        }

        .nav-item .dropdown-toggle::after {
            margin-left: 20px !important;
        }

        .navbar-tool-text {
            padding-left: 5px !important;
            font-size: 16px;
        }

        .navbar-tool-text>small {
            color: #4b566b !important;
        }

        .modal-header .nav-tabs .nav-item .nav-link {
            color: black !important;
            /*border: 1px solid #E2F0FF;*/
        }

        .checkbox-alphanumeric::after,
        .checkbox-alphanumeric::before {
            content: '';
            display: table;
        }

        .checkbox-alphanumeric::after {
            clear: both;
        }

        .checkbox-alphanumeric input {
            left: -9999px;
            position: absolute;
        }

        .checkbox-alphanumeric label {
            width: 2.25rem;
            height: 2.25rem;
            float: left;
            padding: 0.375rem 0;
            margin-right: 0.375rem;
            display: block;
            color: #818a91;
            font-size: 0.875rem;
            font-weight: 400;
            text-align: center;
            background: transparent;
            text-transform: uppercase;
            border: 1px solid #e6e6e6;
            border-radius: 2px;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            transition: all 0.3s ease;
            transform: scale(0.95);
        }

        .checkbox-alphanumeric-circle label {
            border-radius: 100%;
        }

        .checkbox-alphanumeric label>img {
            max-width: 100%;
        }

        .checkbox-alphanumeric label:hover {
            cursor: pointer;
            border-color: #3b71de;
        }

        .checkbox-alphanumeric input:checked~label {
            transform: scale(1.1);
            border-color: red !important;
        }

        .checkbox-alphanumeric--style-1 label {
            width: auto;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 2px;
        }

        .d-table.checkbox-alphanumeric--style-1 {
            width: 100%;
        }

        .d-table.checkbox-alphanumeric--style-1 label {
            width: 100%;
        }

        /* CUSTOM COLOR INPUT */
        .checkbox-color::after,
        .checkbox-color::before {
            content: '';
            display: table;
        }

        .checkbox-color::after {
            clear: both;
        }

        .checkbox-color input {
            left: -9999px;
            position: absolute;
        }

        .checkbox-color label {
            width: 2.25rem;
            height: 2.25rem;
            float: left;
            padding: 0.375rem;
            margin-right: 0.375rem;
            display: block;
            font-size: 0.875rem;
            text-align: center;
            opacity: 0.7;
            border: 2px solid #d3d3d3;
            border-radius: 50%;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            transition: all 0.3s ease;
            transform: scale(0.95);
        }

        .checkbox-color-circle label {
            border-radius: 100%;
        }

        .checkbox-color label:hover {
            cursor: pointer;
            opacity: 1;
        }

        .checkbox-color input:checked~label {
            transform: scale(1.1);
            opacity: 1;
            border-color: red !important;
        }

        .checkbox-color input:checked~label:after {
            content: "\f121";
            font-family: "Ionicons";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .card-img-top img,
        figure {
            max-width: 200px;
            max-height: 200px !important;
            vertical-align: middle;
        }

        .product-card {
            box-shadow: 1px 1px 6px #00000014;
            border-radius: 5px;
        }

        .product-card .card-header {
            text-align: center;
            background: white 0% 0% no-repeat padding-box;
            border-radius: 5px 5px 0px 0px;
            border-bottom: white !important;
        }

        .product-title {
            font-family: 'Roboto', sans-serif !important;
            font-weight: 400 !important;
            font-size: 22px !important;
            color: #000000 !important;
        }

        .feature_header span {
            font-weight: 700;
            font-size: 25px;
            text-transform: uppercase;
        }

        html[dir="ltr"] .feature_header span {
            padding-right: 15px;
        }

        html[dir="rtl"] .feature_header span {
            padding-left: 15px;
        }

        @media (max-width: 768px) {
            .feature_header {
                margin-top: 0;
                display: flex;
                justify-content: flex-start !important;

            }

            .store-contents {
                justify-content: center;
            }

            .feature_header span {
                padding-right: 0;
                padding-left: 0;
                font-weight: 700;
                font-size: 25px;
                text-transform: uppercase;
            }

            .view_border {
                margin: 16px 0px;
                border-top: 2px solid #E2F0FF !important;
            }

        }

        .scroll-bar {
            max-height: calc(100vh - 100px);
            overflow-y: auto !important;
        }

        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px white;
            border-radius: 5px;
        }

        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(194, 194, 194, 0.38) !important;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #f58300 !important;
        }

        .mobileshow {
            display: none;
        }

        @media screen and (max-width: 500px) {
            .mobileshow {
                display: block;
            }
        }

        [type="radio"] {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        [type="radio"]+span:after {
            content: '';
            display: inline-block;
            width: 1.1em;
            height: 1.1em;
            vertical-align: -0.10em;
            border-radius: 1em;
            border: 0.35em solid #fff;
            box-shadow: 0 0 0 0.10em#f58300;
            margin-left: 0.75em;
            transition: 0.5s ease all;
        }

        [type="radio"]:checked+span:after {
            background: #f58300;
            box-shadow: 0 0 0 0.10em#f58300;
        }

        [type="radio"]:focus+span::before {
            font-size: 1.2em;
            line-height: 1;
            vertical-align: -0.125em;
        }


        .checkbox-color label {
            box-shadow: 0px 3px 6px #0000000D;
            border: none;
            border-radius: 3px !important;
            max-height: 35px;
        }

        .checkbox-color input:checked~label {
            transform: scale(1.1);
            opacity: 1;
            border: 1px solid #ffb943 !important;
        }

        .checkbox-color input:checked~label:after {
            font-family: "Ionicons", serif;
            position: absolute;
            content: "\2713" !important;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .navbar-tool .navbar-tool-label {
            position: absolute;
            top: -.3125rem;
            right: -.3125rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            background-color: #f58300 !important;
            color: #fff;
            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .btn-primary {
            color: #fff;
            background-color: #3b71de !important;
            border-color: #3b71de !important;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #3b71de !important;
            border-color: #3b71de !important;
        }

        .btn-secondary {
            background-color: #f58300 !important;
            border-color: #f58300 !important;
        }

        .btn-outline-accent:hover {
            color: #fff;
            background-color: #3b71de;
            border-color: #3b71de;
        }

        .btn-outline-accent {
            color: #3b71de;
            border-color: #3b71de;
        }

        .text-accent {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #3b71de;
        }

        a:hover {
            color: #f58300;
            text-decoration: none
        }

        .active-menu {
            color: #f58300 !important;
        }

        .page-item.active>.page-link {
            box-shadow: 0 0.5rem 1.125rem -0.425rem#3b71de
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #3b71de;
            border-color: rgba(0, 0, 0, 0)
        }

        .btn-outline-accent:not(:disabled):not(.disabled):active,
        .btn-outline-accent:not(:disabled):not(.disabled).active,
        .show>.btn-outline-accent.dropdown-toggle {
            color: #fff;
            background-color: #f58300;
            border-color: #f58300;
        }

        .btn-outline-primary {
            color: #3b71de;
            border-color: #3b71de;
        }

        .btn-outline-primary:hover {
            color: #fff;
            background-color: #f58300;
            border-color: #f58300;
        }

        .btn-outline-primary:focus,
        .btn-outline-primary.focus {
            box-shadow: 0 0 0 0#f58300;
        }

        .btn-outline-primary.disabled,
        .btn-outline-primary:disabled {
            color: #6f6f6f;
            background-color: transparent
        }

        .btn-outline-primary:not(:disabled):not(.disabled):active,
        .btn-outline-primary:not(:disabled):not(.disabled).active,
        .show>.btn-outline-primary.dropdown-toggle {
            color: #fff;
            background-color: #3b71de;
            border-color: #3b71de;
        }

        .btn-outline-primary:not(:disabled):not(.disabled):active:focus,
        .btn-outline-primary:not(:disabled):not(.disabled).active:focus,
        .show>.btn-outline-primary.dropdown-toggle:focus {
            box-shadow: 0 0 0 0#3b71de;
        }

        .feature_header span {
            background-color: #fafafc !important
        }

        .discount-top-f {
            position: absolute;
        }

        html[dir="ltr"] .discount-top-f {
            left: 0;
        }

        html[dir="rtl"] .discount-top-f {
            right: 0;
        }

        .for-discoutn-value {
            background: #3b71de;

        }

        .czi-star-filled {
            color: #fea569 !important;
        }

        .flex-start {
            display: flex;
            justify-content: flex-start;
        }

        .flex-center {
            display: flex;
            justify-content: center;
        }

        .flex-around {
            display: flex;
            justify-content: space-around;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
        }

        .row-reverse {
            display: flex;
            flex-direction: row-reverse;
        }

        .count-value {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }
        .stock-out {
            position: absolute;
            top: 40% !important;
            color: white !important;
            font-weight: 900;
            font-size: 15px;
        }

        html[dir="ltr"] .stock-out {
            left: 35% !important;
        }

        html[dir="rtl"] .stock-out {
            right: 35% !important;
        }

        .product-card {
            height: 100%;
        }

        .badge-style {
            left: 75% !important;
            margin-top: -2px !important;
            background: transparent !important;
            color: black !important;
        }

        html[dir="ltr"] .badge-style {
            right: 0 !important;
        }

        html[dir="rtl"] .badge-style {
            left: 0 !important;
        }
        .dropdown-menu {
            min-width: 304px !important;
            margin-left: -8px !important;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
        }
        .close {
            z-index: 99;
            background: white !important;
            padding: 3px 8px !important;
            margin: -23px -12px -1rem auto !important;
            border-radius: 50%;
        }
        .card-body.search-result-box {
            overflow: scroll;
            height: 400px;
            overflow-x: hidden;
        }

        .active .seller {
            font-weight: 700;
        }

        .for-count-value {
            position: absolute;

            right: 0.6875rem;
            ;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            color: #3b71de;

            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .count-value {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            color: #3b71de;

            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        @media (min-width: 992px) {
            .navbar-sticky.navbar-stuck .navbar-stuck-menu.show {
                display: block;
                height: 55px !important;
            }
        }

        @media (min-width: 768px) {
            .navbar-stuck-menu {
                background-color: #3b71de;
                line-height: 15px;
                padding-bottom: 6px;
            }

        }

        @media (max-width: 767px) {
            .search_button {
                background-color: transparent !important;
            }

            .search_button .input-group-text i {
                color: #3b71de !important;
            }

            .navbar-expand-md .dropdown-menu>.dropdown>.dropdown-toggle {
                position: relative;
                padding-right: 1.95rem;
            }

            .mega-nav1 {
                background: white;
                color: #3b71de !important;
                border-radius: 3px;
            }

            .mega-nav1 .nav-link {
                color: #3b71de !important;
            }
        }

        @media (max-width: 768px) {
            .tab-logo {
                width: 10rem;
            }
        }

        @media (max-width: 360px) {
            .mobile-head {
                padding: 3px;
            }
        }

        @media (max-width: 471px) {
            .navbar-brand img 

            .mega-nav1 {
                background: white;
                color: #3b71de !important;
                border-radius: 3px;
            }

            .mega-nav1 .nav-link {
                color: #3b71de !important;
            }
        }

        #anouncement {
            width: 100%;
            padding: 2px 0;
            text-align: center;
            color: white;
        }
        .social-media :hover {
            color: #f58300 !important;
        }

        .widget-list-link {
            color: white !important;
        }

        .widget-list-link:hover {
            color: #999898 !important;
        }

        .subscribe-border {
            border-radius: 5px;
        }

        .subscribe-button {
            background: #1B7FED;
            position: absolute;
            top: 0;
            color: white;
            padding: 11px;
            padding-left: 15px;
            padding-right: 15px;
            text-transform: capitalize;
            border: none;
        }

        .start_address {
            display: flex;
            justify-content: space-between;
        }

        .start_address_under_line {
            width: 331px;
        }

        .address_under_line {
            width: 299px;
        }

        .end-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media only screen and (max-width: 500px) {
            .start_address {
                display: block;
            }

            .footer-web-logo {
                justify-content: center !important;
                padding-bottom: 25px;
            }

            .footer-padding-bottom {
                padding-bottom: 15px;
            }

            .mobile-view-center-align {
                justify-content: center !important;
                padding-bottom: 15px;
            }

            .last-footer-content-align {
                display: flex !important;
                justify-content: center !important;
                padding-bottom: 10px;
            }
        }

        @media only screen and (max-width: 800px) {
            .end-footer {

                display: block;

                align-items: center;
            }
        }

        @media only screen and (max-width: 1200px) {
            .start_address_under_line {
                display: none;
            }

            .address_under_line {
                display: none;
            }
        }
    </style>
    <script>
        function myFunction() {
            $('#anouncement').addClass('d-none').removeClass('d-flex')
        }
    </script>
@endpush

@section('content')
    {{-- <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 1px;border-bottom: 0px!important;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 3px!important; cursor: pointer"
                    onclick="location.href={{ route('serviceView',[$service->id]) }} ">
                    <img class="d-block w-100"
                        onerror="this.src='{{ asset('public/assets/front-end') }}/img/image-place-holder.png'"
                        src="{{ asset('storage/app/public/banner/2022-04-21-6260c07b91aed.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-quick-view modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="quick-view-modal">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="margin-top:10rem;position: fixed;z-index: 9999;">
            <div id="loading" style="display: none;">
                <center>
                    <img width="200" src="{{ asset('storage/app/public/company/2022-04-23-62640d298e373.png')}}"
                        onerror="this.src='{{ asset('public/assets/front-end/img/loader.gif')}}'">
                </center>
            </div>
        </div>
    </div> --}}
    <?php
    $overallRating = \App\CPU\ProductManager::get_overall_rating($service->reviews); 
    $rating = \App\CPU\ProductManager::get_rating($service->reviews);
    ?>
    <div class="container mt-4 rtl" style="text-align: left;">
        <div class="row" style="direction: ltr">
            <div class="col-md-9 col-12">
                <div class="row">
                    <div class="col-lg-5 col-md-4 col-12">
                        <div class="cz-product-gallery">
                            <div class="cz-preview">
                                @if($service->images!=null)
                                    @foreach (json_decode($service->images) as $key => $photo)
                                        <div
                                            class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                            id="image{{$key}}">
                                            <img class="cz-image-zoom img-responsive" style="width:100%;height:auto"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset("storage/app/public/services/$photo")}}"
                                                data-zoom="{{asset("storage/app/public/services/$photo")}}"
                                                alt="Service image" width="">
                                            <div class="cz-image-zoom-pane"></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="cz">
                                <div>
                                    <div class="row">
                                        <div class="table-responsive" data-simplebar style="max-height: 515px; padding: 1px;">
                                            <div class="d-flex" style="padding-left: 3px;">
                                                @if($service->images!=null)
                                                    @foreach (json_decode($service->images) as $key => $photo)
                                                        <div class="cz-thumblist">
                                                            <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center "
                                                            href="#image{{$key}}">
                                                                <img
                                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                    src="{{asset("storage/app/public/services/$photo")}}"
                                                                    alt="Service thumb">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-8 col-12 mt-md-0 mt-sm-3" style="direction: ltr">
                        <div class="details">
                            @if(!empty($service->working_from_time)  && !empty($service->working_to_time))
                                @php($destinationTimezone = new DateTimeZone('Africa/Cairo'))
                                @php($now_time = now()->setTimeZone($destinationTimezone)->format('H:i'))
                                {{-- @php($now_time = "15:00") --}}
                                @if($now_time >= $service->working_from_time)
                                    @if($service->working_to_time <= $service->working_from_time)
                                        @php($is_open = true)
                                    @else
                                        @if($now_time < $service->working_to_time)
                                            @php($is_open = true)
                                        @else
                                            @php($is_open = false)
                                        @endif
                                    @endif
                                @else
                                    @if($service->working_to_time > $service->working_from_time)
                                        @php($is_open = false)
                                    @else
                                        @if($now_time >= $service->working_to_time)
                                            @php($is_open = false)
                                        @else
                                            @php($is_open = true)
                                        @endif
                                    @endif
                                @endif
                                
                                @if($is_open == true)
                                    <span>{{ \App\CPU\translate('Open') }}</span>
                                @else
                                    <span>{{ \App\CPU\translate('Close') }}</span>
                                @endif
                            @endif
                            
                            <span class="mb-2" style="font-size: 22px;font-weight:700;">{{ $service->name }}</span>
                            <div class="d-flex align-items-center mb-2 pro">
                                <span
                                    class="d-inline-block  align-middle mt-1 {{Session::get('direction') === "rtl" ? 'ml-md-2 ml-sm-0 pl-2' : 'mr-md-2 mr-sm-0 pr-2'}}"
                                    style="color: #FE961C">{{$overallRating[0]}}</span>
                                <div class="star-rating" style="{{Session::get('direction') === "rtl" ? 'margin-left: 25px;' : 'margin-right: 25px;'}}">
                                    @for($inc=0;$inc<5;$inc++)
                                        @if($inc<$overallRating[0])
                                            <i class="sr-star czi-star-filled active"></i>
                                        @else
                                            <i class="sr-star czi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span style="font-weight: 400;"
                                    class="font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{Session::get('direction') === "rtl" ? 'mr-1 ml-md-2 ml-1 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-1 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1'}}">{{$overallRating[1]}} {{\App\CPU\translate('Reviews')}}</span>
                                <span style="width: 0px;height: 10px;border: 0.5px solid #707070; margin-top: 6px;font-weight: 400 !important;"></span>
                                <span style="font-weight: 400;"
                                    class="font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{Session::get('direction') === "rtl" ? 'mr-1 ml-md-2 ml-1 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-1 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1'}}">{{$countOrder}} {{\App\CPU\translate('orders')}}   </span>
                                <span style="width: 0px;height: 10px;border: 0.5px solid #707070; margin-top: 6px;font-weight: 400;">    </span>
                            </div>
                            <div class="description">
                                <h3>{{ \App\CPU\translate('Biography') }}</h3>
                                <p>
                                    {{$service->description}}
                                </p>
                            </div>
                            <div style="text-align:{{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="sharethis-inline-share-buttons">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-4 rtl col-12" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <div class="row">
                            <div class="col-12">
                                <div class=" mt-1">
                                    <ul class="nav nav-tabs d-flex justify-content-center" role="tablist"
                                        style="margin-top:35px;">
                                        <li class="nav-item">
                                            <a class="nav-link active " href="#overview" data-toggle="tab" role="tab"
                                                style="color: black !important;font-weight: 400;font-size: 24px;">
                                                {{ \App\CPU\translate('Qualifications') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#reviews" data-toggle="tab" role="tab"
                                                style="color: black !important;font-weight: 400;font-size: 24px;">
                                                {{ \App\CPU\translate('Reviews') }}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="px-4 pt-lg-3 pb-3 mb-3 mr-0 mr-md-2"
                                        style="background: #ffffff;border-radius:10px;min-height: 817px;">
                                        <div class="tab-content px-lg-3">
                                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                                <div class="row pt-2 specification">
                                                    <div class="text-body col-lg-12 col-md-12"
                                                        style="overflow: scroll;">
                                                        <h2>{{ \App\CPU\translate('Service Details') }}</h2>
                                                        <ul>
                                                            <li>{{ \App\CPU\translate('Name') }} : {{ $service->name }}</li>
                                                            <li>{{ \App\CPU\translate('Phone') }} : {{ $service->phone }}</li>
                                                            <li>{{ \App\CPU\translate('City') }} : {{ $service->cities['name'] }}</li>
                                                            <li>{{ \App\CPU\translate('Address') }} : {{ $service->address }}</li>
                                                            <li>{{ \App\CPU\translate('Working for time') }} : {{ $service->working_from_time }}</li>
                                                            <li>{{ \App\CPU\translate('Working to time') }} : {{ $service->working_to_time }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            @php($reviews_of_service = App\Model\ReviewsOtherType::where('type','service')->where('type_id',$service->id)->paginate(2))
                                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                                <div class="row pt-2 pb-3">
                                                    <div class="col-lg-4 col-md-5 ">
                                                        <div class=" row d-flex justify-content-center align-items-center">
                                                            <div class="col-12 d-flex justify-content-center align-items-center">
                                                                <h2 class="overall_review mb-2" style="font-weight: 500;font-size: 50px;">
                                                                    {{$overallRating[1]}} 
                                                                </h2>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-center align-items-center star-rating ">
                                                                @if (round($overallRating[0])==5)
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                                @if (round($overallRating[0])==4)
                                                                    @for ($i = 0; $i < 4; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    <i class="czi-star font-size-sm text-muted {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                @endif
                                                                @if (round($overallRating[0])==3)
                                                                    @for ($i = 0; $i < 3; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    @for ($j = 0; $j < 2; $j++)
                                                                        <i class="czi-star font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                                @if (round($overallRating[0])==2)
                                                                    @for ($i = 0; $i < 2; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    @for ($j = 0; $j < 3; $j++)
                                                                        <i class="czi-star font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                                @if (round($overallRating[0])==1)
                                                                    @for ($i = 0; $i < 4; $i++)
                                                                        <i class="czi-star font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                @endif
                                                                @if (round($overallRating[0])==0)
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i class="czi-star font-size-sm text-muted {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                            <div class="col-12 d-flex justify-content-center align-items-center mt-2">
                                                                <span class="text-center">
                                                                    {{$reviews_of_service->total()}} {{\App\CPU\translate('ratings')}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-7 pt-sm-3 pt-md-0" >
                                                        <div class="row d-flex align-items-center mb-2 font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap "><span
                                                                    class="d-inline-block align-middle text-body">{{\App\CPU\translate('Excellent')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress text-body" style="height: 5px;">
                                                                    <div class="progress-bar " role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[0] != 0) ? ($rating[0] / $overallRating[1]) * 100 : (0); ?>%;"
                                                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1 text-body">
                                                                <span
                                                                    class=" {{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}} ">
                                                                    {{$rating[0]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap "><span
                                                                    class="d-inline-block align-middle ">{{\App\CPU\translate('Good')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[1] != 0) ? ($rating[1] / $overallRating[1]) * 100 : (0); ?>%; background-color: #a7e453;"
                                                                        aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                        {{$rating[1]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap"><span
                                                                    class="d-inline-block align-middle ">{{\App\CPU\translate('Average')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[2] != 0) ? ($rating[2] / $overallRating[1]) * 100 : (0); ?>%; background-color: #ffda75;"
                                                                        aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                    {{$rating[2]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap "><span
                                                                    class="d-inline-block align-middle">{{\App\CPU\translate('Below Average')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[3] != 0) ? ($rating[3] / $overallRating[1]) * 100 : (0); ?>%; background-color: #fea569;"
                                                                        aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                        class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                    {{$rating[3]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap"><span
                                                                    class="d-inline-block align-middle ">{{\App\CPU\translate('Poor')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;backbround-color:{{$web_config['primary_color']}};width: <?php echo $widthRating = ($rating[4] != 0) ? ($rating[4] / $overallRating[1]) * 100 : (0); ?>%;"
                                                                        aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                        {{$rating[4]}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-4 mb-3">
                                                    <div style="display: block;width:100%;text-align: center;background: #F3F4F5;border-radius: 5px;padding:5px;">
                                                        <span class="text-capitalize">{{\App\CPU\translate('Service Review')}}</span>
                                                    </div>
                                                </div>
                                                <div class="row pb-4">
                                                    <div class="col-12" id="service-review-list">
                                                        {{-- @foreach($reviews_of_doctor as $doctorReview)
                                                            @include('web-views.partials.doctor-reviews',['doctorReview'=>$doctorReview])
                                                        @endforeach --}}
                                                        @if(count($service->reviews)==0)
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h6 class="text-danger text-center">{{\App\CPU\translate('service_review_not_available')}}</h6>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card-footer d-flex justify-content-center align-items-center">
                                                            <button class="btn" style="background: {{$web_config['primary_color']}}; color: #ffffff" onclick="load_review()">{{\App\CPU\translate('view more')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <div class="container rtl" style="text-align: left;">
                                                <div class="row no-gutters">
                                                    <div
                                                        class="col-lg-12 for-send-message py-3 px-4 px-xl-5  box-shadow-sm">
                                                        <h2 class="h4 mb-4 text-center"
                                                            style="color: #030303; font-weight:600;">{{ \App\CPU\translate('Request This Service') }}
                                                        </h2>
                                                        <form action="{{ route('service-order',[$service->id])}}" method="POST" >
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>{{ \App\CPU\translate('Your name') }}</label>
                                                                        <input class="form-control name" name="name"
                                                                            type="text" value="" placeholder="{{ \App\CPU\translate('Mohamed Ahmed') }}"
                                                                            required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="cf-email">{{ \App\CPU\translate('Email address') }}</label>
                                                                        <input class="form-control email" name="email"
                                                                            type="email" value=""
                                                                            placeholder="{{ \App\CPU\translate('test@gmail.com') }}" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="cf-phone">{{ \App\CPU\translate('Your phone') }}</label>
                                                                        <input class="form-control mobile_number"
                                                                            type="text" name="phone" value=""
                                                                            placeholder="{{ \App\CPU\translate('Contact Number') }}" required="">
                                                                    </div> 
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="cf-subject">{{ \App\CPU\translate('Subject') }}</label>
                                                                        <input class="form-control subject" type="text"
                                                                            name="subject" value=""
                                                                            placeholder="{{ \App\CPU\translate('Short title') }}" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="cf-message">{{ \App\CPU\translate('Message') }}</label>
                                                                        <textarea class="form-control message"
                                                                            name="message" rows="6"
                                                                            required="">{{ \App\CPU\translate('Message') }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class=" ">
                                                                <button class="btn btn-primary"
                                                                    type="submit">{{ \App\CPU\translate('Send') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="product-details-shipping-details">
                    <div class="shipping-details-bottom-border">
                        <div style="padding: 25px;">
                            <img class="mr-2" style="height: 20px;width:20px;"
                                src="../public/assets/front-end/png/Payment.png" alt="">
                            <span>{{ \App\CPU\translate('Safe Payment') }}</span>
                        </div>
                    </div>
                    <div class="shipping-details-bottom-border">
                        <div style="padding: 25px;">
                            <img class="mr-2" style="height: 20px;width:20px;"
                                src="../public/assets/front-end/png/money.png" alt="">
                            <span>{{ \App\CPU\translate('7 Days Return Policy') }}</span>
                        </div>
                    </div>
                    <div class="shipping-details-bottom-border">
                        <div style="padding: 25px;">
                            <img class="mr-2" style="height: 20px;width:20px;"
                                src="../public/assets/front-end/png/Genuine.png" alt="">
                            <span>{{ \App\CPU\translate('100% Authentic Service') }}</span>
                        </div>
                    </div>
                </div>
                <div style="padding: 25px;">
                    <div class="row d-flex justify-content-center">
                        <span style="text-align: center;font-weight: 700;
                        font-size: 16px;">
                            {{ \App\CPU\translate('More Services') }}
                        </span>
                    </div>
                </div>
                <div style="">
                    @foreach($services_city as $ser_city)
                        @php($overallRating = \App\CPU\ProductManager::get_overall_rating($ser_city->reviews))
                        <div class="flash_deal_product rtl" style="cursor: pointer; height:155px; margin-bottom:10px;"
                            onclick="location.href='{{route('serviceView',[$ser_city->id])}}'">
                            <div class="d-flex" style="position:absolute;z-index:2;">
                                
                            </div>
                            <div class=" d-flex" style="">
                                <div class=" d-flex align-items-center justify-content-center"
                                    style="padding-left:14px;padding-top:14px;">
                                    <div class="flash-deals-background-image" style="background: #3b71de10">
                                        <img style="height: 125px!important;width:125px!important;border-radius:5px;"
                                            src="{{asset("storage/app/public/services/thumbnail/$ser_city->thumbnail")}}"
                                            onerror="this.src="{{asset("storage/app/public/services/thumbnail/$ser_city->thumbnail")}} />
                                    </div>
                                </div>
                                <div class=" flash_deal_product_details pl-3 pr-3 pr-1 d-flex align-items-center">
                                    <div>
                                        <div>
                                            <span class="flash-product-title">
                                                {{$ser_city->name}}
                                            </span>
                                        </div>
                                        <div class="flash-product-review">
                                            @for($inc=0;$inc<5;$inc++)
                                                @if($inc<$overallRating[0])
                                                    <i class="sr-star czi-star-filled active"></i>
                                                @else
                                                    <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                                @endif
                                            @endfor
                                            <label class="badge-style2">
                                                ( {{$ser_city->reviews->count()}} )
                                            </label>
                                        </div>
                                        <div class="flash-product-price">
                                            {{ \App\CPU\translate('Working for time') }} : {{$ser_city->working_from_time}}
                                        </div>
                                        <div class="flash-product-price">
                                            {{ \App\CPU\translate('Working to time') }} : {{$ser_city->working_to_time}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container  mb-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row flex-between">
            <div class="text-capitalize" style="font-weight: 700; font-size: 30px;margin-left: 5px;">
                <span>{{ \App\CPU\translate('Similar Services') }}</span>
            </div>
            {{-- <div class="view_all d-flex justify-content-center align-items-center">
                <div>
                    <a class="text-capitalize view-all-text" style="color:#3b71de !important;margin-right: 8px;"
                        href="https://6valley.6amtech.com/products?id=12&amp;data_from=category&amp;page=1">{{ \App\CPU\translate('View all') }}
                        <i class="czi-arrow-right-circle ml-1 mr-n1"></i>
                    </a>
                </div>
            </div> --}}
        </div>
        <div class="row mt-4">
            @foreach($similar_services as $s_service)
                <div class="col-xl-2 col-sm-3 col-6" style="margin-bottom: 20px;">
                    <div class="product-single-hover">
                        <div class=" inline_product clickable d-flex justify-content-center"
                            style="cursor: pointer;background:#3b71de10;">
                            <div class="d-flex justify-content-end for-dicount-div-null">
                                <span class="for-discoutn-value-null"></span>
                            </div>
                            <div class="d-flex d-block" style="cursor: pointer;">
                                <a href="{{route('serviceView',[$s_service->id])}}">
                                    <img src="{{asset("storage/app/public/services/thumbnail/$s_service->thumbnail")}}"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        style="width: 100%;border-radius: 5px 5px 0px 0px;">
                                </a>
                            </div>
                        </div>
                        <div class="single-product-details"
                            style="position:relative;height:145px;padding-top:10px;border-radius: 0px 0px 5px 5px; ">
                            <div class="text-left pl-3">
                                <a href="{{route('serviceView',[$s_service->id])}}">
                                    {{$s_service->name}}
                                </a>
                            </div>
                            <div class="rating-show justify-content-between text-center">
                                <span class="d-inline-block font-size-sm text-body">
                                    <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                    <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                    <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                    <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                    <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                                    <label class="badge-style">( 0 )</label>
                                </span>
                            </div>
                            <div class="justify-content-between text-center">
                                <div class="product-price text-center">
                                    <span class="text-accent">
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="text-center quick-view">
                            <a class="btn btn-primary btn-sm" href="test-7-3spYrs.html">
                                <i class="czi-forward align-middle mr-1"></i>
                                {{ \App\CPU\translate('View') }}
                            </a>
                        </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade rtl" id="show-modal-view" tabindex="-1" role="dialog" aria-labelledby="show-modal-image"
         aria-hidden="true" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="display: flex;justify-content: center">
                    <button class="btn btn-default"
                            style="border-radius: 50%;margin-top: -25px;position: absolute;{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -7px;"
                            data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <img class="element-center" id="attachment-view" src="">
                </div>
            </div>
        </div>
    </div>

    <a class="btn-scroll-top" href="#top" data-scroll>
        <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">{{ \App\CPU\translate('Poor') }}Top</span><i
            class="btn-scroll-top-icon czi-arrow-up"> </i>
    </a>

@endsection

@push('script')
    <script>
        $( document ).ready(function() {
            load_review();
        });
        let load_review_count = 1;
        function load_review()
        {
            
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({
                    type: "post",
                    url: '{{route('review-list-service')}}',
                    data:{
                        type_id:{{$service->id}},
                        offset:load_review_count
                    },
                    success: function (data) {
                        $('#service-review-list').append(data.serviceReview)
                        if(data.not_empty == 0 && load_review_count>2){
                            toastr.info('{{\App\CPU\translate('no more review remain to load')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            console.log('iff');
                        }
                    }
                });
                load_review_count++
        }
    </script>
    <script>
        function productSearch(seller_id, category_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{url('/')}}/shopView/' + seller_id + '?category_id=' + category_id,

                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>

    <script>
        function openNav() {

            document.getElementById("mySidepanel").style.width = "50%";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>

    <script>
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{route('messages_store')}}',
                data: $('#chat-form').serialize(),
                success: function (respons) {

                    toastr.success('{{\App\CPU\translate('send successfully')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#chat-form').trigger('reset');
                }
            });

        });
    </script>
    <script type="text/javascript"
    src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons"
    async="async"></script>
@endpush
