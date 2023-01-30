@extends('layouts.back-end.app')

@section('title',$seller->shop ? $seller->shop->name : \App\CPU\translate("shop name not found"))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@push('css_or_js')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #banner-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #banner-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }

        @media (max-width: 500px) {
            #banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }


        }


    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{route('admin.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Seller_details')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="flex-between d-sm-flex row align-items-center justify-content-between mb-2 mx-1">
            <div>
                <a href="{{route('admin.sellers.seller-list')}}"
                   class="btn btn-primary mt-3 mb-3">{{\App\CPU\translate('Back_to_seller_list')}}</a>
            </div>
            <div>
                @if ($seller->status=="pending")
                    <div class="mt-4 pr-2">
                        <div class="flex-start">
                            <div class="mx-1"><h4><i class="tio-shop-outlined"></i></h4></div>
                            <div>{{\App\CPU\translate('Seller_request_for_open_a_shop.')}}</div>
                        </div>
                        <div class="text-center">
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-primary">{{\App\CPU\translate('Approve')}}</button>
                            </form>
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger">{{\App\CPU\translate('reject')}}</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex-between row mx-1">
                <div>
                    <h1 class="page-header-title">{{ $seller->shop ? $seller->shop->name : "Shop Name : Update Please" }}</h1>
                </div>

            </div>
            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link "
                           href="{{ route('admin.sellers.view',$seller->id) }}">{{\App\CPU\translate('Shop')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'order']) }}">{{\App\CPU\translate('Order')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'product']) }}">{{\App\CPU\translate('Product')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'setting']) }}">{{\App\CPU\translate('Setting')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'transaction']) }}">{{\App\CPU\translate('Transaction')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'review']) }}">{{\App\CPU\translate('Review')}}</a>
                    </li>

                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->

        <div class="content container-fluid p-0">
            <div class="row" style="margin-top: 20px">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row d-flex justify-content-between align-items-center flex-grow-1">
                                <div class="col-md-3 col-12">
                                    <h3 class="text-capitalize">{{ \App\CPU\translate('transaction_table')}}
                                        <span class="badge badge-soft-dark mx-2">{{$transactions->total()}}</span>
    
                                    </h3>
                                </div>
                                <div class="col-md-4 col-12">
                                    <form action="{{ url()->current() }}" method="GET">
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="datatableSearch_" type="search" name="search"
                                                   class="form-control"
                                                   placeholder="{{\App\CPU\translate('Search by orders id or transaction id')}}"
                                                   aria-label="Search orders" value="{{ $search }}"
                                                   required>
                                            <button type="submit"
                                                    class="btn btn-primary">{{ \App\CPU\translate('search')}}</button>
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                </div>
                                <div class="col-md-4 col-12 mt-2 mt-md-0">
                                    <form action="{{ url()->current() }}" method="GET">
                                        <div class="row ">
    
                                            <div class="col-md-8">
    
                                                <select class="form-control" name="status">
    
                                                    <option class="text-center" value="0" selected disabled>
                                                        ---{{\App\CPU\translate('select_status')}}---
                                                    </option>
                                                    <option class="text-left text-capitalize"
                                                            value="all" {{ $status == 'all'? 'selected' : '' }} >{{\App\CPU\translate('all')}} </option>
                                                    <option class="text-left text-capitalize"
                                                            value="disburse" {{ $status == 'disburse'? 'selected' : '' }} >{{\App\CPU\translate('disburse')}} </option>
                                                    <option class="text-left text-capitalize"
                                                            value="hold" {{ $status == 'hold'? 'selected' : '' }}>{{\App\CPU\translate('hold')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mt-2 mt-md-0 ">
                                                <button type="submit"
                                                        class="btn btn-success float-right">{{\App\CPU\translate('filter')}}</button>
                                            </div>
    
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="card-body" style="padding: 0">
                            <div class="table-responsive">
                                <table id="datatable"
                                       style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                       style="width: 100%">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>{{\App\CPU\translate('SL#')}}</th>
                                        {{-- <th>{{\App\CPU\translate('seller')}}</th> --}}
                                        <th>{{\App\CPU\translate('seller_name')}}</th>
                                        <th>{{\App\CPU\translate('customer_name')}}</th>
                                        <th>{{\App\CPU\translate('order_id')}}</th>
                                        <th>{{\App\CPU\translate('transaction_id')}}</th>
                                        <th>{{\App\CPU\translate('order_amount')}}</th>
                                        <th>{{ \App\CPU\translate('seller_amount') }}</th>
                                        <th>{{\App\CPU\translate('admin_commission')}}</th>
                                        <th>{{\App\CPU\translate('received_by')}}</th>
                                        <th>{{\App\CPU\translate('delivered_by')}}</th>
                                        <th>{{\App\CPU\translate('delivery_charge')}}</th>
                                        <th>{{\App\CPU\translate('payment_method')}}</th>
                                        <th>{{\App\CPU\translate('tax')}}</th>
                                        <th>{{\App\CPU\translate('status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $key=>$transaction)
                                        <tr>
                                            <td>{{$transactions->firstItem()+$key}}</td>
                                            {{-- <td>{{$transaction['seller_id']}}</td> --}}
                                            <td>
                                                @if($transaction['seller_is'] == 'admin')

                                                    {{ App\Model\BusinessSetting::where(['type' => 'company_name'])->first()->value }}
                                                @else
                                                    {{ App\Model\Seller::find($transaction['seller_id'])->f_name }} {{ App\Model\Seller::find($transaction['seller_id'])->l_name }}
                                                @endif

                                            </td>
                                            <td>
                                                {{ App\User::find($transaction['customer_id'])->f_name??'' }} {{ App\User::find($transaction['customer_id'])->l_name??'' }}

                                            </td>
                                            <td>{{$transaction['order_id']}}</td>
                                            <td>{{$transaction['transaction_id']}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['order_amount']))}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['seller_amount']))}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['admin_commission']))}}</td>
                                            <td>{{$transaction['received_by']}}</td>
                                            <td>{{$transaction['delivered_by']}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['delivery_charge']))}}</td>
                                            <td>{{str_replace('_',' ',$transaction['payment_method'])}}</td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($transaction['tax']))}}</td>
                                            <td>
                                                @if($transaction['status'] == 'disburse')
                                                    <span class="badge badge-soft-success  ">

                                                    {{$transaction['status']}}
                                            </span>
                                                @else
                                                    <span class="badge badge-soft-warning ">
                                                {{$transaction['status']}}
                                            </span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(count($transactions)==0)
                                    <div class="text-center p-4">
                                        <img class="mb-3"
                                             src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                             alt="Image Description" style="width: 7rem;">
                                        <p class="mb-0">{{\App\CPU\translate('No_data_to_show')}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            {{$transactions->links()}}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
@push('script_2')
    <script>
        function status_filter(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.withdraw.status-filter')}}',
                data: {
                    withdraw_status_filter: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    location.reload();
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>
@endpush
