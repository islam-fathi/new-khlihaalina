@extends('layouts.back-end.app')
@section('title', 'Pharmacies Orders List')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('Pharmacies') }}</li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('List') }}</li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5>{{ \App\CPU\translate('Orders table') }}
                                <span style="color: red; padding: 0 .4375rem;">
                                </span>
                            </h5>
                        </div>
                        <div style="width: 40vw">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>

                                    <select class="form-control" name="search" required>
                                        <option value="">--{{ \App\CPU\translate('Select Pharmacy') }}--</option>
                                        @foreach($pharmacies as $pharmacy)
                                            <option value="{{$pharmacy->id}}">{{$pharmacy->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="btn btn-primary">{{ \App\CPU\translate('search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ \App\CPU\translate('SL') }}</th>
                                        <th>{{ \App\CPU\translate('Pharmacy Name') }}</th>
                                        <th>{{ \App\CPU\translate('Request By') }}</th>
                                        <th>{{ \App\CPU\translate('Name') }}</th>
                                        <th>{{ \App\CPU\translate('Email') }}</th>
                                        <th>{{ \App\CPU\translate('Phone') }}</th>
                                        <th>{{ \App\CPU\translate('Message') }}</th>
                                        <th>{{ \App\CPU\translate('Prescription Image') }}</th>
                                        <th>{{ \App\CPU\translate('Order date') }}</th>
                                        <th>{{ \App\CPU\translate('Order Status') }}</th>
                                        <th style="width: 50px">{{ \App\CPU\translate('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $i= 1; 
                                        $l=1;
                                        $s=1; 
                                    @endphp
                                    @foreach($pharmacy_orders as $order)
                                        <tr class="">
                                            <td class="">{{$i++}}</td>
                                            <td class="table-column-pl-0"> 
                                                @isset($order->pharmacy['name'])
                                                    {{ $order->pharmacy['name'] }}
                                                @endisset()
                                                @empty($order->pharmacy['name'])
                                                    {{\App\CPU\translate('pharmacy not found')}}
                                                @endempty()
                                            </td>
                                            <td class="table-column-pl-0"> 
                                                @isset($order->customer['f_name'])
                                                    {{ $order->customer['f_name'] }} {{ $order->customer['l_name'] }}
                                                @endisset()
                                                @empty($order->customer['f_name'])
                                                    {{\App\CPU\translate('customer not found')}}
                                                @endempty()
                                            </td>
                                            <td>{{$order->name}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->phone}}</td>
                                            <td>{{$order->message}}</td>
                                            <td>
                                                <label class="">
                                                    <img class="rounded" style="width: 60px;height: 60px;"
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        src="{{asset('storage/app/public/pharmacies/prescription_image')}}/{{$order['prescription_image']}}">
                                                </label>
                                            </td>
                                            <td>{{$order->order_date}}</td>
                                            <td class="text-capitalize">
                                                @if ($order['order_status'] == 'pending')
                                                    <span class="badge badge-soft-info ml-2 ml-sm-3">
                                                        <span class="legend-indicator bg-info"
                                                            style="{{ Session::get('direction') === 'rtl' ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;' }}"></span>{{ \App\CPU\translate($order['order_status']) }}
                                                    </span>
                                                @elseif($order['order_status'] == 'confirmed')
                                                    <span class="badge badge-soft-success ml-2 ml-sm-3">
                                                        <span class="legend-indicator bg-success"
                                                            style="{{ Session::get('direction') === 'rtl' ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;' }}"></span>{{ \App\CPU\translate($order['order_status']) }}
                                                    </span>
                                                @elseif($order['order_status'] == 'canceled')
                                                    <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                                        <span class="legend-indicator bg-danger"
                                                            style="{{ Session::get('direction') === 'rtl' ? 'margin-right: 0;margin-left: .4375rem;' : 'margin-left: 0;margin-right: .4375rem;' }}"></span>{{ \App\CPU\translate($order['order_status']) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <div class="hs-unfold float-right col-6"> --}}
                                                    <div class="dropdown form-control">
                                                        <select name="order_status"
                                                            onchange="order_status_{{$l++}}(this.value)"
                                                            class="" data-id="{{ $order->id }}">
                                                            <option value="pending"
                                                                {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                                                {{ \App\CPU\translate('Pending') }}</option>
                                                            <option value="confirmed"
                                                                {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>
                                                                {{ \App\CPU\translate('Confirmed') }}</option>
                                                            <option value="canceled"
                                                                {{ $order->order_status == 'canceled' ? 'selected' : '' }}>
                                                                {{ \App\CPU\translate('Canceled') }} </option>
                                                        </select>
                                                    </div>
                                                {{-- </div> --}}
                                                <script>
                                                    function order_status_{{$s++}}(status) {
                                                        Swal.fire({
                                                            title: '{{ \App\CPU\translate('Are you sure Change this') }}?',
                                                            text: "{{ \App\CPU\translate('You will not be able to revert this') }}!",
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#377dff',
                                                            cancelButtonColor: 'secondary',
                                                            confirmButtonText: '{{ \App\CPU\translate('Yes, Change it') }}!'
                                                        }).then((result) => {
                                                            if (result.value) {
                                                                $.ajaxSetup({
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                                    }
                                                                });
                                                                $.ajax({
                                                                    url: "{{ route('admin.pharmacy.order-status') }}",
                                                                    method: 'POST',
                                                                    data: {
                                                                        "id": '{{ $order['id'] }}',
                                                                        "order_status": status
                                                                    },
                                                                    success: function(data) {
                                                                        if (data.success == 0) {
                                                                            toastr.success(
                                                                                '{{ \App\CPU\translate('Order is already delivered, You can not change it') }} !!'
                                                                                );
                                                                            location.reload();
                                                                        } else {
                                                                            toastr.success(
                                                                                '{{ \App\CPU\translate('Status Change successfully') }}!');
                                                                            location.reload();
                                                                        }

                                                                    }
                                                                });
                                                            }
                                                        })
                                                    }
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
