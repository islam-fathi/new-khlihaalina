@extends('layouts.back-end.app')

@section('title',$seller->shop ? $seller->shop->name : \App\CPU\translate("shop name not found"))

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
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Seller_Details')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="flex-between d-sm-flex row align-items-center justify-content-between mb-2 mx-1">
            <div>
                <a href="{{route('admin.sellers.seller-list')}}" class="btn btn-primary mt-3 mb-3">{{\App\CPU\translate('Back_to_seller_list')}}</a>
            </div>
            <div>
                @if ($seller->status=="pending")
                    <div class="mt-4 pr-2 float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
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
                        <a class="nav-link " href="{{ route('admin.sellers.view',$seller->id) }}">{{\App\CPU\translate('Shop')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
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
                        <a class="nav-link"
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

        <!-- Page Heading -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="order">
                <div class="row pt-2">
                    <div class="col-md-12">
                        <div class="card w-100">
                            <div class="card-header">
                                {{\App\CPU\translate('Order')}} {{\App\CPU\translate('info')}} 
                            </div>
                            <!-- Card -->
                            @php($pending_order = App\Model\Order::where(['seller_is'=>'seller'])->where(['seller_id'=>$seller->id])->where('order_status','pending')->where('order_type','default_type')->get())
                            <div class="card-body mb-3 mb-lg-5">
                                <div class="row gx-lg-4">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="flex-between align-items-center" >
                                            <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                <h6 class="card-subtitle">{{\App\CPU\translate('pending')}}</h6>
                                                <span class="card-title h3">
                                                {{ $pending_order->count() }}  </span>
                                            </div>
                                            <div class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                                <i class="tio-airdrop"></i>
                                            </div>
                                        </div>
                                        <div class="d-lg-none">
                                            <hr>
                                        </div>
                                    </div>
                                    @php($delivered_order = App\Model\Order::where(['seller_is'=>'seller'])->where(['seller_id'=>$seller->id])->where('order_status','delivered')->where('order_type','default_type')->get())
                                    <div class="col-sm-6 col-lg-4 column-divider-sm">
                                        <div class="flex-between align-items-center" >
                                            <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                <h6 class="card-subtitle">{{\App\CPU\translate('delivered')}}</h6>
                                                <span class="card-title h3">
                                                    {{ $delivered_order->count() }}</span>
                                            </div>
                                            <div class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                                <i class="tio-checkmark-circle"></i>
                                            </div>
                                        </div>
                                        <div class="d-lg-none">
                                            <hr>
                                        </div>
                                    </div>
                                    @php($total_order = App\Model\Order::where(['seller_is'=>'seller'])->where(['seller_id'=>$seller->id])->where('order_type','default_type')->get())
                                    <div class="col-sm-6 col-lg-4 column-divider-sm">
                                        <div class="flex-between align-items-center" >
                                            <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                <h6 class="card-subtitle">{{\App\CPU\translate('All')}}</h6>
                                                <span class="card-title h3">{{ $total_order->count() }}</span>
                                            </div>
                                            <div class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                                                <i class="tio-table"></i>
                                            </div>
                                        </div>
                                        <div class="d-lg-none">
                                            <hr>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Table -->
                            <div class="table-responsive datatable-custom">
                                <table id="datatable"
                                       style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                       style="width: 100%"
                                       data-hs-datatables-options='{
                                "columnDefs": [{
                                    "targets": [0],
                                    "orderable": false
                                }],
                                "order": [],
                                "info": {
                                "totalQty": "#datatableWithPaginationInfoTotalQty"
                                },
                                "search": "#datatableSearch",
                                "entries": "#datatableEntries",
                                "pageLength": 25,
                                "isResponsive": false,
                                "isShowPaging": false,
                                "pagination": "datatablePagination"
                            }'>
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="">
                                            {{\App\CPU\translate('#SL')}}
                                        </th>
                                        <th class="table-column-pl-0">{{\App\CPU\translate('Order')}}</th>
                                        <th>{{\App\CPU\translate('Date')}}</th>
                                        <th>{{\App\CPU\translate('Customer')}}</th>
                                        <th>{{\App\CPU\translate('Payment')}} {{\App\CPU\translate('status')}}</th>
                                        <th>{{\App\CPU\translate('total')}}</th>
                                        <th>{{\App\CPU\translate('Order')}} {{\App\CPU\translate('status')}}</th>
                                        <th>{{\App\CPU\translate('action')}}</th>
                                    </tr>
                                    </thead>

                                    <tbody id="set-rows">

                                    @foreach($orders as $key=>$order)

                                        <tr class="status class-all">
                                            <td class="">
                                                {{$orders->firstItem()+$key}}
                                            </td>
                                            <td class="table-column-pl-0">
                                                <a href="{{route('admin.sellers.order-details',['order_id'=>$order['id'],'seller_id'=>$order['seller_id']])}}">{{$order['id']}}</a>
                                            </td>
                                            <td>{{date('d M Y',strtotime($order['created_at']))}}</td>
                                            <td>
                                                @if($order->customer)
                                                    <a class="text-body text-capitalize"
                                                       href="{{route('admin.customer.view',['user_id'=>$order->customer['id']])}}">
                                                        {{isset($order->customer)?$order->customer['f_name']:''}} {{isset($order->customer)?$order->customer['l_name']:''}}
                                                    </a>
                                                @else
                                                    <label class="badge badge-danger">{{\App\CPU\translate('Removed')}}</label>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->payment_status=='paid')
                                                    <span class="badge badge-soft-success">
                                                    <span class="legend-indicator bg-success"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{\App\CPU\translate('paid')}}
                                                    </span>
                                                @else
                                                    <span class="badge badge-soft-danger">
                                                <span class="legend-indicator bg-danger"
                                                      style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                </span>{{\App\CPU\translate('unpaid')}}
                                                </span>
                                                @endif
                                            </td>
                                            <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order['order_amount']))}}</td>
                                            <td class="text-capitalize">
                                                @if($order['order_status']=='pending')
                                                    <span class="badge badge-soft-info ml-2 ml-sm-3">
                                                    <span class="legend-indicator bg-info"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{\App\CPU\translate('pending')}}
                                                    </span>
                                                    @elseif($order['order_status']=='confirmed')
                                                        <span class="badge badge-soft-info ml-2 ml-sm-3">
                                                    <span class="legend-indicator bg-info"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{\App\CPU\translate('confirmed')}}
                                                    </span>
                                                    @elseif($order['order_status']=='processing')
                                                        <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                                    <span class="legend-indicator bg-warning"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{\App\CPU\translate('processing')}}
                                                    </span>
                                                    @elseif($order['order_status']=='out_for_delivery')
                                                        <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                                    <span class="legend-indicator bg-warning"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{\App\CPU\translate('out_for_delivery')}}
                                                    </span>
                                                    @elseif($order['order_status']=='delivered')
                                                        <span class="badge badge-soft-success ml-2 ml-sm-3">
                                                    <span class="legend-indicator bg-success"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{\App\CPU\translate('delivered')}}
                                                    </span>
                                                    @else
                                                        <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                                    <span class="legend-indicator bg-danger"
                                                          style="{{Session::get('direction') === "rtl" ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;'}}">
                                                    </span>{{str_replace('_',' ',$order['order_status'])}}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a  title="{{\App\CPU\translate('View')}}"
                                                    class="btn btn-info btn-sm"
                                                    href="{{route('admin.sellers.order-details',['order_id'=>$order['id'],'seller_id'=>$order['customer_id']])}}"><i
                                                        class="tio-visible"></i> 
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->

                            <!-- Footer -->
                            <div class="card-footer">
                                <!-- Pagination -->
                                <div
                                    class="row justify-content-center justify-content-sm-between align-items-sm-center">
                                    <div class="col-sm-auto">
                                        <div class="d-flex justify-content-center justify-content-sm-end">
                                            <!-- Pagination -->
                                            {!! $orders->links() !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- End Pagination -->
                            </div>
                            @if(count($orders)==0)
                                <div class="text-center p-4">
                                    <img class="mb-3"
                                         src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                         alt="Image Description" style="width: 7rem;">
                                    <p class="mb-0">{{\App\CPU\translate('No_data_to_show')}}</p>
                                </div>
                        @endif
                        <!-- End Footer -->
                            <!-- End Card -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
