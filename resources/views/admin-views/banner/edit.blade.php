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
        <!-- Content Row -->
        <div class="row pt-4" style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ \App\CPU\translate('banner_update_form') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banner.update', [$banner['id']]) }}" method="post"
                            enctype="multipart/form-data" class="banner_form">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" id="id" name="id">
                                            <label for="name">{{ \App\CPU\translate('banner_url') }}</label>
                                            <input type="text" name="url" class="form-control"
                                                value="{{ $banner['url'] }}" required>
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
                                                <option value="Main Banner"
                                                    {{ $banner['banner_type'] == 'Main Banner' ? 'selected' : '' }}>Main Banner
                                                </option>
                                                <option value="Footer Banner"
                                                    {{ $banner['banner_type'] == 'Footer Banner' ? 'selected' : '' }}>Footer
                                                    Banner</option>
                                                <option value="Popup Banner"
                                                    {{ $banner['banner_type'] == 'Popup Banner' ? 'selected' : '' }}>Popup Banner
                                                </option>
                                                <option value="Main Section Banner"
                                                    {{ $banner['banner_type'] == 'Main Section Banner' ? 'selected' : '' }}>
                                                    {{ \App\CPU\translate('Main Section Banner') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="resource_id">{{ \App\CPU\translate('resource_type') }}</label>
                                            <select style="width: 100%" onchange="display_data(this.value)"
                                                class="js-example-responsive form-control" name="resource_type" required>
                                                <option value="product"
                                                    {{ $banner['resource_type'] == 'product' ? 'selected' : '' }}>Product
                                                </option>
                                                <option value="category"
                                                    {{ $banner['resource_type'] == 'category' ? 'selected' : '' }}>Category
                                                </option>
                                                <option value="shop"
                                                    {{ $banner['resource_type'] == 'shop' ? 'selected' : '' }}>Shop</option>
                                                <option value="brand"
                                                    {{ $banner['resource_type'] == 'brand' ? 'selected' : '' }}>Brand</option>
                                                <option value="doctor"
                                                    {{ $banner['resource_type'] == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                                <option value="pharmacy"
                                                    {{ $banner['resource_type'] == 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                                <option value="service"
                                                    {{ $banner['resource_type'] == 'service' ? 'selected' : '' }}>Service</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-product"
                                            style="display: {{ $banner['resource_type'] == 'product' ? 'block' : 'none' }}">
                                            <label for="product_id">{{ \App\CPU\translate('product') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="product_id">
                                                @foreach (\App\Model\Product::active()->get() as $product)
                                                    @if (\App\Model\Banner::where('resource_type', 'product')->where('resource_id', $product->id)->first() == null || $banner['resource_id'] == $product['id'])
                                                        <option value="{{ $product['id'] }}"
                                                            {{ $banner['resource_id'] == $product['id'] ? 'selected' : '' }}>
                                                            {{ $product['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-category"
                                            style="display: {{ $banner['resource_type'] == 'category' ? 'block' : 'none' }}">
                                            <label for="name">{{ \App\CPU\translate('category') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="category_id">
                                                @foreach (\App\CPU\CategoryManager::parents() as $category)
                                                    <option value="{{ $category['id'] }}"
                                                        {{ $banner['resource_id'] == $category['id'] ? 'selected' : '' }}>
                                                        {{ $category['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-shop"
                                            style="display: {{ $banner['resource_type'] == 'shop' ? 'block' : 'none' }}">
                                            <label for="shop_id">{{ \App\CPU\translate('shop') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="shop_id">
                                                @foreach (\App\Model\Shop::active()->get() as $shop)
                                                    <option value="{{ $shop['id'] }}"
                                                        {{ $banner['resource_id'] == $shop['id'] ? 'selected' : '' }}>
                                                        {{ $shop['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-brand"
                                            style="display: {{ $banner['resource_type'] == 'brand' ? 'block' : 'none' }}">
                                            <label for="brand_id">{{ \App\CPU\translate('brand') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="brand_id">
                                                @foreach (\App\Model\Brand::all() as $brand)
                                                    <option value="{{ $brand['id'] }}"
                                                        {{ $banner['resource_id'] == $brand['id'] ? 'selected' : '' }}>
                                                        {{ $brand['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-doctor"
                                            style="display: {{ $banner['resource_type'] == 'doctor' ? 'block' : 'none' }}">
                                            <label for="doctor_id">{{ \App\CPU\translate('doctor') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="doctor_id">
                                                @foreach (\App\Model\Doctor::all() as $doctor)
                                                    <option value="{{ $doctor['id'] }}"
                                                        {{ $banner['resource_id'] == $doctor['id'] ? 'selected' : '' }}>
                                                        {{ $doctor['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-pharmacy"
                                            style="display: {{ $banner['resource_type'] == 'pharmacy' ? 'block' : 'none' }}">
                                            <label for="pharmacy_id">{{ \App\CPU\translate('pharmacy') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="pharmacy_id">
                                                @foreach (\App\Model\Pharmacies::all() as $pharmacy)
                                                    <option value="{{ $pharmacy['id'] }}"
                                                        {{ $banner['resource_id'] == $pharmacy['id'] ? 'selected' : '' }}>
                                                        {{ $pharmacy['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="resource-service"
                                            style="display: {{ $banner['resource_type'] == 'service' ? 'block' : 'none' }}">
                                            <label for="service_id">{{ \App\CPU\translate('service') }}</label>
                                            <select style="width: 100%" class="js-example-responsive form-control"
                                                name="service_id">
                                                @foreach (\App\Model\Services::all() as $service)
                                                    <option value="{{ $service['id'] }}"
                                                        {{ $banner['resource_id'] == $service['id'] ? 'selected' : '' }}>
                                                        {{ $service['name'] }}</option>
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
                                                src="{{ asset('storage/app/public/banner') }}/{{ $banner['photo'] }}"
                                                alt="" />
                                        </center>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <button type="submit"
                                            class="btn btn-primary">{{ \App\CPU\translate('update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
    </script>
@endpush
