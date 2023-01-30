@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Product in Wishlist Report'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .dataTables_info {
            margin-bottom: 20px;
            border-top: 1px solid;
            padding-top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <!-- Nav -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <ul class="nav nav-tabs page-header-tabs" id="projectsTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:">{{\App\CPU\translate('Product in wishlist report')}}</a>
                    </li>
                </ul>
            </div>
            <!-- End Nav -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <form style="width: 100%;" id="filter-form">
                            @csrf
                            <div class="row text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                                <div class="col-2">
                                    <div class="form-group ">
                                        <label for="exampleInputEmail1">{{\App\CPU\translate('Seller')}}</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <select
                                            class="js-select2-custom form-control"
                                            name="seller_id">
                                            <option value="all">{{\App\CPU\translate('All')}}</option>
                                            <option value="in_house" selected>{{\App\CPU\translate('In-House')}}</option>
                                            @foreach(\App\Model\Seller::where(['status'=>'approved'])->get() as $seller)
                                                <option value="{{$seller['id']}}">
                                                    {{$seller['f_name']}} {{$seller['l_name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-2">
                                    <button type="button" onclick="filter_form()" class="btn btn-primary btn-block">
                                        {{\App\CPU\translate('Filter')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body" id="products-table" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"></div>
                </div>
            </div>
        </div>
        <!-- End Stats -->
    </div>
@endsection

@push('script')
    <script>
        function filter_form() {
            var formData = new FormData(document.getElementById('filter-form'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.stock.piw-filter')}}',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#products-table').html(data.view)
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        };
    </script>
@endpush

@push('script_2')
    <script type="text/javascript">
        $(document).ready(function () {
            filter_form();
            $('input').addClass('form-control');
        });
    </script>
@endpush
