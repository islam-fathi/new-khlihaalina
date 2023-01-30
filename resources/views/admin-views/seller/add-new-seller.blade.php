@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('add_new_seller'))

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid main-card rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('add_new_seller')}}</li>
        </ol>
    </nav> 
    <div class="row">
        <div class="col-12">
            <div class="card o-hidden border-0 shadow-lg my-4">
                <div class="card-body ">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center mb-2 ">
                                    <h3 class="" > {{\App\CPU\translate('Shop')}} {{\App\CPU\translate('Application')}}</h3>
                                    <hr>
                                </div>
                                <form class="user" action="{{route('shop.apply')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <h5 class="black">{{\App\CPU\translate('Seller')}} {{\App\CPU\translate('Info')}} </h5>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="exampleFirstName" name="f_name" value="{{old('f_name')}}" placeholder="{{\App\CPU\translate('first_name')}}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="exampleLastName" name="l_name" value="{{old('l_name')}}" placeholder="{{\App\CPU\translate('last_name')}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0 mt-4">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" value="{{old('email')}}" placeholder="{{\App\CPU\translate('email_address')}}" required>
                                        </div>
                                        <div class="col-sm-6"><small class="text-danger">( * {{\App\CPU\translate('country_code_is_must')}} {{\App\CPU\translate('like_for_BD_880')}} )</small>
                                            <input type="number" class="form-control form-control-user" id="exampleInputPhone" name="phone" value="{{old('phone')}}" placeholder="{{\App\CPU\translate('phone_number')}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user" minlength="6" id="exampleInputPassword" name="password" placeholder="{{\App\CPU\translate('password')}}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" minlength="6" id="exampleRepeatPassword" placeholder="{{\App\CPU\translate('repeat_password')}}" required>
                                            <div class="pass invalid-feedback">{{\App\CPU\translate('Repeat')}}  {{\App\CPU\translate('password')}} {{\App\CPU\translate('not match')}} .</div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="pb-1">
                                            <center>
                                                <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer"
                                                    src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                            </center>
                                        </div>
        
                                        <div class="form-group">
                                            <div class="custom-file" style="text-align: left">
                                                <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="customFileUpload">{{\App\CPU\translate('Upload')}} {{\App\CPU\translate('image')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="name">{{ \App\CPU\translate('Category') }}</label>
                                                <select class="js-example-basic-multiple form-control" name="category_id"
                                                    onchange="getRequest('{{ url('/') }}/admin/sellers/get-categories?parent_id='+this.value,'seller-sub-category-select','select')"
                                                    required>
                                                    <option value="{{ old('category_id') }}" selected disabled>---Select---</option>
                                                    @foreach ($cat as $c)
                                                        <option value="{{ $c['id'] }}"
                                                            {{ old('name') == $c['id'] ? 'selected' : '' }}>
                                                            {{ $c['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="name">{{ \App\CPU\translate('Sub Category') }}</label>
                                                <select class="js-example-basic-multiple form-control" name="sub_category_id"
                                                    id="seller-sub-category-select"
                                                    onchange="getRequest('{{ url('/') }}/admin/sellers/get-categories?parent_id='+this.value,'seller-sub-sub-category-select','select')">
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="name">{{ \App\CPU\translate('Sub Sub Category') }}</label>
                                                <select class="js-example-basic-multiple form-control" name="sub_sub_category_id"
                                                    id="seller-sub-sub-category-select">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="black">{{\App\CPU\translate('Working Hours')}}</h5>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0 ">
                                            <input type="time" class="form-control form-control-user" name="working_from_time" placeholder="{{\App\CPU\translate('working_from_time')}}" value="{{old('working_from_time')}}"required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="time" class="form-control form-control-user" name="working_to_time" placeholder="{{\App\CPU\translate('working_to_time')}}" value="{{old('working_to_time')}}"required>
                                        </div>
                                    </div>
                                    <h5 class="black">{{\App\CPU\translate('Shop')}} {{\App\CPU\translate('Info')}}</h5>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0 ">
                                            <input type="text" class="form-control form-control-user" id="shop_name" name="shop_name" placeholder="{{\App\CPU\translate('shop_name')}}" value="{{old('shop_name')}}"required>
                                        </div>
                                        <div class="col-sm-6">
                                            <textarea name="shop_address" class="form-control" id="shop_address"rows="1" placeholder="{{\App\CPU\translate('shop_address')}}">{{old('shop_address')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row"> 
                                        <div class="col-md-6">
                                            <select class="form-control" name="city" style="width: 100%">
                                                <option value="0" selected disabled>---{{ \App\CPU\translate('Select City') }}---</option>
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="pb-1">
                                            <center>
                                                <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewerLogo"
                                                    src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                            </center>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file" style="text-align: left">
                                                <input type="file" name="logo" id="LogoUpload" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="LogoUpload">{{\App\CPU\translate('Upload')}} {{\App\CPU\translate('logo')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="pb-1">
                                            <center>
                                                <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewerBanner"
                                                    src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                            </center>
                                        </div>
        
                                        <div class="form-group">
                                            <div class="custom-file" style="text-align: left">
                                                <input type="file" name="banner" id="BannerUpload" class="custom-file-input"
                                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" style="overflow: hidden; padding: 2%">
                                                <label class="custom-file-label" for="BannerUpload">{{\App\CPU\translate('Upload')}} {{\App\CPU\translate('Banner')}}</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">{{\App\CPU\translate('Apply')}} {{\App\CPU\translate('Shop')}} </button>
                                </form>
                                <hr>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
<script>
    function getRequest(route, id, type) {
        $.get({
            url: route,
            dataType: 'json',
            success: function(data) {
                if (type == 'select') {
                    $('#' + id).empty().append(data.select_tag);
                }
            },
        });
    }
    $('#inputCheckd').change(function () {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#apply').removeAttr('disabled');
            } else {
                $('#apply').attr('disabled', 'disabled');
            }

        });

    $('#exampleInputPassword ,#exampleRepeatPassword').on('keyup',function () {
        var pass = $("#exampleInputPassword").val();
        var passRepeat = $("#exampleRepeatPassword").val();
        if (pass==passRepeat){
            $('.pass').hide();
        }
        else{
            $('.pass').show();
        }
    });
    $('#apply').on('click',function () {

        var image = $("#image-set").val();
        if (image=="")
        {
            $('.image').show();
            return false;
        }
        var pass = $("#exampleInputPassword").val();
        var passRepeat = $("#exampleRepeatPassword").val();
        if (pass!=passRepeat){
            $('.pass').show();
            return false;
        }


    });
    function Validate(file) {
        var x;
        var le = file.length;
        var poin = file.lastIndexOf(".");
        var accu1 = file.substring(poin, le);
        var accu = accu1.toLowerCase();
        if ((accu != '.png') && (accu != '.jpg') && (accu != '.jpeg')) {
            x = 1;
            return x;
        } else {
            x = 0;
            return x;
        }
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewer').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFileUpload").change(function () {
        readURL(this);
    });

    function readlogoURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewerLogo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readBannerURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewerBanner').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#LogoUpload").change(function () {
        readlogoURL(this);
    });
    $("#BannerUpload").change(function () {
        readBannerURL(this);
    });
</script>
@endpush
