@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('analytics_script'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{\App\CPU\translate('analytics_script')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
        @php($pixel_analytics=\App\CPU\Helpers::get_business_settings('pixel_analytics'))
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{env('APP_MODE')!='demo'?route('admin.business-settings.analytics-update'):'javascript:'}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label class="input-label" style="padding-left: 10px">{{\App\CPU\translate('pixel_analytics_script')}}</label>
                                <textarea type="text" placeholder="{{\App\CPU\translate('pixel_analytics_script_from_facebook')}}" class="form-control" name="pixel_analytics">{{env('APP_MODE')!='demo'?$pixel_analytics??'':''}}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('save')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script_2')

@endpush
