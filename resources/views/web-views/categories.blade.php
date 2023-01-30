@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('All Category Page'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Categories of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Categories of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <style>
        .active{
            background: {{$web_config['secondary_color']}};
            color: gray!important;
        }
        .active-category-text{
            color: white!important;
        }

        .side-category-bar{
            border: 1px solid #0000001f;
            border-radius: 6px;
            cursor: pointer;
            background: white;
        }

    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container p-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <h4>{{\App\CPU\translate('category')}}</h4>
            </div>
        </div>
        <div class="row">
            <!-- Sidebar-->
            <div class="col-lg-3 col-md-4">
                @foreach(\App\CPU\CategoryManager::parents() as $category)
                    <div class="card-header mb-2 p-2 side-category-bar" onclick="get_categories('{{route('category-ajax',[$category['id']])}}')">
                        <img src="{{asset("storage/app/public/category/$category->icon")}}" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" style="width: 18px; height: 18px; margin-right: 5px;">
                        {{-- <label class="ml-2 category-name-{{$key}}" style="cursor: pointer"> --}}
                            {{$category['name']}}
                        {{-- </label> --}}
                    </div>
                @endforeach
            </div>
            <!-- Content  -->
            <div class="col-lg-9 col-md-8">
                <!-- Products grid-->
                <hr>
                <div class="row" id="ajax-categories">
                    <label class="col-md-12 text-center mt-5">{{\App\CPU\translate('Select your desire category')}}.</label>
                </div>
                <!-- Pagination-->
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.card-header').click(function() {
                $('.card-header').removeClass('active');
                $(this).addClass('active');
            });

        });
        function get_categories(route) {
            $.get({
                url: route,
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('html,body').animate({scrollTop: $("#ajax-categories").offset().top}, 'slow');
                    $('#ajax-categories').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>
@endpush
