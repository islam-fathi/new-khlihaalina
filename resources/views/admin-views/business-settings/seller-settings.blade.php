@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Seller Information'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item"
                    aria-current="page">{{\App\CPU\translate('seller_settings')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0 text-black-50">{{\App\CPU\translate('sales')}} {{\App\CPU\translate('comission')}} {{\App\CPU\translate('Informations')}} </h4>
        </div>

        <div class="row" style="padding-bottom: 20px">
            @php($commission=\App\Model\BusinessSetting::where('type','sales_commission')->first())
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\translate('Sales Commission')}}</h5>
                    </div>
                
                    <div class="card-body" style="padding: 20px">
                        <form action="{{route('admin.business-settings.seller-settings.update-seller-settings')}}"
                              method="post">
                            @csrf
                            <label>{{\App\CPU\translate('Default Sales Commission')}} ( % )</label>
                            <input type="number" class="form-control" name="commission"
                                   value="{{isset($commission)?$commission->value:0}}"
                                   min="0" max="100">
                            <hr>
                            <button type="submit"
                                    class="btn btn-primary {{Session::get('direction') === "rtl" ? 'float-left mr-3' : 'float-right ml-3'}}">{{\App\CPU\translate('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>

            @php($seller_registration=\App\Model\BusinessSetting::where('type','seller_registration')->first()->value)
            <div class="col-md-6 mt-2 mt-md-0">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\translate('Seller Registration')}}</h5>
                    </div>
                
                    <div class="card-body" style="padding: 20px">
                        <form action="{{route('admin.business-settings.seller-settings.update-seller-registration')}}"
                              method="post">
                            @csrf
                            <label>{{\App\CPU\translate('Seller Registration on/off')}}</label>
                            <div class="form-check">
                                <input class="form-check-input" name="seller_registration" type="radio" value="1"
                                       id="defaultCheck1" {{$seller_registration==1?'checked':''}}>
                                <label class="form-check-label {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}" for="defaultCheck1">
                                    {{\App\CPU\translate('Turn on')}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="seller_registration" type="radio" value="0"
                                       id="defaultCheck2" {{$seller_registration==0?'checked':''}}>
                                <label class="form-check-label {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}" for="defaultCheck2">
                                    {{\App\CPU\translate('Turn off')}}
                                </label>
                            </div>
                            <hr>
                            <button type="submit"
                                    class="btn btn-primary {{Session::get('direction') === "rtl" ? 'float-left mr-3' : 'float-right ml-3'}}">{{\App\CPU\translate('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @php($seller_pos=\App\Model\BusinessSetting::where('type','seller_pos')->first()->value)
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\translate('Seller POS')}}</h5>
                    </div>
                
                    <div class="card-body" style="padding: 20px">
                        <form action="{{route('admin.business-settings.seller-settings.seller-pos-settings')}}"
                              method="post">
                            @csrf
                            <label>{{\App\CPU\translate('Seller POS permission on/off')}}</label>
                            <div class="form-check">
                                <input class="form-check-input" name="seller_pos" type="radio" value="1"
                                       id="seller_pos1" {{$seller_pos==1?'checked':''}}>
                                <label class="form-check-label {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}" for="seller_pos1">
                                    {{\App\CPU\translate('Turn on')}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="seller_pos" type="radio" value="0"
                                       id="seller_pos2" {{$seller_pos==0?'checked':''}}>
                                <label class="form-check-label {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}" for="seller_pos2">
                                    {{\App\CPU\translate('Turn off')}}
                                </label>
                            </div>
                            <hr>
                            <button type="submit"
                                    class="btn btn-primary {{Session::get('direction') === "rtl" ? 'float-left mr-3' : 'float-right ml-3'}}">{{\App\CPU\translate('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card" style="height: 250px;">
                    <div class="card-header">
                        <h5 class="text-center text-capitalize"> {{\App\CPU\translate('Business_mode')}}</h5>
                        
                    </div>
                    <div class="card-body">
                        @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
                        <div class="form-row">
                            <div class="col-sm mb-2 mb-sm-0">
                                <!-- Custom Radio -->
                                <div class="form-control">
                                    <div class="custom-control custom-radio custom-radio-reverse"
                                         onclick="business_mode('{{route('admin.business-settings.seller-settings.business-mode-settings',['single'])}}','{{\App\CPU\translate('For single vendor operation, deactive all seller!!')}}')">
                                        <input type="radio" class="custom-control-input"
                                               name="projectViewNewProjectTypeRadio"
                                               id="projectViewNewProjectTypeRadio1" {{(isset($business_mode) && $business_mode=='single')?'checked':''}}>
                                        <label class="custom-control-label media align-items-center"
                                               for="projectViewNewProjectTypeRadio1">
                                            
                                            <span class="media-body">
                                                {{\App\CPU\translate('single_vendor')}}
                                              </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- End Custom Radio -->
                            </div>

                            <div class="col-sm mb-2 mb-sm-0">
                                <!-- Custom Radio -->
                                <div class="form-control">
                                    <div class="custom-control custom-radio custom-radio-reverse"
                                         onclick="business_mode('{{route('admin.business-settings.seller-settings.business-mode-settings',['multi'])}}','{{\App\CPU\translate('Now, your multi vendor business mode is opening, you can add new seller !!')}}')">
                                        <input type="radio" class="custom-control-input"
                                               name="projectViewNewProjectTypeRadio"
                                               id="projectViewNewProjectTypeRadio2" {{(isset($business_mode) && $business_mode=='multi')?'checked':''}}>
                                        <label class="custom-control-label media align-items-center"
                                               for="projectViewNewProjectTypeRadio2">
                                            
                                            <span
                                                class="media-body">{{\App\CPU\translate('multi_vendor')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- End Custom Radio -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\translate('admin_approval_for_products')}}</h5>
                    </div>
                    @php($new_product_approval=\App\CPU\Helpers::get_business_settings('new_product_approval'))
                    @php($product_wise_shipping_cost_approval=\App\CPU\Helpers::get_business_settings('product_wise_shipping_cost_approval'))
                    <div class="card-body" style="padding: 20px">
                        <form action="{{route('admin.business-settings.seller-settings.product-approval')}}"
                              method="post">
                            @csrf
                            <label>{{\App\CPU\translate('approval_for_products')}}</label>
                            <div class="form-check">
                                <input class="form-check-input" name="new_product_approval" type="checkbox"
                                       id="new_product_approval" {{$new_product_approval==1?'checked':''}}>
                                <label class="form-check-label {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}" for="new_product_approval">
                                    {{\App\CPU\translate('new_product')}}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="product_wise_shipping_cost_approval" type="checkbox" 
                                       id="product_wise_shipping_cost_approval" {{$product_wise_shipping_cost_approval==1?'checked':''}}>
                                <label class="form-check-label {{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}" for="product_wise_shipping_cost_approval">
                                    {{\App\CPU\translate('product_wise_shipping_cost')}} 
                                    <span style="color: red;">( {{\App\CPU\translate('if the shipping responsibility is inhouse and product wise shipping is activated then this function will work')}} )</span>
                                </label>
                            </div>
                            <hr>
                            <button type="submit"
                                    class="btn btn-primary {{Session::get('direction') === "rtl" ? 'float-left mr-3' : 'float-right ml-3'}}">{{\App\CPU\translate('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--modal-->
        @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'company-web-Logo'])
        @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'company-mobile-Logo'])
        @include('shared-partials.image-process._image-crop-modal', ['modal_id'=>'company-footer-Logo'])
        @include('shared-partials.image-process._image-crop-modal', ['modal_id'=>'company-fav-icon'])
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script>
        function readWLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerWL').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadWL").change(function () {
            readWLURL(this);
        });

        function readWFLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerWFL').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadWFL").change(function () {
            readWFLURL(this);
        });

        function readMLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerML').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadML").change(function () {
            readMLURL(this);
        });

        function readFIURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerFI').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadFI").change(function () {
            readFIURL(this);
        });


        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

    </script>

    @include('shared-partials.image-process._script',[
        'id'=>'company-web-Logo',
        'height'=>200,
        'width'=>784,
        'multi_image'=>false,
        'route'=>route('image-upload')
        ])
    @include('shared-partials.image-process._script',[
        'id'=> 'company-footer-Logo',
        'height'=>200,
        'width'=>784,
        'multi_image'=>false,
        'route' => route('image-upload')

    ])
    @include('shared-partials.image-process._script',[
        'id'=> 'company-fav-icon',
        'height'=>100,
        'width'=>100,
        'multi_image'=>false,
        'route' => route('image-upload')

    ])
    @include('shared-partials.image-process._script',[
       'id'=>'company-mobile-Logo',
       'height'=>200,
       'width'=>784,
       'multi_image'=>false,
       'route'=>route('image-upload')
       ])

    <script>
        $(document).ready(function () {
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
    <script>
        function business_mode(route,message) {
            Swal.fire({
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: route,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })
            
        }
    </script>
@endpush
