@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\translate('Bank Info View'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('seller')}}</li>
                <li class="breadcrumb-item">{{\App\CPU\translate('my_bank_info')}}</li>
            </ol>
        </nav>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="card-header">
                        <h3 class="h3 mb-0  ">{{\App\CPU\translate('my_bank_info')}}  </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mt-4">
                            <div class="flex-start">
                                <h4>{{\App\CPU\translate('bank_name')}} : </h4>
                                <h4 class="mx-1">{{$data->bank_name ? $data->bank_name : 'No Data found'}}</h4>
                            </div>
                            <div class="flex-start">
                                <h6>{{\App\CPU\translate('Branch')}} : </h6>
                                <h6 class="mx-1">{{$data->branch ? $data->branch : 'No Data found'}}</h6>
                            </div>
                            <div class="flex-start">
                                <h6>{{\App\CPU\translate('holder_name')}} : </h6>
                                <h6 class="mx-1">{{$data->holder_name ? $data->holder_name : 'No Data found'}}</h6>
                            </div>
                            <div class="flex-start">
                                <h6>{{\App\CPU\translate('account_no')}} : </h6>
                                <h6 class="mx-1">{{$data->account_no ? $data->account_no : 'No Data found'}}</h6>
                            </div>

                            <a class="btn btn-primary"
                               href="{{route('seller.profile.bankInfo',[$data->id])}}">{{\App\CPU\translate('Edit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <!-- Page level plugins -->
@endpush
