@extends('layouts.front-end.app')

@section('title',$product['name'])

@push('css_or_js')
    <meta name="description" content="{{$product->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @if($product->added_by=='seller')
        <meta name="author" content="{{ $product->seller->shop?$product->seller->shop->name:$product->seller->f_name}}">
    @elseif($product->added_by=='admin')
        <meta name="author" content="{{$web_config['name']->value}}">
    @endif
    <!-- Viewport-->

    @if($product['meta_image']!=null)
        <meta property="og:image" content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("storage/app/public/product/thumbnail")}}/{{$product->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/thumbnail/")}}/{{$product->thumbnail}}"/>
    @endif

    @if($product['meta_title']!=null)
        <meta property="og:title" content="{{$product->meta_title}}"/>
        <meta property="twitter:title" content="{{$product->meta_title}}"/>
    @else
        <meta property="og:title" content="{{$product->name}}"/>
        <meta property="twitter:title" content="{{$product->name}}"/>
    @endif
    <meta property="og:url" content="{{route('product',[$product->slug])}}">

    @if($product['meta_description']!=null)
        <meta property="twitter:description" content="{!! $product['meta_description'] !!}">
        <meta property="og:description" content="{!! $product['meta_description'] !!}">
    @else
        <meta property="og:description"
              content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
        <meta property="twitter:description"
              content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @endif
    <meta property="twitter:url" content="{{route('product',[$product->slug])}}">

    <link rel="stylesheet" href="{{asset('public/assets/front-end/css/product-details.css')}}"/>
    <style>
        .msg-option {
            display: none;
        }

        .chatInputBox {
            width: 100%;
        }

        .go-to-chatbox {
            width: 100%;
            text-align: center;
            padding: 5px 0px;
            display: none;
        }

        .feature_header {
            display: flex;
            justify-content: center;
        }

        .btn-number:hover {
            color: {{$web_config['secondary_color']}};

        }

        .for-total-price {
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: -30%;
        }

        .feature_header span {
            padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 15px;
            font-weight: 700;
            font-size: 25px;
            background-color: #ffffff;
            text-transform: uppercase;
        }

        .flash-deals-background-image{
            background: {{$web_config['primary_color']}}10;
            border-radius:5px;
            width:125px;
            height:125px;
        }

        @media (max-width: 768px) {
            .feature_header span {
                margin-bottom: -40px;
            }

            .for-total-price {
                padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 30%;
            }

            .product-quantity {
                padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 4%;
            }

            .for-margin-bnt-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 7px;
            }

            .font-for-tab {
                font-size: 11px !important;
            }

            .pro {
                font-size: 13px;
            }
        }

        @media (max-width: 375px) {
            .for-margin-bnt-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 3px;
            }

            .for-discount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

            .for-dicount-div {
                margin-top: -5%;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -7%;
            }

            .product-quantity {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 4%;
            }

        }

        @media (max-width: 500px) {
            .for-dicount-div {
                margin-top: -4%;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -5%;
            }

            .for-total-price {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: -20%;
            }

            .view-btn-div {

                margin-top: -9%;
                float: {{Session::get('direction') === "rtl" ? 'left' : 'right'}};
            }

            .for-discount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7%;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }

            .feature_header span {
                margin-bottom: -7px;
            }

            .for-mobile-capacity {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7%;
            }
        }
    </style>
    <style>
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }

        thead {
            background: {{$web_config['primary_color']}} !important;
            color: white;
        }
        .product-details-shipping-details{
            background: #ffffff; 
            border-radius: 5px;
            font-size: 14;
            font-weight: 400;
            color: #212629;
        }
        .shipping-details-bottom-border{
            border-bottom: 1px #F9F9F9 solid;
        }
    </style>
@endpush

