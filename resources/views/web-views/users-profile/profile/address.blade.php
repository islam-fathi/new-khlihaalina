@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Home'))

@push('css_or_js')

@endpush

@section('content')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        .sidebar {
            max-width: 20rem;
        }


        .custom-control-label {
            cursor: pointer;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }


        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 13px;

        }

        .font-nameA {
            font-weight: 600;
            display: inline-block;
            margin-bottom: 0;
            font-size: 17px;
            color: #030303;
        }

        .spandHead {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 20px;
            margin-left: 25px;
        }

        .spandHeadO {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 14px;

        }

        /* .modal-header{
                border-top: 20px solid #4884ea;
                border-bottom: none;
        } */
        .font-name {
            font-weight: 600;
            font-size: 12px;
            color: #030303;
        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;


        }

        .btn-p {


            color: #fff;
            background-color: #1B7FED;
            border-color: #1B7FED;
            box-shadow: none;
        }

        .btn-p:hover {


            color: #fff;
            background-color: #1B7FED;
            border-color: #1B7FED;
            box-shadow: none;
        }

        .tdBorder {
            border-right: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            border: 1px solid #dadada;
        }

        .sellerName {
            font-size: 15px;
            font-weight: 600;
        }

        .modal-footer {
            border-top: none;
        }

        a {
            color: #030303;
            cursor: pointer;
        }

        a:hover {
            color: #4884ea;
            cursor: pointer;
        }

        .divider-role {
            border-bottom: 1px solid whitesmoke;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid #1b7fed !important;
            transition: .2s ease-in-out;
        }

        label {
            font-size: 15px;
            font-style: bold;
            margin-bottom: 8px;
            color: #030303;

        }

        .nav-pills .nav-link.active {
            box-shadow: none;
            color: #ffffff !important;
        }

        .modal-header {
            border-bottom: none;
        }

        .nav-pills .nav-link {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link :hover {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            color: #fff;
            background-color: #216fff;
        }

        .closeB {
            border: 1px solid #FFD5A4 !important;
            padding: 10px 30px 9px 30px;
            border-radius: 7px;
            color: #FFD5A4;
            background: white;
        }

        .modal-body {
            padding: none;
        }

        .sidebarL {
            padding: ;
        }

        .price_sidebar {
            padding: 20px;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: #1B7FED;
            }

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

            .btn-b {
                width: 350px;
                margin-right: 30px;
            }
        }

    </style>
    <!-- Page Title-->
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
                <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\translate('ADDRESSES')}}</h1>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3">
        <div class="row">
            <!-- Sidebar-->
            <div class="sidebarR col-lg-3">
                <!--Price Sidebar-->
                <div class="price_sidebar rounded-lg box-shadow-sm" id="shop-sidebar" style="margin-bottom: -10px;">
                    <div class="box-shadow-sm">

                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class="sidebarL">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a href="{{ route('orderList') }}"
                                                                                       style="color: #1B7FED">{{\App\CPU\translate('My Orders')}}</a>
                            </h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class="sidebarL ">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href="{{ route('wishList') }}"> {{\App\CPU\translate('Wish List')}} </a></h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class=" sidebarL">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href=""> {{\App\CPU\translate('Chat With Sellers')}} </a></h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class=" sidebarL">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href="{{ route('profile') }}"> {{\App\CPU\translate('Profile Info')}} </a></h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class=" sidebarL">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href="">{{\App\CPU\translate('Address')}} </a></h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class=" sidebarL">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href="{{ route('support-ticket') }}">{{\App\CPU\translate('Support ticket')}} </a>
                            </h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-0" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class="sidebarL ">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href="">{{\App\CPU\translate('Transaction history')}} </a></h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                    <div class="pb-1" style="padding-top: 12px;">
                        <!-- Filter by price-->
                        <div class="sidebarL ">
                            <h3 class="widget-title btnF" style="font-weight: 700;"><a
                                    href="">{{\App\CPU\translate('Payment method')}} </a></h3>
                            <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>

                        </div>
                    </div>
                </div>
            </div>

            <section class="col-lg-9 mt-3">
                <span style="color: #6A6A6A">{{\App\CPU\translate('No address found')}}.</span>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="row">
                                    <div class="col-md-12"><h5
                                            class="modal-title font-nameA ">{{\App\CPU\translate('Add a new address')}}</h5>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-body">
                                <form class="">

                                    <!-- Nav pills -->
                                    <ul class="nav nav-pills ml-3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active btn-p" data-toggle="pill"
                                               href="#home">{{\App\CPU\translate('Permanent')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill"
                                               href="#menu1">{{\App\CPU\translate('Home')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill"
                                               href="#menu2">{{\App\CPU\translate('Office')}}</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div id="home" class="container tab-pane active"><br>


                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label
                                                        for="firstName">{{\App\CPU\translate('Contact person name')}}</label>
                                                    <input type="text" class="form-control" id="firstName"
                                                           placeholder="">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastName">{{\App\CPU\translate('Floor,Suite')}}</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstName">{{\App\CPU\translate('City')}}</label>
                                                    <input type="text" class="form-control" id="firstName"
                                                           placeholder="">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastName">{{\App\CPU\translate('Zip code')}}</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstName">{{\App\CPU\translate('State')}}</label>
                                                    <input type="text" class="form-control" id="firstName"
                                                           placeholder="">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastName">{{\App\CPU\translate('Country')}}</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="firstName">{{\App\CPU\translate('Phone')}}</label>
                                                    <input type="text" class="form-control" id="firstName"
                                                           placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">

                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class=" closeB"
                                                    data-dismiss="modal">{{\App\CPU\translate('Close')}}</button>
                                            <button type="button"
                                                    class="btn btn-p"> {{\App\CPU\translate('Update Information')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-p btn-b float-right" data-toggle="modal" data-target="#exampleModal">
                {{\App\CPU\translate('Add New Address')}}
            </button>
        </div>
    </div>

@endsection

