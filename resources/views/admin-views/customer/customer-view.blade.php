@extends('layouts.back-end.app')
{{-- @section('title', 'Customer') --}}
@section('title', \App\CPU\translate('Customer Details'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-print-none pb-2">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="{{ route('admin.customer.list') }}">
                                    {{ \App\CPU\translate('Customers') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ \App\CPU\translate('Customer details') }}</li>
                        </ol>
                    </nav>

                    <div class="d-sm-flex align-items-sm-center">
                        <h1 class="page-header-title">{{ \App\CPU\translate('Customer ID') }} #{{ $customer['id'] }}</h1>
                        <span class="{{ Session::get('direction') === 'rtl' ? 'mr-2 mr-sm-3' : 'ml-2 ml-sm-3' }}">
                            <i class="tio-date-range">
                            </i> {{ \App\CPU\translate('Joined At') }} :
                            {{ date('d M Y H:i:s', strtotime($customer['created_at'])) }}
                        </span>
                    </div>
                </div>


            </div>
        </div>
        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-title"></h5>
                        <form action="{{ url()->current() }}" method="GET">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="{{ \App\CPU\translate('Search orders') }}" aria-label="Search orders"
                                    value="{{ $search }}" required>
                                <button type="submit" class="btn btn-primary">{{ \App\CPU\translate('search') }}</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true
                               }'>
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ \App\CPU\translate('sl') }}#</th>
                                    <th style="width: 50%" class="text-center">{{ \App\CPU\translate('Order ID') }}</th>
                                    <th style="width: 50%">{{ \App\CPU\translate('Total') }}</th>
                                    <th style="width: 10%">{{ \App\CPU\translate('Action') }}</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $orders->firstItem() + $key }}</td>
                                        <td class="table-column-pl-0 text-center">
                                            <a
                                                href="{{ route('admin.orders.details', ['id' => $order['id']]) }}">{{ $order['id'] }}</a>
                                        </td>
                                        <td> {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order['order_amount'])) }}
                                        </td>

                                        <td>

                                            <a class="btn btn-primary btn-sm edit" title="{{ \App\CPU\translate('View') }}"
                                                href="{{ route('admin.orders.details', ['id' => $order['id']]) }}"><i
                                                    class="tio-visible"></i> </a>
                                            <a class="btn btn-info btn-sm" title="{{ \App\CPU\translate('Invoice') }}"
                                                target="_blank"
                                                href="{{ route('admin.orders.generate-invoice', [$order['id']]) }}"><i
                                                    class="tio-download"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (count($orders) == 0)
                            <div class="text-center p-4">
                                <img class="mb-3" src="{{ asset('public/assets/back-end') }}/svg/illustrations/sorry.svg"
                                    alt="Image Description" style="width: 7rem;">
                                <p class="mb-0">{{ \App\CPU\translate('No_data_to_show') }}</p>
                            </div>
                        @endif
                        <!-- Footer -->
                        <div class="card-footer">
                            <!-- Pagination -->
                            {!! $orders->links() !!}
                            <!-- End Pagination -->
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">{{ \App\CPU\translate('Customer') }}</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->


                    @if ($customer)
                        <div class="card-body">
                            <div class="media align-items-center" href="javascript:">
                                <div
                                    class="avatar avatar-circle {{ Session::get('direction') === 'rtl' ? 'ml-3' : 'mr-3' }}">
                                    <img class="avatar-img"
                                        onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                        src="{{ asset('storage/app/public/profile/' . $customer->image) }}"
                                        alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <span
                                        class="text-body text-hover-primary">{{ $customer['f_name'] . ' ' . $customer['l_name'] }}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{-- <i class="tio-chevron-right text-body"></i> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="media align-items-center" href="javascript:">
                                <div
                                    class="icon icon-soft-info icon-circle {{ Session::get('direction') === 'rtl' ? 'ml-3' : 'mr-3' }}">
                                    <i class="tio-shopping-basket-outlined"></i>
                                </div>
                                <div class="media-body">
                                    <span class="text-body text-hover-primary">
                                        {{ \App\Model\Order::where('customer_id', $customer['id'])->count() }}
                                        {{ \App\CPU\translate('orders') }}</span>
                                </div>
                                <div class="media-body text-right">
                                    {{-- <i class="tio-chevron-right text-body"></i> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ \App\CPU\translate('Contact info') }}</h5>
                            </div>

                            <ul class="list-unstyled list-unstyled-py-2">
                                <li>
                                    <i class="tio-online {{ Session::get('direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                                    {{ $customer['email'] }}
                                </li>
                                <li>
                                    <i
                                        class="tio-android-phone-vs {{ Session::get('direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                                    {{ $customer['phone'] }}
                                </li>
                            </ul>

                            <hr>


                            {{-- <div class="d-flex justify-content-between align-items-center">
                                <h5>{{\App\CPU\translate('shipping_address')}}</h5>

                            </div>


                            <span class="d-block">
                                @if (isset($order))
                                    {{\App\CPU\translate('Name')}} :
                                    <strong>{{$order->shippingAddress ? $order->shippingAddress['contact_person_name'] : "empty"}}</strong>
                                    <br>
                                    {{\App\CPU\translate('City')}}:
                                    <strong>{{$order->shipping ? $order->shipping['city'] : "Empty"}}</strong><br>
                                    {{\App\CPU\translate('zip_code')}} :
                                    <strong>{{$order->shipping ? $order->shipping['zip']  : "Empty"}}</strong><br>
                                    {{\App\CPU\translate('Phone')}}:
                                    <strong>{{$order->shipping ? $order->shipping['phone']  : "Empty"}}</strong>

                            </span>
                            @endif --}}

                        </div>
                    @endif

                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
@endpush
