@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Employee Edit'))
@push('css_or_js')
    <link href="{{ asset('public/assets/back-end') }}/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('Employee') }}
                    {{ \App\CPU\translate('Update') }} </li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ \App\CPU\translate('Employee') }} {{ \App\CPU\translate('Update') }}
                        {{ \App\CPU\translate('form') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.employee.update', [$e['id']]) }}" method="post"
                            enctype="multipart/form-data"
                            style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('Name') }}</label>
                                        <input type="text" name="name" value="{{ $e['name'] }}"
                                            class="form-control" id="name"
                                            placeholder="{{ \App\CPU\translate('Ex') }} : {{ \App\CPU\translate('Md. Al Imrun') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('Phone') }}</label>
                                        <input type="number" value="{{ $e['phone'] }}" required name="phone"
                                            class="form-control" id="phone"
                                            placeholder="{{ \App\CPU\translate('Ex') }} : +88017********">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('Email') }}</label>
                                        <input type="email" value="{{ $e['email'] }}" name="email"
                                            class="form-control" id="email"
                                            placeholder="{{ \App\CPU\translate('Ex') }} : ex@gmail.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('Role') }}</label>
                                        <select class="form-control" name="role_id" style="width: 100%">
                                            <option value="0" selected disabled>
                                                ---{{ \App\CPU\translate('select') }}---</option>
                                            @foreach ($rls as $r)
                                                <option value="{{ $r->id }}"
                                                    {{ $r['id'] == $e['admin_role_id'] ? 'selected' : '' }}>{{ $r->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('Password') }}</label><small> (
                                            {{ \App\CPU\translate('input if you want to change') }} )</small>
                                        <input type="text" name="password" class="form-control" id="password"
                                            placeholder="{{ \App\CPU\translate('Password') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ \App\CPU\translate('employee_image') }}</label><span
                                                class="badge badge-soft-danger">( {{ \App\CPU\translate('ratio') }} 1:1
                                                )</span>
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
                                                src="{{ asset('storage/app/public/admin') }}/{{ $e['image'] }}"
                                                alt="Employee thumbnail" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button type="submit"
                                class="btn btn-primary float-right">{{ \App\CPU\translate('Update') }}</button>

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
    </script>

    @include('shared-partials.image-process._script', [
        'id' => 'employee-image-modal',
        'height' => 200,
        'width' => 200,
        'multi_image' => false,
        'route' => route('image-upload'),
    ])
@endpush
