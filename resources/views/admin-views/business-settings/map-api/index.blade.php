@extends('layouts.back-end.app')

@section('title', trans('messages.third_party_apis'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CPU\translate('third_party_apis')}}</h1>
                    <span class="badge badge-soft-dark">{{\App\CPU\translate('map_api_hint')}}</span><br>
                    <span class="badge badge-soft-dark">{{\App\CPU\translate('map_api_hint_2')}}</span><br>
                </div>
            </div>
        
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3 mt-2">
        @php($map_api_key=\App\CPU\Helpers::get_business_settings('map_api_key'))
        @php($map_api_key_server=\App\CPU\Helpers::get_business_settings('map_api_key_server'))

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.map-api-update'):'javascript:'}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="input-label" style="padding-left: 10px">{{\App\CPU\translate('map_api_key')}} ({{\App\CPU\translate('client')}})</label>
                                    <input type="text" placeholder="{{\App\CPU\translate('map_api_key')}} ({{\App\CPU\translate('client')}})" class="form-control" name="map_api_key"
                                        value="{{env('APP_MODE')!='demo'?$map_api_key??'':''}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="input-label" style="padding-left: 10px">{{\App\CPU\translate('map_api_key')}} ({{\App\CPU\translate('server')}})</label>
                                    <input type="text" placeholder="{{\App\CPU\translate('map_api_key')}} ({{\App\CPU\translate('server')}})" class="form-control" name="map_api_key_server"
                                        value="{{env('APP_MODE')!='demo'?$map_api_key_server??'':''}}" required>
                                </div>
                            </div>
                        </div>
    
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

@endpush
