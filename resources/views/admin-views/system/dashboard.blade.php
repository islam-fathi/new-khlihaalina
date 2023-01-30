@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .grid-card {
            border: 2px solid #00000012;
            border-radius: 10px;
            padding: 10px;
        }

        .label_1 {
            /*position: absolute;*/
            font-size: 10px;
            background: #370665;
            color: #ffffff;
            width: 80px;
            padding: 2px;
            font-weight: bold;
            border-radius: 6px;
            text-align: center;
        }

        .center-div {
            text-align: center;
            border-radius: 6px;
            padding: 6px;
            border: 2px solid #EEEEEE;
        }

        .icon-card {
            background-color: #22577A;
            border-width: 30px;
            border-style: solid;
            border-color: red;
        }
    </style>
@endpush

@section('content')
    @if(auth('admin')->user()->admin_role_id==1 || \App\CPU\Helpers::module_permission_check('dashboard'))
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header" style="padding-bottom: 0!important;border-bottom: 0!important;margin-bottom: 1.25rem!important;">
                <div class="flex-between align-items-center">
                    <div>
                        <h1 class="page-header-title" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">{{\App\CPU\translate('Dashboard')}}</h1>
                        <p>{{ \App\CPU\translate('Welcome_message')}}.</p>
                    </div>
                    <div style="height: 25px">
                        <label class="badge badge-soft-success">
                            {{\App\CPU\translate('Software version')}} : {{ env('SOFTWARE_VERSION') }}
                        </label>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row flex-between gx-2 gx-lg-3 mb-2">
                        <div>
                            <h4><i style="font-size: 30px"
                                   class="tio-chart-bar-4"></i>{{\App\CPU\translate('dashboard_order_statistics')}}</h4>
                        </div>
                        <div class="col-12 col-md-4" style="width: 20vw">
                            <select class="custom-select" name="statistics_type"
                                    onchange="order_stats_update(this.value)">
                                <option
                                    value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                                    {{ \App\CPU\translate('Overall_statistics')}}
                                </option>
                                <option
                                    value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                                    {{ \App\CPU\translate("Todays Statistics")}}
                                </option>
                                <option
                                    value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                                    {{ \App\CPU\translate("This Months Statistics")}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-2 gx-lg-3" id="order_stats">
                        @include('admin-views.partials._dashboard-order-stats',['data'=>$data])
                    </div>
                </div>
            </div>

            <!-- End Stats -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="flex-between gx-2 gx-lg-3 mb-2">
                        <div>
                            <h4><i style="font-size: 30px"
                                   class="tio-chart-line-up"></i>{{\App\CPU\translate('admin_wallet')}}</h4>
                        </div>
                    </div>
                    <div class="row gx-2 gx-lg-3" id="order_stats">
                        @include('admin-views.partials._dashboard-wallet-stats',['data'=>$data])
                    </div>
                </div>
            </div>
            <!-- End Stats -->

            <div class="row gx-2 gx-lg-3">
                <div class="col-lg-12 mb-3 mb-lg-12">
                    <!-- Card -->
                    <div class="card h-100">
                        <!-- Body -->
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-12 mb-3 border-bottom">
                                    <h5 class="card-header-title float-left mb-2">
                                        <i style="font-size: 30px" class="tio-chart-pie-1"></i>
                                        {{\App\CPU\translate('earning_statistics_for_business_analytics')}}
                                    </h5>
                                    <!-- Legend Indicators -->
                                    <h5 class="card-header-title float-right mb-2">{{\App\CPU\translate('this_year_earning')}}
                                        <i style="font-size: 30px" class="tio-chart-bar-2"></i>
                                    </h5>
                                    <!-- End Legend Indicators -->
                                </div>
                                <div class="col-md-4 col-12 graph-border-1">
                                    <div class="mt-2 center-div">
                                    <span class="h6 mb-0">
                                        <i class="legend-indicator bg-primary"
                                           style="background-color: #FC9918!important;"></i>
                                        {{\App\CPU\translate('in-house_earning')}} : {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($inhouse_data)))}}
                                    </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 graph-border-1">
                                    <div class="mt-2 center-div">
                                      <span class="h6 mb-0">
                                          <i class="legend-indicator bg-success"
                                             style="background-color: #F14A16!important;"></i>
                                         {{\App\CPU\translate('seller_earnings')}} : {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($seller_data)))}}
                                    </span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12 graph-border-1">
                                    <div class="mt-2 center-div">
                                      <span class="h6 mb-0">
                                          <i class="legend-indicator bg-danger"
                                             style="background-color: #35589A!important;"></i>
                                        {{\App\CPU\translate('commission_earned')}} : {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency(array_sum($commission_data)))}}
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->

                            <!-- Bar Chart -->
                            <div class="chartjs-custom">
                                <canvas id="updatingData" style="height: 20rem;"
                                        data-hs-chartjs-options='{
                            "type": "bar",
                            "data": {
                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                              "datasets": [{
                                "data": [{{$inhouse_data[1]}},{{$inhouse_data[2]}},{{$inhouse_data[3]}},{{$inhouse_data[4]}},{{$inhouse_data[5]}},{{$inhouse_data[6]}},{{$inhouse_data[7]}},{{$inhouse_data[8]}},{{$inhouse_data[9]}},{{$inhouse_data[10]}},{{$inhouse_data[11]}},{{$inhouse_data[12]}}],
                                "backgroundColor": "#FC9918",
                                "hoverBackgroundColor": "#FC9918",
                                "borderColor": "#FC9918"
                              },
                              {
                                "data": [{{$seller_data[1]}},{{$seller_data[2]}},{{$seller_data[3]}},{{$seller_data[4]}},{{$seller_data[5]}},{{$seller_data[6]}},{{$seller_data[7]}},{{$seller_data[8]}},{{$seller_data[9]}},{{$seller_data[10]}},{{$seller_data[11]}},{{$seller_data[12]}}],
                                "backgroundColor": "#F14A16",
                                "borderColor": "#F14A16"
                              },
                              {
                                "data": [{{$commission_data[1]}},{{$commission_data[2]}},{{$commission_data[3]}},{{$commission_data[4]}},{{$commission_data[5]}},{{$commission_data[6]}},{{$commission_data[7]}},{{$commission_data[8]}},{{$commission_data[9]}},{{$commission_data[10]}},{{$commission_data[11]}},{{$commission_data[12]}}],
                                "backgroundColor": "#35589A",
                                "borderColor": "#35589A"
                              }]
                            },
                            "options": {
                              "scales": {
                                "yAxes": [{
                                  "gridLines": {
                                    "color": "#e7eaf3",
                                    "drawBorder": false,
                                    "zeroLineColor": "#e7eaf3"
                                  },
                                  "ticks": {
                                    "beginAtZero": true,
                                    "stepSize": 50000,
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 10,
                                    "postfix": " {{\App\CPU\BackEndHelper::currency_symbol()}}"
                                  }
                                }],
                                "xAxes": [{
                                  "gridLines": {
                                    "display": true,
                                    "drawBorder": true
                                  },
                                  "ticks": {
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 5
                                  },
                                  "categoryPercentage": 0.5,
                                  "maxBarThickness": "10"
                                }]
                              },
                              "cornerRadius": 2,
                              "tooltips": {
                                "prefix": " ",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false
                              },
                              "hover": {
                                "mode": "nearest",
                                "intersect": true
                              }
                            }
                          }'></canvas>
                            </div>
                            <!-- End Bar Chart -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>
            </div>

            <div class="row gx-2 gx-lg-3 mt-2">
                <div class="col-lg-6 mb-3">
                    <!-- Card -->
                    <div class="card h-100">
                        <!-- Header -->
                        <div class="card-header">
                            <h5 class="card-header-title">
                                <i class="tio-company"></i> {{\App\CPU\translate('total_business_overview')}}
                            </h5>
                            <i class="tio-chart-pie-1" style="font-size: 45px"></i>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
                        <div class="card-body" id="business-overview-board" style="direction: ltr">
                            <!-- Chart -->
                            <div class="chartjs-custom mx-auto">
                                <canvas id="business-overview" class="mt-2"></canvas>
                            </div>
                            <!-- End Chart -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-lg-6 mb-3">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._top-store-by-order',['top_store_by_order_received'=>$data['top_store_by_order_received']])
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-lg-6 mb-3">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._top-selling-store',['top_store_by_earning'=>$data['top_store_by_earning']])
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-lg-6 mb-3">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._top-selling-products',['top_sell'=>$data['top_sell']])
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-lg-6 mb-3">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']])
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-lg-6 mb-3">
                    <!-- Card -->
                    <div class="card h-100">
                        @include('admin-views.partials._top-customer',['top_customer'=>$data['top_customer']])
                    </div>
                    <!-- End Card -->
                </div>

            </div>
        </div>
    @else
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-12 mb-2 mb-sm-0">
                        <h3 class="text-center" style="color: gray">{{\App\CPU\translate('hi')}} {{auth('admin')->user()->name}}, {{\App\CPU\translate('welcome_to_dashboard')}}.</h3>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
        </div>
    @endif
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="{{asset('public/assets/back-end')}}/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
@endpush


@push('script_2')
    <script>
        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
    </script>

    <script>
        var ctx = document.getElementById('business-overview');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    '{{\App\CPU\translate('customer')}} ( {{$data['customer']}} )',
                    '{{\App\CPU\translate('store')}} ( {{$data['store']}} )',
                    '{{\App\CPU\translate('product')}} ( {{$data['product']}} )',
                    '{{\App\CPU\translate('order')}} ( {{$data['order']}} )',
                    '{{\App\CPU\translate('brand')}} ( {{$data['brand']}} )',
                ],
                datasets: [{
                    label: '{{\App\CPU\translate('business')}}',
                    data: ['{{$data['customer']}}', '{{$data['store']}}', '{{$data['product']}}', '{{$data['order']}}', '{{$data['brand']}}'],
                    backgroundColor: [
                        '#041562',
                        '#DA1212',
                        '#EEEEEE',
                        '#11468F',
                        '#000000',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard.order-stats')}}',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        function business_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.dashboard.business-overview')}}',
                data: {
                    business_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    console.log(data.view)
                    $('#business-overview-board').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }
    </script>

@endpush

