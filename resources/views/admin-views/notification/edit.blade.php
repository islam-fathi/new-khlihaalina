@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Update Notification'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Notification')}}</li>
            </ol>
        </nav>

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h1 class="page-header-title">{{\App\CPU\translate('Notification Update')}}</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.notification.update',[$notification['id']])}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Title')}}</label>
                                <input type="text" value="{{$notification['title']}}" name="title" class="form-control"
                                       placeholder="{{\App\CPU\translate('New notification')}}" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Description')}}</label>
                                <textarea name="description" class="form-control"
                                          required>{{$notification['description']}}</textarea>
                            </div>
                            <div class="form-group" style="text-align: left">
                                <label>{{\App\CPU\translate('Image')}}</label><small style="color: red">* ( {{\App\CPU\translate('Ratio_1:1')}}  )</small>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1">{{\App\CPU\translate('Choose file')}}</label>
                                </div>
                                <hr>
                                <center>
                                    <img style="width: 20%;max-height:200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                         src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}"
                                         alt="image"/>
                                </center>
                            </div>
                          
                            <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('Update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->
    </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
