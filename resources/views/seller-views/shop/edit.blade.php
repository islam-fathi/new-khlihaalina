@extends('layouts.back-end.app-seller')
@section('title', \App\CPU\translate('Shop Edit'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/back-end/css/croppie.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <!-- Content Row -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h3 mb-0 ">{{ \App\CPU\translate('Edit Shop Info') }}</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('seller.shop.update', [$shop->id]) }}" method="post"
                            style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Shop Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ $shop->name }}"
                                            class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Contact') }} <small
                                                class="text-danger">( * {{ \App\CPU\translate('country_code_is_must') }}
                                                {{ \App\CPU\translate('like_for_BD_880') }} )</small></label>
                                        <input type="number" name="contact" value="{{ $shop->contact }}"
                                            class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">{{ \App\CPU\translate('Address') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" rows="4" name="address" value="" class="form-control" id="address" required>{{ $shop->address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('City') }} </label>
                                        <select class="form-control" name="city" style="width: 100%">
                                            <option value="0" selected disabled>---{{ \App\CPU\translate('Select City') }}---</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{ $city['id'] == $shop['city'] ? 'selected' : '' }}>{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('work from time') }} </label>
                                        <input type="time" name="working_from_time" value="{{ $shop->working_from_time }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('work to time') }} </label>
                                        <input type="time" name="working_to_time" value="{{ $shop->working_to_time }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Upload') }}
                                            {{ \App\CPU\translate('image') }}</label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="customFileUpload"
                                                class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                for="customFileUpload">{{ \App\CPU\translate('choose') }}
                                                {{ \App\CPU\translate('file') }}</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;"
                                            id="viewer"
                                            onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                            src="{{ asset('storage/app/public/shop/' . $shop->image) }}"
                                            alt="Product thumbnail" />
                                    </div>
                                    <div class="form-group">
                                        <div class="flex-start">
                                            <div for="name">{{ \App\CPU\translate('Upload') }}
                                                {{ \App\CPU\translate('Banner') }} </div>
                                            <div class="mx-1" for="ratio"><small
                                                    style="color: red">{{ \App\CPU\translate('Ratio') }} : ( 6:1 )</small>
                                            </div>
                                        </div>
                                        <div class="custom-file text-left">
                                            <input type="file" name="banner" id="BannerUpload" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                for="BannerUpload">{{ \App\CPU\translate('choose') }}
                                                {{ \App\CPU\translate('file') }}</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <img style="width: auto; height:auto; border: 1px solid; border-radius: 10px; max-height:200px"
                                            id="viewerBanner"
                                            onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                            src="{{ asset('storage/app/public/shop/banner/' . $shop->banner) }}"
                                            alt="Product thumbnail" />
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 mb-4 mt-2">
                                    <div class="form-group">
                                        <div class="flex-start">
                                            <div for="name">{{ \App\CPU\translate('Upload') }}
                                                {{ \App\CPU\translate('Banner') }} </div>
                                            <div class="mx-1" for="ratio"><small
                                                    style="color: red">{{ \App\CPU\translate('Ratio') }} : ( 6:1 )</small>
                                            </div>
                                        </div>
                                        <div class="custom-file text-left">
                                            <input type="file" name="banner" id="BannerUpload" class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                for="BannerUpload">{{ \App\CPU\translate('choose') }}
                                                {{ \App\CPU\translate('file') }}</label>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <img style="width: auto; height:auto; border: 1px solid; border-radius: 10px; max-height:200px"
                                            id="viewerBanner"
                                            onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                            src="{{ asset('storage/app/public/shop/banner/' . $shop->banner) }}"
                                            alt="Product thumbnail" />
                                    </div>
                                </div> --}}
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary float-right"
                                id="btn_update">{{ \App\CPU\translate('Update') }}</button>
                            <a class="btn btn-danger"
                                href="{{ route('seller.shop.view') }}">{{ \App\CPU\translate('Cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readBannerURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewerBanner').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function() {
            readURL(this);
        });

        $("#BannerUpload").change(function() {
            readBannerURL(this);
        });
    </script>
@endpush
