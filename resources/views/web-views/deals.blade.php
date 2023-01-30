@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Flash Deal Products'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Deals of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Deals of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <style>
        .for-banner {
            margin-top: 5px;
        }
        .countdown-background{
            background: {{$web_config['primary_color']}};
            padding: 5px 5px;
            border-radius:5px;
            color: #ffffff !important;
        }
        .cz-countdown-days {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 8px 16px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */  
            flex: 1;
            
        }

        .cz-countdown-hours {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 8px 16px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */  
            flex: 1;
        }

        .cz-countdown-minutes {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 8px 16px;
            border-radius: 3px;
            margin-right: 0px !important;
            display: flex;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */  
            flex: 1;
        }
        .cz-countdown-seconds {
            color: white !important;
            background-color: #ffffff30;
            border: .5px solid{{$web_config['primary_color']}};
            padding: 8px 16px;
            border-radius: 3px;
            display: flex;
            justify-content: center;
	        flex-direction: column;
            -ms-flex: .4;  /* IE 10 */  
            flex: 1;

            
        }
        

        .flash_deal_title {
            font-weight: 700;
            font-size: 30px;

            text-transform: uppercase;
        }

        .cz-countdown {
            font-size: 18px;
        }

        
        .flex-center{
                display: flex;
                justify-content: space-between !important;
            }
       

        .flash_deal_product_details .flash-product-price {
            font-weight: 700;
            font-size: 25px;
            color: {{$web_config['primary_color']}};
        }

        .for-image {
            width: 100%;
            height: 200px;
        }
        

        @media (max-width: 600px) {
            .flash_deal_title {
                font-weight: 600;
                font-size: 26px;
            }

            .cz-countdown {
                font-size: 14px;
            }

            .for-image {

                height: 100px;
            }
        }

        @media (max-width: 768px) {
            .for-deal-tab {
                display: contents;
            }
            .flex-center{
                display: flex;
                justify-content: center !important;
            }
        }
        
    </style>
@endpush

@section('content')
    <div class="for-banner container rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">

        <img class="d-block for-image"
             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
             src="{{asset('storage/app/public/deal')}}/{{$deal['banner']}}"
             alt="Shop Converse">

    </div>
    <div class="container md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row flex-center">
            {{-- <section class="col-lg-12 for-deal-tab"> --}}
                @php($flash_deals=\App\Model\FlashDeal::with(['products.product.reviews'])->where(['status'=>1])->where(['deal_type'=>'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->first())
                <div class="{{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}">
                    <div class="row ">
                        <span class="flash_deal_title ">
                            {{ \App\CPU\translate('flash_deal')}}
                        </span>
                        
                    </div>
                </div>
                <div class=" {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}} ">
                    <div class="row d-inline-flex">
                        <div class="countdown-background ">
                            <span class="cz-countdown d-flex justify-content-center align-items-center"
                                data-countdown="{{isset($flash_deals)?date('m/d/Y',strtotime($flash_deals['end_date'])):''}} 11:59:00 PM">
                                <span class="cz-countdown-days align-items-center">
                                    <span class="cz-countdown-value"></span>
                                    <span>{{ \App\CPU\translate('day')}}</span>
                                </span>
                                <span class="cz-countdown-value p-1">:</span>
                                <span class="cz-countdown-hours align-items-center">
                                    <span class="cz-countdown-value"></span>
                                    <span>{{ \App\CPU\translate('hrs')}}</span>
                                </span>
                                <span class="cz-countdown-value p-1">:</span>
                                <span class="cz-countdown-minutes align-items-center">
                                    <span class="cz-countdown-value"></span>
                                    <span>{{ \App\CPU\translate('min')}}</span>
                                </span>
                                <span class="cz-countdown-value p-1">:</span>
                                <span class="cz-countdown-seconds align-items-center">
                                    <span class="cz-countdown-value"></span>
                                    <span>{{ \App\CPU\translate('sec')}}</span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            {{-- </section> --}}
        </div>
    </div>
    <!-- Toolbar-->

    <!-- Products grid-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <section class="col-lg-12">
                <div class="row mt-4">
                    @if($discountPrice)
                        @foreach($deal->products as $dp)
                            @if (isset($dp->product))
                                <div class="col-xl-2 col-sm-3 col-6" style="margin-bottom: 10px">
                                    
                                    @include('web-views.partials._single-product',['product'=>$dp->product])
                                    
                                    
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')

@endpush
