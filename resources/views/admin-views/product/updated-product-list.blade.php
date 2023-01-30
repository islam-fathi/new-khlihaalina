@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('updated_product_list'))

@push('css_or_js')

@endpush

@section('content')

<div class="content container-fluid">  <!-- Page Heading -->
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex-between justify-content-between align-items-center flex-grow-1">
                        <div class="col-12 mb-1 col-md-4">
                            <h5 class="flex-between">
                                <div>{{\App\CPU\translate('product_table')}} ({{ $pro->total() }})</div>
                            </h5>
                        </div>
                        <div class="col-12 mb-1 col-md-3" style="width: 40vw">
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                           placeholder="{{\App\CPU\translate('Search Product Name')}}" aria-label="Search orders"
                                           value="{{ $search }}" required>
                                    <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                        
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CPU\translate('SL#')}}</th>
                                <th>{{\App\CPU\translate('Product Name')}}</th>
                                <th>{{\App\CPU\translate('previous_shipping_cost')}}</th>
                                <th>{{\App\CPU\translate('new_shipping_cost')}}</th>
                                <th style="width: 5px" class="text-center">{{\App\CPU\translate('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pro as $k=>$p)
                                <tr>
                                    <th scope="row">{{$pro->firstItem()+$k}}</th>
                                    <td>
                                        <a href="{{route('admin.product.view',[$p['id']])}}">
                                            {{\Illuminate\Support\Str::limit($p['name'],20)}}
                                        </a>
                                    </td>
                                    <td>
                                        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($p['shipping_cost']))}}
                                    </td>
                                    <td>
                                        {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($p['temp_shipping_cost']))}}
                                    </td>
                                    
                                    <td>
                                        <button class="btn btn-primary btn-sm"
                                         onclick="update_shipping_status({{$p['id']}},1)">
                                            {{\App\CPU\translate('approved')}}
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="update_shipping_status({{$p['id']}},0)">
                                            {{\App\CPU\translate('deneid')}}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$pro->links()}}
                </div>
                @if(count($pro)==0)
                    <div class="text-center p-4">
                        <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function update_shipping_status(product_id,status) {
        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.product.updated-shipping')}}",
                method: 'POST',
                data: {
                    product_id: product_id,
                    status:status
                },
                success: function (data) {
                    
                    toastr.success('{{\App\CPU\translate('status updated successfully')}}');
                    location.reload();
                }
            });
        }
</script>

@endpush