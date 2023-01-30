@extends('layouts.back-end.app-seller')

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-1">
        <div class="flex-between align-items-center">
            <div>
                <h1 class="page-header-title">{{\App\CPU\translate('refund_request_list')}} <span
                        class="badge badge-soft-dark mx-2">{{$refund_list->total()}}</span></h1>
            </div>
            <div>
                <i class="tio-shopping-cart" style="font-size: 30px"></i>
            </div>
        </div>
        <!-- End Row -->

        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
        <span class="hs-nav-scroller-arrow-prev" style="display: none;">
          <a class="hs-nav-scroller-arrow-link" href="javascript:;">
            <i class="tio-chevron-left"></i>
          </a>
        </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
          <a class="hs-nav-scroller-arrow-link" href="javascript:;">
            <i class="tio-chevron-right"></i>
          </a>
        </span>

            
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
    <!-- End Page Header -->

    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <div class="flex-between justify-content-between align-items-center flex-grow-1">
                <div class="col-12 col-md-6">
                    <form action="{{ url()->current() }}" method="GET">
                        <!-- Search -->
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                   placeholder="{{\App\CPU\translate('Search_by_order_id_or_refund_id')}}" aria-label="Search orders" value="{{ $search }}"
                                   required>
                            <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                   style="width: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                <thead class="thead-light">
                <tr>
                    <th class="">
                        {{\App\CPU\translate('SL')}}#
                    </th>
                    <th>
                        {{\App\CPU\translate('refund_id')}}
                    </th>
                    <th>{{\App\CPU\translate('order_id')}} </th>
                    <th>{{\App\CPU\translate('customer_name')}}</th>
                    <th>{{\App\CPU\translate('status')}}</th>
                    <th>{{\App\CPU\translate('amount')}}</th>
                    <th>{{\App\CPU\translate('product_name')}}</th>
                    <th>{{\App\CPU\translate('Action')}}</th>
                </tr>
                </thead>

                <tbody>
                @foreach($refund_list as $key=>$refund)
                    <tr>
                        <td>
                            {{$refund_list->firstItem()+$key}}
                        </td>
                        <td>
                            <a href="{{route('seller.refund.details',['id'=>$refund['id']])}}">
                                {{$refund->id}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('seller.orders.details',[$refund->order_id])}}">
                                {{$refund->order_id}}
                            </a>
                        </td>
                        <td>
                            {{-- <a href="{{route('seller.orders.details',[$refund->order_id])}}"> --}}
                                {{$refund->customer !=null?$refund->customer->f_name. ' '.$refund->customer->l_name:\App\CPU\translate('customer_not_found')}}
                            {{-- </a> --}}
                        </td>
                        <td>
                            {{$refund->status}}
                        </td>
                        <td>
                            {{\App\CPU\Helpers::currency_converter($refund->amount)}}
                        </td>
                        <td>
                            @if ($refund->product!=null)
                                <a href="{{route('admin.product.view',[$refund->product->id])}}">
                                    {{\Illuminate\Support\Str::limit($refund->product->name,35)}}
                                </a>
                            @else
                                {{\App\CPU\translate('product_name_not_found')}}
                            @endif
                        </td>
                        <td>
                            <a  class="btn btn-primary btn-sm mr-1"
                                title="{{\App\CPU\translate('view')}}"
                                href="{{route('seller.refund.details',['id'=>$refund['id']])}}">
                                <i class="tio-visible"></i>
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
            <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                <div class="col-sm-auto">
                    <div class="d-flex justify-content-center justify-content-sm-end">
                        <!-- Pagination -->
                        {!! $refund_list->links() !!}
                    </div>
                </div>
            </div>
            <!-- End Pagination -->
        </div>
        @if(count($refund_list)==0)
            <div class="text-center p-4">
                <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
            </div>
        @endif
        <!-- End Footer -->
    </div>
    <!-- End Card -->
</div>
@endsection

@push('script_2')
    
@endpush