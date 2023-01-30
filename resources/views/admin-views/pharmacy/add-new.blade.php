@extends('layouts.back-end.app')
@section('title', ' Add Pharmacy')
@push('css_or_js')
    <link href="{{ asset('public/assets/back-end') }}/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        {{ \App\CPU\translate('Dashboard') }}
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    {{ \App\CPU\translate('Add Pharmacy') }}
                </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ \App\CPU\translate('Add Pharmacy Form') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pharmacy.store')}}" method="post" enctype="multipart/form-data"
                            style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('Pharmacy Name') }}</label>
                                        <input type="text" name="name" value="" class="form-control"
                                            id="name"
                                            placeholder="{{ \App\CPU\translate('Ex') }} : {{ \App\CPU\translate('Md. Al Imrun') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('Phone') }}</label>
                                        <input type="number" value="" required name="phone" class="form-control"
                                            id="phone" placeholder="{{ \App\CPU\translate('Ex') }} : +88017********">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ \App\CPU\translate('Working Hours') }}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('From') }}</label>
                                        <input type="time" class="form-control" name="working_from_time" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('To') }}</label>
                                        <input type="time" class="form-control" name="working_to_time" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('Address') }}</label>
                                        <input type="text" name="address" class="form-control" id="address"
                                            placeholder="pharmacy Address">
                                    </div>
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('City') }}</label>
                                        <select class="form-control" name="city" style="width: 100%">
                                            <option value="0" selected disabled>---{{ \App\CPU\translate('select') }}---</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ \App\CPU\translate('Description') }}</label>
                                        <textarea type="text" name="description" class="form-control" id="description" placeholder="{{ \App\CPU\translate('Description') }}"rows="5"> </textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ \App\CPU\translate('Upload pharmacy images') }}</label><small
                                                style="color: red">* ( {{ \App\CPU\translate('ratio') }} 1:1 )</small>
                                        </div>
                                        <div class="p-2 border border-dashed" style="max-width:430px;">
                                            <div class="row" id="coba"></div>
                                        </div> 
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ \App\CPU\translate('Upload thumbnail') }}</label><small
                                                style="color: red">* ( {{ \App\CPU\translate('ratio') }} 1:1 )</small>
                                        </div>
                                        <div style="max-width:200px;">
                                            <div class="row" id="thumbnail"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ \App\CPU\translate('Upload App Image') }}</label><small
                                                style="color: red">* ( {{ \App\CPU\translate('ratio') }} 1:1 )</small>
                                        </div>
                                        <div style="max-width:200px;">
                                            <div class="row" id="app_image"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ \App\CPU\translate('Upload App Bunner') }}</label><small
                                                style="color: red">* ( {{ \App\CPU\translate('ratio') }} 1:1 )</small>
                                        </div>
                                        <div style="max-width:200px;">
                                            <div class="row" id="app_bunner"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">{{ \App\CPU\translate('Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--modal-->
        @include('shared-partials.image-process._image-crop-modal', ['modal_id' => 'employee-image-modal'])
        <!--modal-->
    </div>
@endsection

@push('script')
    <script src="{{ asset('public/assets/back-end') }}/js/select2.min.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
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

        $("#customFileUpload").change(function() {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 10,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#app_image").spartanMultiImagePicker({
                fieldName: 'app_image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#app_bunner").spartanMultiImagePicker({
                fieldName: 'app_bunner',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: '280px',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ asset('public/assets/back-end/img/400x400/img2.jpg') }}',
                    width: '90%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                    '{{ \App\CPU\translate('Please only input png or jpg type file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ \App\CPU\translate('File size too big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

    @include('shared-partials.image-process._script', [
        'id' => 'employee-image-modal',
        'height' => 200,
        'width' => 200,
        'multi_image' => false,
        'route' => route('image-upload'),
    ])
@endpush
