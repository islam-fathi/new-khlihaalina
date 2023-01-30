@extends('layouts.back-end.app')

@section('content')
    <div class="content container-fluid ">
        <div class="col-md-4" style="margin-bottom: 20px;">
            <h3 class="text-capitalize">{{ \App\CPU\translate('transaction_table')}}
                <span class="badge badge-soft-dark mx-2">{{$transactions->total()}}</span>

            </h3>
        </div>
        {{-- <div class="row" style="margin-top: 20px"> --}}
        {{-- <div class="col-md-12"> --}}
        <div class="card">
            <div class="card-header">
                <div class="row d-flex justify-content-between align-items-center flex-grow-1">
                    <div class="col-md-4 col-12">
                        <form action="{{ url()->current() }}" method="GET">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                       placeholder="Search by orders id or transaction id" aria-label="Search orders"
                                       value="{{ $search }}"
                                       required>
                                <button type="submit" class="btn btn-primary">{{ \App\CPU\translate('search')}}</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                    <div class="col-md-3 col-12 mt-3">
                        {{-- <div class="row float-right"> --}}
                            {{-- <div class="col-md-4"> --}}
                                <form action="{{ url()->current() }}" method="GET">
                                    {{-- <div class="row"> --}}
            
                                    <div class="row d-flex">
                                        <div class="ml-2">
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
                                        
                                        <div class="ml-2">
                                            <button type="submit" class="btn btn-success">{{\App\CPU\translate('filter')}}</button>
                                        </div>
                                    </div> 
            
                                        
                                </form>
                            {{-- </div> --}}
                            
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding: 0">
                <div class="table-responsive">
                    <table id="datatable"
                           style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                           class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
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
                                        {{ \App\CPU\Helpers::get_business_settings('company_name') }}
                                    @else
                                        @if (isset($transaction->seller))
                                        {{ $transaction->seller->f_name }} {{ $transaction->seller->l_name }}
                                        @else
                                        {{\App\CPU\translate('not_found')}}
                                        @endif
                                    @endif

                                </td>
                                <td>
                                    @if (isset($transaction->customer))
                                        {{ $transaction->customer->f_name}} {{ $transaction->customer->l_name }}
                                    @else
                                        {{\App\CPU\translate('not_found')}}
                                    @endif
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
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                 alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                {{$transactions->links()}}
            </div>

        </div>
        {{-- </div> --}}

        {{-- </div> --}}
    </div>
@endsection
