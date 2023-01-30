@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Banner'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('Banner') }}</li>
            </ol>
        </nav>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12" id="banner-btn">
                <button id="main-banner-add" class="btn btn-primary"><i class="tio-add-circle"></i>
                    {{ \App\CPU\translate('add_banner') }}</button>
            </div>
        </div>
        <!-- Content Row -->
        <div class="row pt-4" id="main-banner"
            style="display: none;text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ \App\CPU\translate('banner_form') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banner.store') }}" method="post" enctype="multipart/form-data"
                            class="banner_form">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" id="id" name="id">
                                            <label for="name">{{ \App\CPU\translate('banner_url') }}</label>
                                            <input type="text" name="url" class="form-control" id="url"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ \App\CPU\translate('City') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control" name="city" required>
                                                <option value="0" selected disabled>
                                                    ---{{ \App\CPU\translate('select') }}---</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"> {{ $city->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">{{ \App\CPU\translate('banner_type') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="banner_type" required>
                                                <option value="Main Banner">{{ \App\CPU\translate('Main Banner') }}
                                                </option>
                                                <option value="Footer Banner">{{ \App\CPU\translate('Footer Banner') }}
                                                </option>
                                                <option value="Popup Banner">{{ \App\CPU\translate('Popup Banner') }}
                                                </option>
                                                <option value="Main Section Banner">
                                                    {{ \App\CPU\translate('Main Section Banner') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="resource_id">{{ \App\CPU\translate('resource_type') }}</label>
                                            <select style="width: 100%" onchange="display_data(this.value)"
                                                class="js-example-responsive form-control" name="resource_type" required>
                                                <option value="product">{{ \App\CPU\translate('Product') }}</option>
                                                <option value="category">{{ \App\CPU\translate('Category') }}</option>
                                                <option value="shop">{{ \App\CPU\translate('Shop') }}</option>
                                                <option value="brand">{{ \App\CPU\translate('Brand') }}</option>
                                                <option value="doctor">{{ \App\CPU\translate('Doctors') }}</option>
                                                <option value="pharmacy">{{ \App\CPU\translate('Pharmacies') }}</option>
                                                <option value="service">{{ \App\CPU\translate('Services') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-product">
                                            <label for="product_id">{{ \App\CPU\translate('product') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="product_id">
                                                @foreach (\App\Model\Product::active()->get() as $product)
                                                    @if (\App\Model\Banner::where('resource_type', 'product')->where('resource_id', $product->id)->first() == null)
                                                        <option value="{{ $product['id'] }}">{{ $product['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-category" style="display: none">
                                            <label for="name">{{ \App\CPU\translate('category') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="category_id">
                                                @foreach (\App\CPU\CategoryManager::parents() as $category)
                                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-shop" style="display: none">
                                            <label for="shop_id">{{ \App\CPU\translate('shop') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="shop_id">
                                                @foreach (\App\Model\Shop::active()->get() as $shop)
                                                    <option value="{{ $shop['id'] }}">{{ $shop['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-brand" style="display: none">
                                            <label for="brand_id">{{ \App\CPU\translate('brand') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="brand_id">
                                                @foreach (\App\Model\Brand::all() as $brand)
                                                    <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-doctor" style="display: none">
                                            <label for="doctor_id">{{ \App\CPU\translate('doctor') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="doctor_id">
                                                @foreach (\App\Model\Doctor::all() as $doctor)
                                                    <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-pharmacy" style="display: none">
                                            <label for="pharmacy_id">{{ \App\CPU\translate('pharmacy') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="pharmacy_id">
                                                @foreach (\App\Model\Pharmacies::all() as $pharmacy)
                                                    <option value="{{ $pharmacy['id'] }}">{{ $pharmacy['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-service" style="display: none">
                                            <label for="service_id">{{ \App\CPU\translate('service') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="service_id">
                                                @foreach (\App\Model\Services::all() as $service)
                                                    <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label for="name">{{ \App\CPU\translate('Image') }}</label><span
                                            class="badge badge-soft-danger">( {{ \App\CPU\translate('ratio') }} 4:1
                                            )</span>
                                        <br>
                                        <div class="custom-file" style="text-align: left">
                                            <input type="file" name="image" id="mbimageFileUploader"
                                                class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                for="mbimageFileUploader">{{ \App\CPU\translate('choose') }}
                                                {{ \App\CPU\translate('file') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <center>
                                            <img style="width: auto;border: 1px solid; border-radius: 10px; max-width:400px;"
                                                id="mbImageviewer"
                                                src="{{ asset('public\assets\back-end\img\400x400\img1.jpg') }}"
                                                alt="banner image" />
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a class="btn btn-secondary text-white cancel">{{ \App\CPU\translate('Cancel') }}</a>
                                <button id="add" type="submit"
                                    class="btn btn-primary">{{ \App\CPU\translate('save') }}</button>
                                <a id="update" class="btn btn-primary"
                                    style="display: none; color: #fff;">{{ \App\CPU\translate('update') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px" id="banner-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="flex-between row justify-content-between align-items-center flex-grow-1 mx-1">
                            <div class="flex-between">
                                <div>
                                    <h5>{{ \App\CPU\translate('banner_table') }}</h5>
                                </div>
                                <div class="mx-1">
                                    <h5 style="color: red;">({{ $banners->total() }})</h5>
                                </div>
                            </div>
                            <div style="width: 30vw">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{ \App\CPU\translate('Search_by_Banner_Type') }}"
                                            aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit"
                                            class="btn btn-primary">{{ \App\CPU\translate('Search') }}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="columnSearchDatatable"
                                style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ \App\CPU\translate('sl') }}</th>
                                        <th>{{ \App\CPU\translate('image') }}</th>
                                        <th>{{ \App\CPU\translate('banner_type') }}</th>
                                        <th>{{ \App\CPU\translate('published') }}</th>
                                        <th style="width: 50px">{{ \App\CPU\translate('action') }}</th>
                                    </tr>
                                </thead>
                                @foreach ($banners as $key => $banner)
                                    <tbody>

                                        <tr>
                                            <th scope="row">{{ $banners->firstItem() + $key }}</th>
                                            <td>
                                                <img width="80"
                                                    onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                                    src="{{ asset('storage/app/public/banner') }}/{{ $banner['photo'] }}">
                                            </td>
                                            <td>{{ $banner->banner_type }}</td>
                                            <td><label class="switch"><input type="checkbox" class="status"
                                                        id="{{ $banner->id }}" <?php if ($banner->published == 1) {
                                                            echo 'checked';
                                                        } ?>><span
                                                        class="slider round"></span></label></td>

                                            <td>
                                                <a class="btn btn-primary btn-sm edit"
                                                    title="{{ \App\CPU\translate('Edit') }}"
                                                    href="{{ route('admin.banner.edit', [$banner['id']]) }}"
                                                    style="cursor: pointer;">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm delete"
                                                    title="{{ \App\CPU\translate('Delete') }}" style="cursor: pointer;"
                                                    id="{{ $banner['id'] }}">
                                                    <i class="tio-add-to-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $banners->links() }}
                    </div>
                    @if (count($banners) == 0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{ asset('public/assets/back-end') }}/svg/illustrations/sorry.svg"
                                alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{ \App\CPU\translate('No_data_to_show') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            // dir: "rtl",
            width: 'resolve'
        });

        function display_data(data) {

            $('#resource-product').hide()
            $('#resource-brand').hide()
            $('#resource-category').hide()
            $('#resource-shop').hide()
            $('#resource-doctor').hide()
            $('#resource-pharmacy').hide()
            $('#resource-service').hide()

            if (data === 'product') {
                $('#resource-product').show()
            } else if (data === 'brand') {
                $('#resource-brand').show()
            } else if (data === 'category') {
                $('#resource-category').show()
            } else if (data === 'shop') {
                $('#resource-shop').show()
            } else if (data === 'doctor') {
                $('#resource-doctor').show()
            } else if (data === 'pharmacy') {
                $('#resource-pharmacy').show()
            } else if (data === 'service') {
                $('#resource-service').show()
            }
        }
    </script>
    <script>
        function mbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#mbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#mbimageFileUploader").change(function() {
            mbimagereadURL(this);
        });

        function fbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#fbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#fbimageFileUploader").change(function() {
            fbimagereadURL(this);
        });

        function pbimagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#pbImageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#pbimageFileUploader").change(function() {
            pbimagereadURL(this);
        });
    </script>
    <script>
        $('#main-banner-add').on('click', function() {
            $('#main-banner').show();
        });

        $('.cancel').on('click', function() {
            $('.banner_form').attr('action', "{{ route('admin.banner.store') }}");
            $('#main-banner').hide();
        });

        $(document).on('change', '.status', function() {
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
                url: "{{ route('admin.banner.status') }}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function(data) {
                    if (data == 1) {
                        toastr.success('{{ \App\CPU\translate('Banner_published_successfully') }}');
                    } else {
                        toastr.success('{{ \App\CPU\translate('Banner_unpublished_successfully') }}');
                    }
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            Swal.fire({
                title: "{{ \App\CPU\translate('Are_you_sure_delete_this_banner') }}?",
                text: "{{ \App\CPU\translate('You_will_not_be_able_to_revert_this') }}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ \App\CPU\translate('Yes') }}, {{ \App\CPU\translate('delete_it') }}!',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.banner.delete') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function() {
                            toastr.success(
                                '{{ \App\CPU\translate('Banner_deleted_successfully') }}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
    <!-- Page level plugins -->
@endpush
