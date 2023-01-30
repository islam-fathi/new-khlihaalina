@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Review List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CPU\translate('Review List')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="flex-between row justify-content-between flex-grow-1 mx-1">
                            <div class="col-12 col-sm-6">
                                <h5>{{\App\CPU\translate('Review')}} {{ \App\CPU\translate('Table') }}
                                <span style="color: red;">({{ $reviews->total() }})</span></h5>
                            </div>
                            <div class="col-12 col-sm-5">
                                <form action="{{ url()->current() }}" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\translate('Search by Product Name')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div> 
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive datatable-custom">
                            <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{\App\CPU\translate('SL#')}}</th>
                                    <th style="width: 30%">{{\App\CPU\translate('Product')}}</th>

                                    <th>{{\App\CPU\translate('Review')}}</th>
                                    <th>{{\App\CPU\translate('Rating')}}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($reviews as $key=>$review)
                                    @if($review->product)
                                        <tr>
                                            <td>{{$reviews->firstItem()+ $key}}</td>
                                            <td>
                                        <span class="d-block font-size-sm text-body">
                                            <a href="{{route('seller.product.view',[$review['product_id']])}}">
                                                {{$review->product?$review->product['name']:"Product removed"}}
                                            </a>
                                        </span>
                                            </td>

                                            <td>
                                                {{$review->comment?Str::limit($review->comment,130):"No Comment Found"}}
                                            </td>
                                            <td>
                                                <label class="badge badge-soft-info">
                                                    {{$review->rating}} <i class="tio-star"></i>
                                                </label>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- End Table -->
                    <!-- Footer -->
                     <div class="card-footer">
                        {{$reviews->links()}}
                    </div>
                    @if(count($reviews)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                    <!-- End Footer -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')

@endpush