@section('content')
    <?php
    $overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews); 
    $rating = \App\CPU\ProductManager::get_rating($product->reviews);
    ?>
    <!-- Page Content-->
    <div class="container mt-4 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <!-- General info tab-->
        <div class="row" style="direction: ltr">
            <!-- Product gallery-->
            <div class="col-md-9 col-12">
                <div class="row">
                    <div class="col-lg-5 col-md-4 col-12">
                        <div class="cz-product-gallery">
                            <div class="cz-preview">
                                @if($product->images!=null)
                                    @foreach (json_decode($product->images) as $key => $photo)
                                        <div
                                            class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                            id="image{{$key}}">
                                            <img class="cz-image-zoom img-responsive" style="width:100%;height:auto"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                src="{{asset("storage/app/public/product/$photo")}}"
                                                data-zoom="{{asset("storage/app/public/product/$photo")}}"
                                                alt="Product image" width="">
                                            <div class="cz-image-zoom-pane"></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="cz">
                                <div>
                                    <div class="row">
                                        <div class="table-responsive" data-simplebar style="max-height: 515px; padding: 1px;">
                                            <div class="d-flex" style="padding-left: 3px;">
                                                @if($product->images!=null)
                                                    @foreach (json_decode($product->images) as $key => $photo)
                                                        <div class="cz-thumblist">
                                                            <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center "
                                                            href="#image{{$key}}">
                                                                <img
                                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                    src="{{asset("storage/app/public/product/$photo")}}"
                                                                    alt="Product thumb">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product details-->
                    <div class="col-lg-7 col-md-8 col-12 mt-md-0 mt-sm-3" style="direction: {{ Session::get('direction') }}">
                        <div class="details">
                            <span class="mb-2" style="font-size: 22px;font-weight:700;">{{$product->name}}</span>
                            <div class="d-flex align-items-center mb-2 pro">
                                <span
                                    class="d-inline-block  align-middle mt-1 {{Session::get('direction') === "rtl" ? 'ml-md-2 ml-sm-0 pl-2' : 'mr-md-2 mr-sm-0 pr-2'}}"
                                    style="color: #FE961C">{{$overallRating[0]}}</span>
                                <div class="star-rating" style="{{Session::get('direction') === "rtl" ? 'margin-left: 25px;' : 'margin-right: 25px;'}}">
                                    @for($inc=0;$inc<5;$inc++)
                                        @if($inc<$overallRating[0])
                                            <i class="sr-star czi-star-filled active"></i>
                                        @else
                                            <i class="sr-star czi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span style="font-weight: 400;"
                                    class="font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{Session::get('direction') === "rtl" ? 'mr-1 ml-md-2 ml-1 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-1 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1'}}">{{$overallRating[1]}} {{\App\CPU\translate('Reviews')}}</span>
                                <span style="width: 0px;height: 10px;border: 0.5px solid #707070; margin-top: 6px;font-weight: 400 !important;"></span>
                                <span style="font-weight: 400;"
                                    class="font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{Session::get('direction') === "rtl" ? 'mr-1 ml-md-2 ml-1 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-1 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1'}}">{{$countOrder}} {{\App\CPU\translate('orders')}}   </span>
                                <span style="width: 0px;height: 10px;border: 0.5px solid #707070; margin-top: 6px;font-weight: 400;">    </span>
                                <span style="font-weight: 400;"
                                    class=" font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{Session::get('direction') === "rtl" ? 'mr-1 ml-md-2 ml-0 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-0 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1'}} text-capitalize">  {{$countWishlist}} {{\App\CPU\translate('wish_listed')}} </span>

                            </div>
                            <div class="mb-3">
                                @if($product->discount > 0)
                                    <strike style="color: #E96A6A;" class="{{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-3'}}">
                                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                    </strike>
                                @endif
                                <span
                                    class="h3 font-weight-normal text-accent ">
                                    {{\App\CPU\Helpers::get_price_range($product) }}
                                </span>
                                <span class="{{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                    style="font-size: 12px;font-weight:400">
                                    (<span>{{\App\CPU\translate('tax')}} : </span>
                                    <span id="set-tax-amount"></span>)
                                </span>
                            </div>

                            <form id="add-to-cart-form" class="mb-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="position-relative {{Session::get('direction') === "rtl" ? 'ml-n4' : 'mr-n4'}} mb-2">
                                    @if (count(json_decode($product->colors)) > 0)
                                        <div class="flex-start">
                                            <div class="product-description-label mt-2 text-body">{{\App\CPU\translate('color')}}:
                                            </div>
                                            <div>
                                                <ul class="list-inline checkbox-color mb-1 flex-start {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                                    style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;">
                                                    @foreach (json_decode($product->colors) as $key => $color)
                                                        <div>
                                                            <li>
                                                                <input type="radio"
                                                                    id="{{ $product->id }}-color-{{ $key }}"
                                                                    name="color" value="{{ $color }}"
                                                                    @if($key == 0) checked @endif>
                                                                <label style="background: {{ $color }};"
                                                                    for="{{ $product->id }}-color-{{ $key }}"
                                                                    data-toggle="tooltip"></label>
                                                            </li>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $qty = 0;
                                        if(!empty($product->variation)){
                                        foreach (json_decode($product->variation) as $key => $variation) {
                                                $qty += $variation->qty;
                                            }
                                        }
                                    @endphp
                                </div>
                                @foreach (json_decode($product->choice_options) as $key => $choice)
                                    <div class="row flex-start mx-0">
                                        <div
                                            class="product-description-label text-body mt-2 {{Session::get('direction') === "rtl" ? 'pl-2' : 'pr-2'}}">{{ $choice->title }}
                                            :
                                        </div>
                                        <div>
                                            <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2 mx-1 flex-start row"
                                                style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;">
                                                @foreach ($choice->options as $key => $option)
                                                    <div>
                                                        <li class="for-mobile-capacity">
                                                            <input type="radio"
                                                                id="{{ $choice->name }}-{{ $option }}"
                                                                name="{{ $choice->name }}" value="{{ $option }}"
                                                                @if($key == 0) checked @endif >
                                                            <label style="font-size: 12px;"
                                                                for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                                                        </li>
                                                    </div>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row no-gutters">
                                    <div>
                                        <div class="product-description-label text-body" style="margin-top: 10px;">{{\App\CPU\translate('Quantity')}}:</div>
                                    </div>
                                    <div >
                                        <div class="product-quantity d-flex justify-content-between align-items-center">
                                            <div
                                                class="d-flex justify-content-center align-items-center"
                                                style="width: 160px;color: {{$web_config['primary_color']}}">
                                                <span class="input-group-btn" style="">
                                                    <button class="btn btn-number" type="button"
                                                            data-type="minus" data-field="quantity"
                                                            disabled="disabled" style="padding: 10px;color: {{$web_config['primary_color']}}">
                                                        -
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity"
                                                    class="form-control input-number text-center cart-qty-field"
                                                    placeholder="1" value="1" min="1" max="100"
                                                    style="padding: 0px !important;width: 40%;height: 25px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="plus"
                                                            data-field="quantity" style="padding: 10px;color: {{$web_config['primary_color']}}">
                                                    +
                                                    </button>
                                                </span>
                                            </div>
                                            <div class="float-right"  id="chosen_price_div">
                                                <div class="d-flex justify-content-center align-items-center {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">
                                                    <div class="product-description-label"><strong>{{\App\CPU\translate('total_price')}}</strong> : </div>
                                                    <strong id="chosen_price"></strong>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row flex-start no-gutters d-none mt-2">
                                    

                                    <div class="col-12">
                                        @if($product['current_stock']<=0)
                                            <h5 class="mt-3 text-body" style="color: red">{{\App\CPU\translate('out_of_stock')}}</h5>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start mt-2 mb-3">
                                    <button
                                        class="btn element-center btn-gap-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                        onclick="buy_now()"
                                        type="button"
                                        style="width:37%; height: 45px; background: #FFA825 !important; color: #ffffff;">
                                        <span class="string-limit">{{\App\CPU\translate('buy_now')}}</span>
                                    </button>
                                    @php($shop = App\Model\Shop::where('seller_id' , $product->user_id )->first())
                                    @if(!empty($shop->working_from_time)  && !empty($shop->working_to_time))
                                        @php($destinationTimezone = new DateTimeZone('Africa/Cairo'))
                                        @php($now_time = now()->setTimeZone($destinationTimezone)->format('H:i'))
                                        {{-- @php($now_time = "15:00") --}}
                                        @if($now_time >= $shop->working_from_time)
                                            @if($shop->working_to_time <= $shop->working_from_time)
                                                @php($is_open = true)
                                            @else
                                                @if($now_time < $shop->working_to_time)
                                                    @php($is_open = true)
                                                @else
                                                    @php($is_open = false)
                                                @endif
                                            @endif
                                        @else
                                            @if($shop->working_to_time > $shop->working_from_time)
                                                @php($is_open = false)
                                            @else
                                                @if($now_time >= $shop->working_to_time)
                                                    @php($is_open = false)
                                                @else
                                                    @php($is_open = true)
                                                @endif
                                            @endif
                                        @endif
                                        
                                        @if($is_open == true)
                                            <span>{{ \App\CPU\translate('Open') }}</span>
                                        @else
                                            <span>{{ \App\CPU\translate('Close') }}</span>
                                        @endif
                                    @endif
                                    <button
                                        class="btn btn-primary element-center btn-gap-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                        onclick="addToCart()"
                                        type="button"
                                        style="width:37%; height: 45px;{{Session::get('direction') === "rtl" ? 'margin-right: 20px;' : 'margin-left: 20px;'}}">
                                        <span class="string-limit">{{\App\CPU\translate('add_to_cart')}}</span>
                                    </button>
                                    <button type="button" onclick="addWishlist('{{$product['id']}}')"
                                            class="btn for-hover-bg"
                                            style="color:{{$web_config['secondary_color']}};font-size: 18px;">
                                        <i class="fa fa-heart-o "
                                        aria-hidden="true"></i>
                                        <span class="countWishlist-{{$product['id']}}">{{$countWishlist}}</span>
                                    </button>
                                </div>
                            </form>
                            
                            <div style="text-align:{{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                class="sharethis-inline-share-buttons"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mt-4 rtl col-12" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <div class="row" >
                            <div class="col-12">
                                <div class=" mt-1">
                                    <!-- Tabs-->
                                    <ul class="nav nav-tabs d-flex justify-content-center" role="tablist" style="margin-top:35px;">
                                        <li class="nav-item">
                                            <a class="nav-link active " href="#overview" data-toggle="tab" role="tab"
                                            style="color: black !important;font-weight: 400;font-size: 24px;">
                                                {{\App\CPU\translate('overview')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#reviews" data-toggle="tab" role="tab"
                                            style="color: black !important;font-weight: 400;font-size: 24px;">
                                                {{\App\CPU\translate('reviews')}}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="px-4 pt-lg-3 pb-3 mb-3 mr-0 mr-md-2" style="background: #ffffff;border-radius:10px;min-height: 817px;">
                                        <div class="tab-content px-lg-3">
                                            <!-- Tech specs tab-->
                                            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                                                <div class="row pt-2 specification">
                                                    @if($product->video_url!=null)
                                                        <div class="col-12 mb-4">
                                                            <iframe width="420" height="315"
                                                                    src="{{$product->video_url}}">
                                                            </iframe>
                                                        </div>
                                                    @endif

                                                    <div class="text-body col-lg-12 col-md-12" style="overflow: scroll;">
                                                        {!! $product['details'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @php($reviews_of_product = App\Model\Review::where('product_id',$product->id)->paginate(2))
                                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                                <div class="row pt-2 pb-3">
                                                    <div class="col-lg-4 col-md-5 ">
                                                        <div class=" row d-flex justify-content-center align-items-center">
                                                            <div class="col-12 d-flex justify-content-center align-items-center">
                                                                <h2 class="overall_review mb-2" style="font-weight: 500;font-size: 50px;">
                                                                    {{$overallRating[1]}} 
                                                                </h2>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-center align-items-center star-rating ">
                                                                @if (round($overallRating[0])==5)
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                                @if (round($overallRating[0])==4)
                                                                    @for ($i = 0; $i < 4; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    <i class="czi-star font-size-sm text-muted {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                @endif
                                                                @if (round($overallRating[0])==3)
                                                                    @for ($i = 0; $i < 3; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    @for ($j = 0; $j < 2; $j++)
                                                                        <i class="czi-star font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                                @if (round($overallRating[0])==2)
                                                                    @for ($i = 0; $i < 2; $i++)
                                                                        <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    @for ($j = 0; $j < 3; $j++)
                                                                        <i class="czi-star font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                                @if (round($overallRating[0])==1)
                                                                    @for ($i = 0; $i < 4; $i++)
                                                                        <i class="czi-star font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                    <i class="czi-star-filled font-size-sm text-accent {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                @endif
                                                                @if (round($overallRating[0])==0)
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i class="czi-star font-size-sm text-muted {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                                                                    @endfor
                                                                @endif
                                                            </div>
                                                            <div class="col-12 d-flex justify-content-center align-items-center mt-2">
                                                                <span class="text-center">
                                                                    {{$reviews_of_product->total()}} {{\App\CPU\translate('ratings')}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-7 pt-sm-3 pt-md-0" >
                                                        <div class="row d-flex align-items-center mb-2 font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap "><span
                                                                    class="d-inline-block align-middle text-body">{{\App\CPU\translate('Excellent')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress text-body" style="height: 5px;">
                                                                    <div class="progress-bar " role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[0] != 0) ? ($rating[0] / $overallRating[1]) * 100 : (0); ?>%;"
                                                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1 text-body">
                                                                <span
                                                                    class=" {{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}} ">
                                                                    {{$rating[0]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap "><span
                                                                    class="d-inline-block align-middle ">{{\App\CPU\translate('Good')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[1] != 0) ? ($rating[1] / $overallRating[1]) * 100 : (0); ?>%; background-color: #a7e453;"
                                                                        aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                        {{$rating[1]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap"><span
                                                                    class="d-inline-block align-middle ">{{\App\CPU\translate('Average')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[2] != 0) ? ($rating[2] / $overallRating[1]) * 100 : (0); ?>%; background-color: #ffda75;"
                                                                        aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                    {{$rating[2]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center mb-2 text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap "><span
                                                                    class="d-inline-block align-middle">{{\App\CPU\translate('Below Average')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;width: <?php echo $widthRating = ($rating[3] != 0) ? ($rating[3] / $overallRating[1]) * 100 : (0); ?>%; background-color: #fea569;"
                                                                        aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                        class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                    {{$rating[3]}}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex align-items-center text-body font-size-sm">
                                                            <div
                                                                class="col-3 text-nowrap"><span
                                                                    class="d-inline-block align-middle ">{{\App\CPU\translate('Poor')}}</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="progress" style="height: 5px;">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="background-color: {{$web_config['primary_color']}} !important;backbround-color:{{$web_config['primary_color']}};width: <?php echo $widthRating = ($rating[4] != 0) ? ($rating[4] / $overallRating[1]) * 100 : (0); ?>%;"
                                                                        aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'mr-3 float-left' : 'ml-3 float-right'}}">
                                                                        {{$rating[4]}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-4 mb-3">
                                                    <div style="display: block;width:100%;text-align: center;background: #F3F4F5;border-radius: 5px;padding:5px;">
                                                        <span class="text-capitalize">{{\App\CPU\translate('Product Review')}}</span>
                                                    </div>
                                                </div>
                                                <div class="row pb-4">
                                                    <div class="col-12" id="product-review-list">
                                                        {{-- @foreach($reviews_of_product as $productReview)
                                                            @include('web-views.partials.product-reviews',['productRevie'=>$productRevie])
                                                        @endforeach --}}
                                                        @if(count($product->reviews)==0)
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h6 class="text-danger text-center">{{\App\CPU\translate('product_review_not_available')}}</h6>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card-footer d-flex justify-content-center align-items-center">
                                                            <button class="btn" style="background: {{$web_config['primary_color']}}; color: #ffffff" onclick="load_review()">{{\App\CPU\translate('view more')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-3 ">
                <div class="product-details-shipping-details">
                    <div class="shipping-details-bottom-border">
                        <div style="padding: 25px;">
                            <img class="{{Session::get('direction') === "rtl" ? 'float-right ml-2' : 'mr-2'}}" style="height: 20px;width:20px;" src="{{asset("public/assets/front-end/png/Payment.png")}}"
                                    alt="">
                            <span>{{\App\CPU\translate('Safe Payment')}}</span>
                        </div>
                    </div>
                    <div  class="shipping-details-bottom-border">
                        <div style="padding: 25px;">
                            <img class="{{Session::get('direction') === "rtl" ? 'float-right ml-2' : 'mr-2'}}" style="height: 20px;width:20px;" 
                                src="{{asset("public/assets/front-end/png/money.png")}}"
                                    alt="">
                            <span>{{ \App\CPU\translate('7 Days Return Policy')}}</span>
                        </div>
                    </div>
                    <div class="shipping-details-bottom-border">
                       <div style="padding: 25px;">
                            <img class="{{Session::get('direction') === "rtl" ? 'float-right ml-2' : 'mr-2'}}" 
                                style="height: 20px;width:20px;" 
                                src="{{asset("public/assets/front-end/png/Genuine.png")}}"
                                alt="">
                            <span>{{ \App\CPU\translate('100% Authentic Products')}}</span>
                       </div>
                    </div>
                </div>
                <div style="background: #ffffff; padding: 25px;border-radius: 5px;
                    font-weight: 400;color: #212629;margin-top: 10px;">
                    {{--seller section--}}
                    @if($product->added_by=='seller')
                        @if(isset($product->seller->shop))
                            <div class="row d-flex justify-content-between">
                                <div class="col-8">
                                    <div class="row d-flex ">
                                        <div>
                                            <img style="height: 65px; width: 65px; border-radius: 50%"
                                                src="{{asset('storage/app/public/shop')}}/{{$product->seller->shop->image}}"
                                                onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                alt="">
                                        </div>
                                        <div class="{{Session::get('direction') === "rtl" ? 'right' : 'ml-3'}}">
                                            <span style="font-weight: 700;font-size: 16px;">
                                                {{$product->seller->shop->name}}
                                            </span><br>
                                            <span>{{\App\CPU\translate('Seller_info')}}</span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-4">
                                    @if (auth('customer')->id() == '')
                                    <a href="{{route('customer.auth.login')}}">
                                        <div class="float-left" style="color:{{$web_config['primary_color']}};background: {{$web_config['primary_color']}}10;padding: 6px 15px 6px 15px;font-size:12px;">
                                            <i class="fa fa-envelope"></i>
                                        <span>{{\App\CPU\translate('chat')}}</span>
                                        </div>
                                        </a>
                                    @else
                                        <div id="contact-seller" style="color:{{$web_config['primary_color']}};background: {{$web_config['primary_color']}}10;padding: 6px 15px 6px 15px;font-size:12px;">
                                                <i class="fa fa-envelope"></i>
                                            <span>{{\App\CPU\translate('chat')}}</span>
                                            </div>
                                    @endif

                                </div>
                                <div class="col-12 msg-option mt-2" id="msg-option">
                                    
                                        <form action="">
                                        <input type="text" class="seller_id" hidden seller-id="{{$product->seller->id }}">
                                        <textarea shop-id="{{$product->seller->shop->id}}" class="chatInputBox"
                                                id="chatInputBox" rows="5"> </textarea>

                                        
                                        <div class="row">
                                            <button class="btn btn-secondary" style="color: white;display: block;width: 47%;margin: 3px;"
                                                id="cancelBtn">{{\App\CPU\translate('cancel')}}
                                            </button>
                                            <button class="btn btn-success " style="color: white;display: block;width: 47%;margin: 3px;"
                                                id="sendBtn">{{\App\CPU\translate('send')}}</button>
                                        </div>
                                        
                                    </form>
                                    
                                </div>
                            
                                @php($products_for_review = App\Model\Product::where('added_by',$product->added_by)->where('user_id',$product->user_id)->withCount('reviews')->get())
                                
                                <?php
                                $total_reviews = 0;
                                    foreach ($products_for_review as $item)
                                       { $total_reviews += $item->reviews_count;
                                       }
                                ?>
                                <div class="col-12 mt-2">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-6 ">
                                            <div class="d-flex justify-content-center align-items-center" style="height: 79px;background:{{$web_config['primary_color']}}10;border-radius:5px;">
                                                <div class="text-center">
                                                    <span style="color: {{$web_config['primary_color']}};font-weight: 700;
                                                    font-size: 26px;">
                                                    {{$total_reviews}}
                                                    </span><br>
                                                    <span style="font-size: 12px;">
                                                        {{\App\CPU\translate('reviews')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex justify-content-center align-items-center" style="height: 79px;background:{{$web_config['primary_color']}}10;border-radius:5px;">
                                                <div class="text-center">
                                                    <span style="color: {{$web_config['primary_color']}};font-weight: 700;
                                                    font-size: 26px;">
                                                        {{$products_for_review->count()}}   
                                                    </span><br>
                                                    <span style="font-size: 12px;">
                                                        {{\App\CPU\translate('products')}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div>
                                        <a href="{{ route('shopView',[$product->seller->id]) }}" style="display: block;width:100%;text-align: center">
                                            <button class="btn" style="display: block;width:100%;text-align: center;background: {{$web_config['primary_color']}};color:#ffffff">
                                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                                {{\App\CPU\translate('Visit Store')}}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row d-flex justify-content-between">
                            <div class="col-9 ">
                                <div class="row d-flex ">
                                    <div>
                                        <img style="height: 65px; width: 65px; border-radius: 50%"
                                            src="{{asset("storage/app/public/company")}}/{{$web_config['fav_icon']->value}}"
                                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                            alt="">
                                    </div>
                                    <div class="{{Session::get('direction') === "rtl" ? 'right' : 'ml-3'}}">
                                        <span style="font-weight: 700;font-size: 16px;">
                                            {{$web_config['name']->value}}
                                        </span><br>
                                    </div>
                                </div>
                                
                            </div>
                            
                            @php($products_for_review = App\Model\Product::where('added_by','admin')->where('user_id',$product->user_id)->withCount('reviews')->get())
                                
                            <?php
                            $total_reviews = 0;
                                foreach ($products_for_review as $item)
                                   { $total_reviews += $item->reviews_count;
                                   }
                            ?>   
                            <div class="col-12 mt-2">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-6 ">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 79px;background:{{$web_config['primary_color']}}10;border-radius:5px;">
                                            <div class="text-center">
                                                <span style="color: {{$web_config['primary_color']}};font-weight: 700;
                                                font-size: 26px;">
                                                    {{$total_reviews}}   
                                                </span><br>
                                                <span style="font-size: 12px;">
                                                    {{\App\CPU\translate('reviews')}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 79px;background:{{$web_config['primary_color']}}10;border-radius:5px;">
                                            <div class="text-center">
                                                <span style="color: {{$web_config['primary_color']}};font-weight: 700;
                                                font-size: 26px;">
                                                    {{$products_for_review->count()}}   
                                                </span><br>
                                                <span style="font-size: 12px;">
                                                    {{\App\CPU\translate('products')}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <a href="{{ route('shopView',[0]) }}" style="display: block;width:100%;text-align: center">
                                    <button class="btn" style="display: block;width:100%;text-align: center;background: {{$web_config['primary_color']}};color:#ffffff">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        {{\App\CPU\translate('Visit Store')}}
                                    </button>
                                </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @php($more_product_from_seller = App\Model\Product::where('added_by',$product->added_by)->where('user_id',$product->user_id)->latest()->take(5)->get())
                <div style="padding: 25px;">
                    <div class="row d-flex justify-content-center">
                        <span style="text-align: center;font-weight: 700;
                        font-size: 16px;">
                            {{ \App\CPU\translate('More From The Store')}}
                        </span>
                    </div>
                </div>
                <div style="">
                   
                    @foreach($more_product_from_seller as $item)
                        
                            @include('web-views.partials.seller-products-product-details',['product'=>$item])
                        
                    @endforeach
                    
                </div>
            </div>
            

        </div>
    </div>

    <!-- Product carousel (You may also like)-->
    <div class="container  mb-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row flex-between">
            <div class="text-capitalize" style="font-weight: 700; font-size: 30px;{{Session::get('direction') === "rtl" ? 'margin-right: 5px;' : 'margin-left: 5px;'}}">
                <span>{{ \App\CPU\translate('similar_products')}}</span>
            </div>

            <div class="view_all d-flex justify-content-center align-items-center">
                <div>
                    @php($category=json_decode($product['category_ids']))
                    <a class="text-capitalize view-all-text" style="color:{{$web_config['primary_color']}} !important;{{Session::get('direction') === "rtl" ? 'margin-left:10px;' : 'margin-right: 8px;'}}"
                       href="{{route('products',['id'=> $category[0]->id,'data_from'=>'category','page'=>1])}}">{{ \App\CPU\translate('view_all')}}
                       <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left-circle mr-1 ml-n1 mt-1 ' : 'right-circle ml-1 mr-n1'}}"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Grid-->
        
        <!-- Product-->
        <div class="row mt-4">
            @if (count($relatedProducts)>0)
                @foreach($relatedProducts as $key => $relatedProduct)
                    <div class="col-xl-2 col-sm-3 col-6" style="margin-bottom: 20px;">
                        @include('web-views.partials._single-product',['product'=>$relatedProduct])
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-danger text-center">{{\App\CPU\translate('similar')}} {{\App\CPU\translate('product_not_available')}}</h6>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade rtl" id="show-modal-view" tabindex="-1" role="dialog" aria-labelledby="show-modal-image"
         aria-hidden="true" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="display: flex;justify-content: center">
                    <button class="btn btn-default"
                            style="border-radius: 50%;margin-top: -25px;position: absolute;{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -7px;"
                            data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <img class="element-center" id="attachment-view" src="">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script type="text/javascript">
        cartQuantityInitialize();
        getVariantPrice();
        $('#add-to-cart-form input').on('change', function () {
            getVariantPrice();
        });

        function showInstaImage(link) {
            $("#attachment-view").attr("src", link);
            $('#show-modal-view').modal('toggle')
        }
    </script>
    <script>
        $( document ).ready(function() {
            load_review();
        });
        let load_review_count = 1;
        function load_review()
        {
            
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({
                    type: "post",
                    url: '{{route('review-list-product')}}',
                    data:{
                        product_id:{{$product->id}},
                        offset:load_review_count
                    },
                    success: function (data) {
                        $('#product-review-list').append(data.productReview)
                        if(data.not_empty == 0 && load_review_count>2){
                            toastr.info('{{\App\CPU\translate('no more review remain to load')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            console.log('iff');
                        }
                    }
                });
                load_review_count++
        }
    </script>
    
    {{-- Messaging with shop seller --}}
    <script>
        $('#contact-seller').on('click', function (e) {
            // $('#seller_details').css('height', '200px');
            $('#seller_details').animate({'height': '276px'});
            $('#msg-option').css('display', 'block');
        });
        $('#sendBtn').on('click', function (e) {
            e.preventDefault();
            let msgValue = $('#msg-option').find('textarea').val();
            let data = {
                message: msgValue,
                shop_id: $('#msg-option').find('textarea').attr('shop-id'),
                seller_id: $('.msg-option').find('.seller_id').attr('seller-id'),
            }
            if (msgValue != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: '{{route('messages_store')}}',
                    data: data,
                    success: function (respons) {
                        console.log('send successfully');
                    }
                });
                $('#chatInputBox').val('');
                $('#msg-option').css('display', 'none');
                $('#contact-seller').find('.contact').attr('disabled', '');
                $('#seller_details').animate({'height': '125px'});
                $('#go_to_chatbox').css('display', 'block');
            } else {
                console.log('say something');
            }
        });
        $('#cancelBtn').on('click', function (e) {
            e.preventDefault();
            $('#seller_details').animate({'height': '114px'});
            $('#msg-option').css('display', 'none');
        });
    </script>

    <script type="text/javascript"
            src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons"
            async="async"></script>
@endpush
