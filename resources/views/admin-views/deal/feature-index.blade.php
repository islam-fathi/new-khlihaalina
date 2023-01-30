@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Feature Deal'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page"> {{ \App\CPU\translate('feature_deal')}}</li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ \App\CPU\translate('deal_form')}}
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.deal.flash')}}" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" method="post">
                            @csrf
                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')

                            @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#"
                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="form-group">
                                <div class="row">
                                    <input type="text" name="deal_type" value="feature_deal"  class="d-none">
                                    @foreach(json_decode($language) as $lang)
                                        <div class="col-md-12 {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                            <label for="name">{{ \App\CPU\translate('Title')}} ({{strtoupper($lang)}})</label>
                                            <input type="text" name="title[]" class="form-control" id="title"
                                                   placeholder="{{\App\CPU\translate('Ex')}} : {{\App\CPU\translate('LUX')}}">
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}" id="lang">
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('start_date')}}</label>
                                        <input type="date" name="start_date" required class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('end_date')}}</label>
                                        <input type="date" name="end_date" required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit"
                                        class="btn btn-primary float-right">{{ \App\CPU\translate('submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--modal-->

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <div class="flex-between row justify-content-between align-items-center flex-grow-1 mx-1">
                            <div class="flex-between">
                                <div><h5>{{ \App\CPU\translate('feature_deal')}} {{ \App\CPU\translate('Table')}}</h5></div>
                                <div class="mx-1"><h5 style="color: red;">({{ $flash_deals->total() }})</h5></div>
                            </div>
                            <div style="width: 40vw">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="{{\App\CPU\translate('Search by Title')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{ \App\CPU\translate('SL')}}#</th>
                                    <th>{{ \App\CPU\translate('Title')}}</th>
                                    <th>{{ \App\CPU\translate('Start')}}</th>
                                    <th>{{ \App\CPU\translate('end')}}</th>
                                    <th></th>
                                    <th>{{ \App\CPU\translate('status')}}</th>
                                    <th style="width: 50px">{{ \App\CPU\translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($flash_deals as $k=>$deal)
                                    <tr>
                                        <th scope="row">{{$k+1}}</th>
                                        <td>{{$deal['title']}}</td>
                                        <td>{{date('d-M-y',strtotime($deal['start_date']))}}</td>
                                        <td>{{date('d-M-y',strtotime($deal['end_date']))}}</td>
                                        <td>
                                            <a href="{{route('admin.deal.add-product',[$deal['id']])}}"
                                               class="btn btn-primary btn-sm">
                                                {{\App\CPU\translate('Add Product')}}
                                            </a>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="status"
                                                       id="{{$deal['id']}}" {{$deal->status == 1?'checked':''}}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a  title="{{ trans ('Edit')}}"
                                                href="{{route('admin.deal.edit',[$deal['id']])}}"
                                                class="btn btn-primary btn-sm">
                                                <i class="tio-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{$flash_deals->links()}}
                    </div>
                    @if(count($flash_deals)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
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

    <script>
        $(document).on('change', '.featured', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var featured = 1;
            } else if ($(this).prop("checked") == false) {
                var featured = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.deal.featured-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    featured: featured
                },
                success: function () {
                    toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                    // location.reload();
                }
            });
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
                url: "{{route('admin.deal.feature-status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                    location.reload();
                }
            });
        });

    </script>

    <!-- Page level custom scripts -->

    <script>
        $(document).ready(function () {
            // color select select2
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>
@endpush
