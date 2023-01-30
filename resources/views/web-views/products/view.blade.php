@extends('layouts.front-end.app')

@section('title',ucfirst($data['data_from']).' products')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']}}"/>
    <meta property="og:title" content="Products of {{$web_config['name']}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']}}"/>
    <meta property="twitter:title" content="Products of {{$web_config['name']}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <style>
        .headerTitle {
            font-size: 26px;
            font-weight: bolder;
            margin-top: 3rem;
        }

        .for-count-value {
            position: absolute;

        {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0.6875 rem;;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;

            color: black;
            font-size: .75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .for-count-value {
            position: absolute;

        {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0.6875 rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            line-height: 1.25rem;
        }

        .for-brand-hover:hover {
            color: {{$web_config['primary_color']}};
        }

        .for-hover-lable:hover {
            color: {{$web_config['primary_color']}}       !important;
        }

        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}      !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .for-shoting {
            font-weight: 600;
            font-size: 14px;
            padding- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 9px;
            color: #030303;
        }

        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 6;
            height: 500px;
            top: 0;
        {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 40px;
        }

        .sidepanel a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
        {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 25 px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 18px;
            cursor: pointer;
            background-color: transparent !important;
            color: #373f50;
            width: 40%;
            border: none;
        }

        .openbtn:hover {
            background-color: #444;
        }

        .for-display {
            display: block !important;
        }

        @media (max-width: 360px) {
            .openbtn {
                width: 59%;
            }

            .for-shoting-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0% !important;
            }

            .for-mobile {

                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

        }

        @media (max-width: 500px) {
            .for-mobile {

                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 27%;
            }

            .openbtn:hover {
                background-color: #fff;
            }

            .for-display {
                display: flex !important;
            }

            .for-tab-display {
                display: none !important;
            }

            .openbtn-tab {
                margin-top: 0 !important;
            }

        }

        @media screen and (min-width: 500px) {
            .openbtn {
                display: none !important;
            }


        }

        @media screen and (min-width: 800px) {


            .for-tab-display {
                display: none !important;
            }

        }

        @media (max-width: 768px) {
            .headerTitle {
                font-size: 23px;

            }

            .openbtn-tab {
                margin-top: 3rem;
                display: inline-block !important;
            }

            .for-tab-display {
                display: inline;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Title-->
    <div class="d-flex justify-content-center align-items-center mb-3" style="min-height: 70px;background:{{$web_config['primary_color']}}10;width:100%;">
        
            <div class="row text-capitalize">
                <span style="font-weight: 600;font-size: 18px;">{{str_replace("_"," ",$data['data_from'])}} {{\App\CPU\translate('products')}} {{ isset($brand_name) ? '('.$brand_name.')' : ''}}</span>
            </div>
        
    </div>
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3">
                <a class="openbtn-tab mt-5" onclick="openNav()">
                    <div style="font-size: 20px; font-weight: 600; " class="for-tab-display mt-5">
                        <i class="fa fa-filter"></i>
                        {{\App\CPU\translate('filter')}}
                    </div>
                </a>
            </div>
            
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
            <aside
                class="col-lg-3 hidden-xs col-md-3 col-sm-4 SearchParameters {{Session::get('direction') === "rtl" ? 'pl-2' : 'pr-2'}}"
                id="SearchParameters">
                <!--Price Sidebar-->
                <div class="cz-sidebar  box-shadow-lg" id="shop-sidebar" style="margin-bottom: -10px;border-radius: 5px;">
                    <div class="cz-sidebar-header box-shadow-sm">
                        <button class="close {{Session::get('direction') === "rtl" ? 'mr-auto' : 'ml-auto'}}"
                                type="button" data-dismiss="sidebar" aria-label="Close"><span
                                class="d-inline-block font-size-xs font-weight-normal align-middle">{{\App\CPU\translate('Dashboard')}}Close sidebar</span><span
                                class="d-inline-block align-middle {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="pb-0" >
                        <!-- Filter by price-->
                        <div class="text-center">
                            <div class="" style="border-bottom: 1px solid #F3F5F9;padding:17px;">
                                <span class="widget-title" style="font-weight: 600;">{{\App\CPU\translate('filter')}} </span>
                            </div>
                            {{-- <div class="divider-role"
                                 style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div> --}}
                            <div
                                class="form-inline flex-nowrap {{Session::get('direction') === "rtl" ? 'ml-sm-4' : 'mr-sm-4'}} pb-3 for-mobile"
                                style="width: 100%;padding: 14px;padding-top: 30px;">
                                <label class="opacity-75 text-nowrap for-shoting" for="sorting"
                                       style="width: 100%; padding-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0">
                                    <select style="background: #ffffff; appearance: auto;width: 100%;border-radius: 5px !important;"
                                            class="form-control custom-select" id="searchByFilterValue">
                                        <option selected disabled>{{\App\CPU\translate('Choose')}}</option>
                                        <option
                                            value="{{route('products',['id'=> $data['id'],'data_from'=>'best-selling','page'=>1])}}" {{isset($data['data_from'])!=null?$data['data_from']=='best-selling'?'selected':'':''}}>{{\App\CPU\translate('best_selling_product')}}</option>
                                        <option
                                            value="{{route('products',['id'=> $data['id'],'data_from'=>'top-rated','page'=>1])}}" {{isset($data['data_from'])!=null?$data['data_from']=='top-rated'?'selected':'':''}}>{{\App\CPU\translate('top_rated')}}</option>
                                        <option
                                            value="{{route('products',['id'=> $data['id'],'data_from'=>'most-favorite','page'=>1])}}" {{isset($data['data_from'])!=null?$data['data_from']=='most-favorite'?'selected':'':''}}>{{\App\CPU\translate('most_favorite')}}</option>
                                        <option
                                            value="{{route('products',['id'=> $data['id'],'data_from'=>'featured_deal','page'=>1])}}" {{isset($data['data_from'])!=null?$data['data_from']=='featured_deal'?'selected':'':''}}>{{\App\CPU\translate('featured_deal')}}</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3" >
                        <!-- Filter by price-->
                        <div class="text-center">
                            <div style="border-bottom: 1px solid #F3F5F9;padding:17px;border-top: 1px solid #F3F5F9;">
                                <span class="widget-title" style="font-weight: 600;">{{\App\CPU\translate('Price')}} </span>
                            </div>
                        
                            <div class="d-flex justify-content-between" style="width: 100%;padding: 14px;padding-top: 30px; ">
                                <div style="width: 35%">
                                    <input style="background: #ffffff;"
                                           class="cz-filter-search form-control form-control-sm appended-form-control"
                                           type="number" value="0" min="0" max="1000000" id="min_price">
                                    
                                </div>
                                <div style="width: 10%">
                                    <p style="margin-top:6px;">{{\App\CPU\translate('to')}}</p>
                                </div>
                                <div style="width: 35%">
                                    <input style="background: #ffffff;" value="100" min="100" max="1000000"
                                           class="cz-filter-search form-control form-control-sm appended-form-control"
                                           type="number" id="max_price">
                                
                                </div>
    
                                <div style="width: 20%;background:#1B7FED;width:30px;height:35px;border-radius:3px;" class="d-flex justify-content-center align-items-center">
                                    
                                    <a class="" 
                                        onclick="searchByPrice()">
                                        <i style="font-size:10px;color:#ffffff" class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"></i>
                                    </a>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-center">
                            <div style="border-bottom: 1px solid #F3F5F9;padding:17px;border-top: 1px solid #F3F5F9;">
                                <span class="widget-title" style="font-weight: 700;">{{\App\CPU\translate('brands')}}</span>
                            </div>
                            
                            <div class="input-group-overlay input-group-sm" style="width: 100%;padding: 14px;padding-top: 30px; ">
                                <input style="background: #ffffff;padding: 22px;font-size: 13px;border-radius: 5px !important;{{Session::get('direction') === "rtl" ? 'padding-right: 32px;' : ''}}" placeholder="Search brand"
                                       class="cz-filter-search form-control form-control-sm appended-form-control"
                                       type="text" id="search-brand">
                                <div class="input-group-append-overlay">
                                    <span style="color: #3498db;"
                                          class="input-group-text">
                                        <i class="czi-search"></i>
                                    </span>
                                </div>
                            </div>
                            <ul id="lista1" 
                                style="max-height: 12rem;width: 100%;padding: 0px 0px 14px 14px;"
                                data-simplebar data-simplebar-auto-hide="false">
                                @foreach(\App\CPU\BrandManager::get_brands() as $brand)
                                    <div class="brand mt-2 for-brand-hover {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}" id="brand">
                                        <li style="cursor: pointer;padding: 2px;padding-right:15px;" class="flex-between"
                                            onclick="location.href='{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}'">
                                            <div >
                                                {{ $brand['name'] }} 
                                            </div>
                                            @if($brand['brand_products_count'] > 0 )
                                                <div style="background: #F3F5F9;
                                                border-radius: 10px;padding: 2px 7px 2px;color:#212629;font-weight: 400;font-size: 12px;">
                                                    <span class="">
                                                    {{ $brand['brand_products_count'] }}
                                                    </span>
                                                </div>
                                            @endif
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3">
                        <!-- Categories-->
                        <div class="text-center">
                            <div style="border-bottom: 1px solid #F3F5F9;padding:17px;border-top: 1px solid #F3F5F9;">
                                <span class="widget-title" style="font-weight: 700;">{{\App\CPU\translate('categories')}}</span>
                            </div>
                            @php($categories=\App\CPU\CategoryManager::parents())
                            <div class="accordion mt-n1" style="width: 100%;padding: 14px;padding-top: 25px; " id="shop-categories">
                                @foreach($categories as $category)
                                    <div >
                                        <div class="card-header p-1 flex-between">
                                            <div>
                                                <label class="for-hover-lable" style="cursor: pointer"
                                                       onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                                                    {{$category['name']}}
                                                </label>
                                            </div>
                                            <div>
                                                <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                        onclick="$('#collapse-{{$category['id']}}').toggle(400)">
                                                    {{$category->childes->count()>0?'+':''}}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                             id="collapse-{{$category['id']}}"
                                             style="display: none">
                                            @foreach($category->childes as $child)
                                                <div class=" for-hover-lable card-header p-1 flex-between">
                                                    <div>
                                                        <label style="cursor: pointer"
                                                               onclick="location.href='{{route('products',['id'=> $child['id'],'data_from'=>'category','page'=>1])}}'">
                                                            {{$child['name']}}
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <strong class="pull-right" style="cursor: pointer"
                                                                onclick="$('#collapse-{{$child['id']}}').toggle(400)">
                                                            {{$child->childes->count()>0?'+':''}}
                                                        </strong>
                                                    </div>
                                                </div>
                                                <div
                                                    class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                                    id="collapse-{{$child['id']}}"
                                                    style="display: none">
                                                    @foreach($child->childes as $ch)
                                                        <div class="card-header p-1">
                                                            <label class="for-hover-lable" style="cursor: pointer"
                                                                   onclick="location.href='{{route('products',['id'=> $ch['id'],'data_from'=>'category','page'=>1])}}'">{{$ch['name']}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                
                
                
            </aside>
            <div id="mySidepanel" class="sidepanel">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                <aside class="" style="padding-right: 5%;padding-left: 5%;">
                    <div class="" id="shop-sidebar" style="margin-bottom: -10px;">
                        <div class=" box-shadow-sm">

                        </div>
                        <div class="" style="padding-top: 12px;">
                            <!-- Filter -->
                            <div class="widget cz-filter" style="width: 100%">
                                <div style="text-align: center" >
                                    <span class="widget-title" style="font-weight: 600;">{{\App\CPU\translate('filter')}}</span>
                                </div>
                                <div class="" style="width: 100%">
                                    <label class="opacity-75 text-nowrap for-shoting" for="sorting"
                                           style="width: 100%; padding-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0">
                                        <select style="background: whitesmoke; appearance: auto;width: 100%"
                                                class="form-control custom-select" id="searchByFilterValue">
                                            <option selected disabled>{{\App\CPU\translate('Choose')}}</option>
                                            <option
                                                value="{{route('products',['id'=> $data['id'],'data_from'=>'best-selling','page'=>1])}}">{{\App\CPU\translate('best_selling_product')}}</option>
                                            <option
                                                value="{{route('products',['id'=> $data['id'],'data_from'=>'top-rated','page'=>1])}}">{{\App\CPU\translate('top_rated')}}</option>
                                            <option
                                                value="{{route('products',['id'=> $data['id'],'data_from'=>'most-favorite','page'=>1])}}">{{\App\CPU\translate('most_favorite')}}</option>
                                            <option
                                                value="{{route('products',['id'=> $data['id'],'data_from'=>'featured_deal','page'=>1])}}" {{isset($data['data_from'])!=null?$data['data_from']=='featured_deal'?'selected':'':''}}>{{\App\CPU\translate('featured_deal')}}</option>
                                        </select>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Price Sidebar-->
                    <div class="" id="shop-sidebar" style="margin-bottom: -10px;">
                        <div class=" box-shadow-sm">

                        </div>
                        <div class="" style="padding-top: 12px;">
                            <!-- Filter by price-->
                            <div class="widget cz-filter mb-4 pb-4 mt-2">
                                <h3 class="widget-title" style="font-weight: 700;">{{\App\CPU\translate('Price')}}</h3>
                                <div class="divider-role"
                                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>
                                <div class="input-group-overlay input-group-sm mb-1">
                                    <input style="background: aliceblue;"
                                           class="cz-filter-search form-control form-control-sm appended-form-control"
                                           type="number" value="0" min="0" max="1000000" id="min_price">
                                    <div class="input-group-append-overlay">
                                    <span style="color: #3498db;" class="input-group-text">
                                        {{\App\CPU\currency_symbol()}}
                                    </span>
                                    </div>
                                </div>
                                <div>
                                    <p style="text-align: center;margin-bottom: 1px;">{{\App\CPU\translate('to')}}</p>
                                </div>
                                <div class="input-group-overlay input-group-sm mb-2">
                                    <input style="background: aliceblue;" value="100" min="100" max="1000000"
                                           class="cz-filter-search form-control form-control-sm appended-form-control"
                                           type="number" id="max_price">
                                    <div class="input-group-append-overlay">
                                        <span style="color: #3498db;" class="input-group-text">
                                            {{\App\CPU\currency_symbol()}}
                                        </span>
                                    </div>
                                </div>

                                <div class="input-group-overlay input-group-sm mb-2">
                                    <button class="btn btn-primary btn-block"
                                            onclick="searchByPrice()">
                                        <span>{{\App\CPU\translate('search')}}</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Brand Sidebar-->
                    <div class="" id="shop-sidebar" style="margin-bottom: 11px;">

                        <div class="">
                            <!-- Filter by Brand-->
                            <div class="widget cz-filter mb-4 pb-4 border-bottom mt-2">
                                <h3 class="widget-title" style="font-weight: 700;">{{\App\CPU\translate('brands')}}</h3>
                                <div class="divider-role"
                                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>
                                <div class="input-group-overlay input-group-sm mb-2">
                                    <input style="background: aliceblue"
                                           class="cz-filter-search form-control form-control-sm appended-form-control"
                                           type="text" id="search-brand-m">
                                    <div class="input-group-append-overlay">
                                        <span style="color: #3498db;"
                                              class="input-group-text">
                                            <i class="czi-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <ul id="lista1" class="widget-list cz-filter-list list-unstyled pt-1"
                                    style="max-height: 12rem;"
                                    data-simplebar data-simplebar-auto-hide="false">
                                    @foreach(\App\CPU\BrandManager::get_brands() as $brand)
                                        <div class="brand mt-4 for-brand-hover" id="brand">
                                            <li style="cursor: pointer;padding: 2px"
                                                onclick="location.href='{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}'">
                                                {{ $brand['name'] }}
                                                @if($brand['brand_products_count'] > 0 )

                                                    <span class="for-count-value"
                                                          style="float: {{Session::get('direction') === "rtl" ? 'left' : 'right'}}">{{ $brand['brand_products_count'] }}</span>

                                                @endif
                                            </li>

                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Categories & Color & Size Sidebar (mobile) -->
                    <div class="" id="shop-sidebar">
                        <div class="">
                            <!-- Categories-->
                            <div class="widget widget-categories mb-4 pb-4 border-bottom">
                                <h3 class="widget-title"
                                    style="font-weight: 700;">{{\App\CPU\translate('categories')}}</h3>
                                <div class="divider-role"
                                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>
                                <div class="accordion mt-n1" id="shop-categories">
                                    @foreach($categories as $category)
                                        <div class="card">
                                            <div class="card-header p-1 flex-between">
                                                <div>
                                                    <label class="for-hover-lable" style="cursor: pointer"
                                                           onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                                                        {{$category['name']}}
                                                    </label>
                                                </div>
                                                <div>
                                                    <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                            onclick="$('#collapsem-{{$category['id']}}').toggle(300)">
                                                        {{$category->childes->count()>0?'+':''}}
                                                    </strong>
                                                </div>
                                            </div>
                                            <div
                                                class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                                id="collapsem-{{$category['id']}}"
                                                style="display: none">
                                                @foreach($category->childes as $child)
                                                    <div class="card-header p-1 flex-between">
                                                        <div>
                                                            <label class="for-hover-lable" style="cursor: pointer"
                                                                   onclick="location.href='{{route('products',['id'=> $child['id'],'data_from'=>'category','page'=>1])}}'">
                                                                {{$child['name']}}
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <strong class="pull-right for-brand-hover"
                                                                    style="cursor: pointer"
                                                                    onclick="$('#collapsem-{{$child['id']}}').toggle(300)">
                                                                {{$child->childes->count()>0?'+':''}}
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                                        id="collapsem-{{$child['id']}}"
                                                        style="display: none">
                                                        @foreach($child->childes as $ch)
                                                            <div class="card-header p-1">
                                                                <label class="for-hover-lable" style="cursor: pointer"
                                                                       onclick="location.href='{{route('products',['id'=> $ch['id'],'data_from'=>'category','page'=>1])}}'">{{$ch['name']}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Content  -->
            <section class="col-lg-9">
                {{-- <div class="col-md-9"> --}}
                    <div class="row" style="background: white;margin:0px;border-radius:5px;">
                        <div class="col-md-6 d-flex  align-items-center">
                            {{-- if need data from also --}}
                            {{-- <h1 class="h3 text-dark mb-0 headerTitle text-uppercase">{{\App\CPU\translate('product_by')}} {{$data['data_from']}} ({{ isset($brand_name) ? $brand_name : $data_from}})</h1> --}}
                            <h1 class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                            
                                <label id="price-filter-count"> {{$products->total()}} {{\App\CPU\translate('items found')}} </label>
                            </h1>
                        </div>
                        <div class="col-md-6 m-2 m-md-0 d-flex  align-items-center ">
    
                            <button class="openbtn text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}" onclick="openNav()">
                                <div >
                                    <i class="fa fa-filter"></i>
                                    {{\App\CPU\translate('filter')}}
                                </div>
                            </button>
    
                            <div class="" style="width: 100%">
                                <form id="search-form" action="{{ route('products') }}" method="GET">
                                    <input hidden name="data_from" value="{{$data['data_from']}}">
                                    <div class=" {{Session::get('direction') === "rtl" ? 'ml-2 float-left' : 'mr-2 float-right'}}">
                                        <label
                                            class=" {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}} for-shoting"
                                            for="sorting">
                                            <span
                                                class="{{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">{{\App\CPU\translate('sort_by')}}</span></label>
                                        <select style="background: white; appearance: auto;border-radius: 5px;border: 1px solid rgba(27, 127, 237, 0.5);padding:5px;"
                                                 onchange="filter(this.value)">
                                            <option value="latest">{{\App\CPU\translate('Latest')}}</option>
                                            <option
                                                value="low-high">{{\App\CPU\translate('Low_to_High')}} {{\App\CPU\translate('Price')}} </option>
                                            <option
                                                value="high-low">{{\App\CPU\translate('High_to_Low')}} {{\App\CPU\translate('Price')}}</option>
                                            <option
                                                value="a-z">{{\App\CPU\translate('A_to_Z')}} {{\App\CPU\translate('Order')}}</option>
                                            <option
                                                value="z-a">{{\App\CPU\translate('Z_to_A')}} {{\App\CPU\translate('Order')}}</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
                @if (count($products) > 0)
                    <div class="row mt-3" id="ajax-products">
                        @include('web-views.products._ajax-products',['products'=>$products])
                    </div>
                @else
                    <div class="text-center pt-5">
                        <h2>{{\App\CPU\translate('No Product Found')}}</h2>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "70%";
            document.getElementById("mySidepanel").style.height = "100vh";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        function filter(value) {
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    min_price: '{{$data['min_price']}}',
                    max_price: '{{$data['max_price']}}',
                    sort_by: value
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function searchByPrice() {
            let min = $('#min_price').val();
            let max = $('#max_price').val();
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    sort_by: '{{$data['sort_by']}}',
                    min_price: min,
                    max_price: max,
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                    $('#paginator-ajax').html(response.paginator);
                    console.log(response.total_product);
                    $('#price-filter-count').text(response.total_product + ' {{\App\CPU\translate('items found')}}')
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $('#searchByFilterValue, #searchByFilterValue-m').change(function () {
            var url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });

        $("#search-brand").on("keyup", function () {
            var value = this.value.toLowerCase().trim();
            $("#lista1 div>li").show().filter(function () {
                return $(this).text().toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });
    </script>
@endpush
