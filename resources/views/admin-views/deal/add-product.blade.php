@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Deal Product'))
@push('css_or_js')
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ \App\CPU\translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('flash_deal')}}</li>
            <li class="breadcrumb-item">{{ \App\CPU\translate('Add new product')}}</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0 text-black-50">{{$deal['title']}}</h1>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.deal.add-product',[$deal['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">{{ \App\CPU\translate('Add new product')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="product_id">
                                        @foreach (\App\Model\Product::active()->whereNotIn('id',$flash_deal_products)->orderBy('name', 'asc')->get() as $key => $product)
                                            
                                            <option value="{{ $product->id }}">
                                                {{$product['name']}}
                                            </option>
                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <button type="submit"
                                    class="btn btn-primary float-right">{{ \App\CPU\translate('add')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ \App\CPU\translate('Product')}} {{ \App\CPU\translate('Table')}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">{{ \App\CPU\translate('sl')}}</th>
                                <th scope="col">{{ \App\CPU\translate('name')}}</th>
                                <th scope="col">{{ \App\CPU\translate('price')}}</th>
                                {{--<th scope="col">{{ \App\CPU\translate('discount')}}</th>
                                <th scope="col">{{ \App\CPU\translate('discount_type')}}</th>--}}
                                <th scope="col" style="width: 50px">{{ \App\CPU\translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $k=>$de_p)
                                <tr>
                                    <th scope="row">{{$products->firstitem()+$k}}</th>
                                    <td>{{$de_p['name']}}</td>
                                    <td>{{\App\CPU\BackEndHelper::usd_to_currency($de_p['unit_price'])}}</td>
                                    {{--<td>{{$de_p->discount}}</td>
                                    <td>{{$de_p->discount_type}}</td>--}}
                                    <td>
                                        <a  title="{{ trans ('Delete')}}"
                                            class="btn btn-danger btn-sm delete"
                                            id="{{$de_p['id']}}">
                                            <i class="tio-add-to-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table>
                            <tfoot>
                                {!! $products->links() !!}
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.deal.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: "{{\App\CPU\translate('Are_you_sure_remove_this_product')}}?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\translate('Yes')}}, {{\App\CPU\translate('delete_it')}}!',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.deal.delete-product')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function (data) {
                            toastr.success('{{\App\CPU\translate('product_removed_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
