@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('FCM Settings'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Push Notification Setup')}}</li>
            </ol>
        </nav>

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h1 class="page-header-title">{{\App\CPU\translate('Firebase Push Notification Setup')}}</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.business-settings.update-fcm')}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              enctype="multipart/form-data">
                            @csrf
                            @php($key=\App\Model\BusinessSetting::where('type','push_notification_key')->first()->value)
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Server Key')}}</label>
                                <textarea name="push_notification_key" class="form-control"
                                          required>{{env('APP_MODE')=='demo'?'':$key}}</textarea>
                            </div>

                            <div class="row" style="display: none">
                                @php($project_id=\App\Model\BusinessSetting::where('type','fcm_project_id')->first()->value)
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('FCM Project ID')}}</label>
                                        <input type="text" value="{{$project_id}}"
                                               name="fcm_project_id" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('save')}}</button>
                        </form>
                    </div>
                </div>
            </div>

            <hr>
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">

                <div class="card">
                    <div class="card-header">
                        <h2>{{\App\CPU\translate('Push Messages')}}</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.business-settings.update-fcm-messages')}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                @php($opm=\App\Model\BusinessSetting::where('type','order_pending_message')->first()->value)
                                @php($data=json_decode($opm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="pending_status">
                                            <input type="checkbox" name="pending_status" class="toggle-switch-input"
                                                   value="1" id="pending_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                            <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}">{{\App\CPU\translate('Order Pending Message')}}</span>
                                          </span>
                                        </label>
                                        <textarea name="pending_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($ocm=\App\Model\BusinessSetting::where('type','order_confirmation_msg')->first()->value)
                                @php($data=json_decode($ocm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="confirm_status">
                                            <input type="checkbox" name="confirm_status" class="toggle-switch-input"
                                                   value="1" id="confirm_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}"> {{\App\CPU\translate('Order Confirmation Message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="confirm_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($oprm=\App\Model\BusinessSetting::where('type','order_processing_message')->first()->value)
                                @php($data=json_decode($oprm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="processing_status">
                                            <input type="checkbox" name="processing_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="processing_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}">{{\App\CPU\translate('Order Processing Message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="processing_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($ofdm=\App\Model\BusinessSetting::where('type','out_for_delivery_message')->first()->value)
                                @php($data=json_decode($ofdm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="out_for_delivery">
                                            <input type="checkbox" name="out_for_delivery_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="out_for_delivery" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}">{{\App\CPU\translate('Order out for delivery Message')}}</span>
                                              </span>
                                        </label>
                                        <textarea name="out_for_delivery_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($odm=\App\Model\BusinessSetting::where('type','order_delivered_message')->first()->value)
                                @php($data=json_decode($odm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivered_status">
                                            <input type="checkbox" name="delivered_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="delivered_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}">{{\App\CPU\translate('Order Delivered Message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivered_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>


                                @php($odm=\App\Model\BusinessSetting::where('type','order_returned_message')->first()->value)
                                @php($data=json_decode($odm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="returned_status">
                                            <input type="checkbox" name="returned_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="returned_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}">{{\App\CPU\translate('Order Returned Message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="returned_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>


                                @php($odm=\App\Model\BusinessSetting::where('type','order_failed_message')->first()->value)
                                @php($data=json_decode($odm,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="failed_status">
                                            <input type="checkbox" name="failed_status"
                                                   class="toggle-switch-input"
                                                   value="1" id="failed_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span class="d-block {{Session::get('direction') === "rtl" ? 'mr-2' : ''}}">{{\App\CPU\translate('Order Failed Message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="failed_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($dba=\App\Model\BusinessSetting::where('type','delivery_boy_assign_message')->first()->value)
                                @php($data=json_decode($dba,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">

                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivery_boy_assign">
                                            <input type="checkbox" name="delivery_boy_assign_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="delivery_boy_assign" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CPU\translate('deliveryman')}} {{\App\CPU\translate('assign')}} {{\App\CPU\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivery_boy_assign_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($dbs=\App\Model\BusinessSetting::where('type','delivery_boy_start_message')->first()->value)
                                @php($data=json_decode($dbs,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivery_boy_start_status">
                                            <input type="checkbox" name="delivery_boy_start_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="delivery_boy_start_status" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block"> {{\App\CPU\translate('deliveryman')}} {{\App\CPU\translate('start')}} {{\App\CPU\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivery_boy_start_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                                @php($dbc=\App\Model\BusinessSetting::where('type','delivery_boy_delivered_message')->first()->value)
                                @php($data=json_decode($dbc,true))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">

                                        <label class="toggle-switch d-flex align-items-center mb-3"
                                               for="delivery_boy_delivered">
                                            <input type="checkbox" name="delivery_boy_delivered_status"
                                                   class="toggle-switch-input"
                                                   value="1"
                                                   id="delivery_boy_delivered" {{$data['status']==1?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                              </span>
                                            <span class="toggle-switch-content">
                                                <span
                                                    class="d-block">{{\App\CPU\translate('deliveryman')}} {{\App\CPU\translate('delivered')}} {{\App\CPU\translate('message')}}</span>
                                              </span>
                                        </label>

                                        <textarea name="delivery_boy_delivered_message"
                                                  class="form-control">{{$data['message']}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
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
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
