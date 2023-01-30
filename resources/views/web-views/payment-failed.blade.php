@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Payment Incomplete'))

@push('css_or_js')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        body {
            font-family: 'Montserrat', sans-serif
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }

        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: {{$web_config['primary_color']}};
            font-weight: 700;

        }

        .spandHeadO {
            color: #030303;
            font-weight: 500;
            font-size: 20px;

        }

        .font-name {
            font-weight: 600;
            font-size: 13px;
        }

        .amount {
            font-size: 17px;
            color: {{$web_config['primary_color']}};
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class=" p-5">
                        <center>
                            <h3>{{\App\CPU\translate('Order payment is incomplete')}}.</h3>
                            <div class="justify-content-center mt-4 ">
                                <a href="{{route('home')}}" class="btn btn-primary"
                                   style="width:49%;">
                                    {{\App\CPU\translate('go_to_shopping')}}
                                </a>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
