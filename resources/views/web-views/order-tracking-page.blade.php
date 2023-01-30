@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Track Order Result'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="{{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="{{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>
    <style>
        .order-track {
            height: 400px;
            border: 1px solid rgb(189, 187, 187);
            border-radius: 10px;
        }
       .closet{
            float: {{Session::get('direction') === "rtl" ? 'left' : 'right'}};
            font-size: 1.5rem;
            font-weight: 300;
            line-height: 1;
            color: #4b566b;
            text-shadow: none;
            opacity: .5;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3 col-lg-3"></div>
            <div class="col-md-7 col-lg-6">
                <div class="container py-4 mb-2 mb-md-3">

                    <div class="box-shadow-sm order-track">
                        <div style="margin: 0 auto; padding: 15px;">
                            <h1 style="padding: 20px; text-align: center;">{{\App\CPU\translate('track_order')}}</h1>

                            <form action="{{route('track-order.result')}}" type="submit" method="post"
                                  style="padding: 15px;">
                                @csrf

                                @if(session()->has('Error'))
                                    <div class="alert alert-danger alert-block">
                                        <span type="" class="closet " data-dismiss="alert">×</span>
                                        <strong>{{ session()->get('Error') }}</strong>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <input class="form-control prepended-form-control" type="text" name="order_id"
                                           placeholder="{{\App\CPU\translate('order_id')}}" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control prepended-form-control" type="text" name="phone_number"
                                           placeholder="{{\App\CPU\translate('your_phone_number')}}" required>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" name="trackOrder">{{\App\CPU\translate('track_order')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js">
    </script>
@endpush
