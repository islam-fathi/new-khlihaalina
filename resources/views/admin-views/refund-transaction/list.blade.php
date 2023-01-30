@extends('layouts.back-end.app')

@section('content')
    <div class="content container-fluid ">
        <div class="col-md-4" style="margin-bottom: 20px;">
            <h3 class="text-capitalize">{{ \App\CPU\translate('refund_transaction_table')}}
                <span class="badge badge-soft-dark mx-2">{{$refund_transactions->total()}}</span>

            </h3>
        </div>
        {{-- <div class="row" style="margin-top: 20px"> --}}
        {{-- <div class="col-md-12"> --}}
        <div class="card">
            <div class="card-header">
                <div class="flex-between justify-content-between align-items-center flex-grow-1">
                    <div class="col-md-5 ">
                        <form action="{{ url()->current() }}" method="GET">
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                       placeholder="{{ \App\CPU\translate('Search by orders id _or_refund_id')}}" aria-label="Search orders"
                                       value="{{ $search }}"
                                       required>
                                <button type="submit" class="btn btn-primary">{{ \App\CPU\translate('search')}}</button>
                            </div>
                            <!-- End Search -->
                        </form>
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
                            <th>{{\App\CPU\translate('refund_id')}}</th>
                            <th>{{\App\CPU\translate('order_id')}}</th>
                            <th>{{ \App\CPU\translate('payment_method') }}</th>
                            <th>{{\App\CPU\translate('payment_status')}}</th>
                            <th>{{\App\CPU\translate('amount')}}</th>
                            <th>{{\App\CPU\translate('transaction_type')}}</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($refund_transactions as $key=>$refund_transaction)
                                <tr class="text-capitalize">
                                    <td>
                                        {{$refund_transactions->firstItem()+$key}}
                                    </td>
                                    <td>
                                        @if ($refund_transaction->refund_id)
                                        <a href="{{route('admin.business-settings.refund.details',['id'=>$refund_transaction['refund_id']])}}">
                                            {{$refund_transaction->refund_id}}
                                        </a>
                                        @else
                                            <span>{{\App\CPU\translate('not_found')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('admin.orders.details',['id'=>$refund_transaction->order_id])}}">
                                            {{$refund_transaction->order_id}}
                                        </a>
                                    </td>
                                    
                                    <td>
                                        {{str_replace('_',' ',$refund_transaction->payment_method)}}
                                    </td>
                                    <td>
                                        {{$refund_transaction->payment_status}}
                                    </td>
                                    <td>
                                        {{\App\CPU\Helpers::currency_converter($refund_transaction->amount)}}
                                    </td>
                                    <td>
                                        {{$refund_transaction->transaction_type}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($refund_transactions)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                 alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                {{$refund_transactions->links()}}
            </div>

        </div>
        {{-- </div> --}}

        {{-- </div> --}}
    </div>
@endsection
