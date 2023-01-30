@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Deal Update'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }
    </style>
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Deal of the Day')}}</li>
            <li class="breadcrumb-item">{{\App\CPU\translate('Update Deal')}}</li>
        </ol>
    </nav>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ \App\CPU\translate('deal_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.deal.day-update',[$deal['id']])}}"
                          style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                          method="post">
                        @csrf
                        @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                        @php($language = $language->value ?? null)
                        @php($default_lang = 'en')

                        @php($default_lang = json_decode($language)[0])
                        <ul class="nav nav-tabs mb-4">
                            @foreach(json_decode($language) as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}"
                                       href="#"
                                       id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="form-group">
                            @foreach(json_decode($language) as $lang)
                                <?php
                                if (count($deal['translations'])) {
                                    $translate = [];
                                    foreach ($deal['translations'] as $t) {
                                        if ($t->locale == $lang && $t->key == "title") {
                                            $translate[$lang]['title'] = $t->value;
                                        }
                                    }
                                }
                                ?>
                                <div class="row {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <div class="col-md-12">
                                        <label for="name">{{ \App\CPU\translate('title')}} ({{strtoupper($lang)}})</label>
                                        <input type="text" name="title[]"
                                               value="{{$lang==$default_lang?$deal['title']:($translate[$lang]['title']??'')}}"
                                               class="form-control" id="title"
                                               placeholder="{{\App\CPU\translate('Ex')}} : {{\App\CPU\translate('LUX')}}">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                            @endforeach
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">{{ \App\CPU\translate('product')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="product_id">
                                        @foreach (\App\Model\Product::orderBy('name', 'asc')->get() as $key => $product)
                                            <option value="{{ $product->id }}" {{$deal['product_id']==$product->id?'selected':''}}>
                                                {{$product['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--<div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{ \App\CPU\translate('discount')}}</label>
                                    <input type="number" name="discount" value="{{$deal['discount_type']=='amount'?\App\CPU\BackEndHelper::usd_to_currency($deal['discount']):$deal['discount']}}" required
                                           class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{ \App\CPU\translate('discount_type')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="discount_type">
                                        <option value="amount" {{$deal['discount_type']=='amount'?'selected':''}}>Amount</option>
                                        <option value="percentage" {{$deal['discount_type']=='percentage'?'selected':''}}>Percentage</option>
                                    </select>
                                </div>
                            </div>--}}
                        </div>

                        <div class=" pl-0">
                            <button type="submit"
                                    class="btn btn-primary float-right">{{ \App\CPU\translate('update')}}</button>
                        </div>
                    </form>
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

        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
