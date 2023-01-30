@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Order List'))

@push('css_or_js')
    <style>
        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px;

        }

        .tdBorder {
            border- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            text-align: center;
            vertical-align: middle !important;
        }

        .sidebar h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}                                   !important;
            transition: .2s ease-in-out;
        }

        tr td {
            padding: 10px 8px !important;
        }

        td button {
            padding: 3px 13px !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .orderDate {
                display: none;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 mt-2 sidebar_heading">
                <h1 class="h3  mb-0 p-3 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('my_order')}}</h1>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
        @include('web-views.partials._profile-aside')
        <!-- Content  -->
            <section class="col-lg-9 col-md-9">
                <div class="card box-shadow-sm">
                    <div style="overflow: auto">
                        <table class="table">
                            <thead>
                            <tr style="background-color: #6b6b6b;">
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO ">{{\App\CPU\translate('Order#')}}</span></div>
                                </td>

                                <td class="tdBorder orderDate">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO">{{\App\CPU\translate('Order')}} {{\App\CPU\translate('Date')}}</span>
                                    </div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\translate('Status')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\translate('Total')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO"> {{\App\CPU\translate('action')}}</span></div>
                                </td>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="bodytr font-weight-bold">
                                        {{\App\CPU\translate('ID')}}: {{$order['id']}}
                                    </td>
                                    <td class="bodytr orderDate"><span class="">{{$order['created_at']}}</span></td>
                                    <td class="bodytr">
                                        @if($order['order_status']=='failed' || $order['order_status']=='canceled')
                                            <span class="badge badge-danger text-capitalize">
                                                {{\App\CPU\translate($order['order_status'])}}
                                            </span>
                                        @elseif($order['order_status']=='confirmed' || $order['order_status']=='processing' || $order['order_status']=='delivered')
                                            <span class="badge badge-success text-capitalize">
                                                {{\App\CPU\translate($order['order_status'])}}
                                            </span>
                                        @else
                                            <span class="badge badge-info text-capitalize">
                                                {{\App\CPU\translate($order['order_status'])}}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="bodytr">
                                        {{\App\CPU\Helpers::currency_converter($order['order_amount'])}}
                                    </td>
                                    <td class="bodytr">
                                        <a href="{{ route('account-order-details', ['id'=>$order->id]) }}"
                                           class="btn btn-primary p-2">
                                            <i class="fa fa-eye"></i> {{\App\CPU\translate('view')}}
                                        </a>
                                        @if($order['payment_method']=='cash_on_delivery' && $order['order_status']=='pending')
                                            <a href="javascript:"
                                               onclick="route_alert('{{ route('order-cancel',[$order->id]) }}','{{\App\CPU\translate('want_to_cancel_this_order?')}}')"
                                               class="btn btn-danger p-2 top-margin">
                                                <i class="fa fa-trash"></i> {{\App\CPU\translate('cancel')}}
                                            </a>
                                        @else
                                            <button class="btn btn-danger p-2 top-margin" onclick="cancel_message()">
                                                <i class="fa fa-trash"></i> {{\App\CPU\translate('cancel')}}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($orders->count()==0)
                            <center class="mt-3 mb-2">{{\App\CPU\translate('no_order_found')}}</center>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function cancel_message() {
            toastr.info('{{\App\CPU\translate('order_can_be_canceled_only_when_pending.')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush
