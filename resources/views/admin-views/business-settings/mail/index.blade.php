@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Mail Config'))
@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('mail_config')}}</li>
            </ol>
        </nav>

        <div class="row" style="padding-bottom: 20px; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-12 mb-3 mb-md-0 col-md-6">
                <div class="card">
                    <div class="card-body" style="padding: 20px">

                        @php($config_smtp=\App\Model\BusinessSetting::where(['type'=>'mail_config'])->first())
                        @php($data_smtp=json_decode($config_smtp['value'],true))
                        <form action="{{route('admin.business-settings.mail.update')}}"
                              method="post">
                            @csrf
                            @if(isset($config_smtp))
                                <div class="form-group mb-2 text-center">
                                    <label class="control-label">{{\App\CPU\translate('smtp_mail_config')}}</label>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="control-label">{{\App\CPU\translate('smtp_mail')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$data_smtp['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$data_smtp['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Inactive')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('mailer_name')}}</label><br>
                                    <input type="text" placeholder="ex : Alex" class="form-control" name="name"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['name']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Host')}}</label><br>
                                    <input type="text" class="form-control" name="host"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['host']}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Driver')}}</label><br>
                                    <input type="text" class="form-control" name="driver"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['driver']}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('port')}}</label><br>
                                    <input type="text" class="form-control" name="port"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['port']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Username')}}</label><br>
                                    <input type="text" placeholder="ex : ex@yahoo.com" class="form-control"
                                           name="username" value="{{env('APP_MODE')=='demo'?'':$data_smtp['username']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('email_id')}}</label><br>
                                    <input type="text" placeholder="ex : ex@yahoo.com" class="form-control" name="email"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['email_id']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Encryption')}}</label><br>
                                    <input type="text" placeholder="ex : tls" class="form-control" name="encryption"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['encryption']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('password')}}</label><br>
                                    <input type="text" class="form-control" name="password"
                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['password']}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body" style="padding: 20px">

                        @php($config_sendgrid=\App\Model\BusinessSetting::where(['type'=>'mail_config_sendgrid'])->first())
                        @php($data_sendgrid=json_decode($config_sendgrid['value'],true))
                        <form action="{{route('admin.business-settings.mail.update-sendgrid')}}"
                              method="post">
                            @csrf
                            @if(isset($config_sendgrid))
                                <div class="form-group mb-2 text-center">
                                    <label class="control-label">{{\App\CPU\translate('sendgrid_mail_config')}}</label>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="control-label">{{\App\CPU\translate('sendgrid_mail')}}</label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    <input type="radio" name="status" value="1" {{$data_sendgrid['status']==1?'checked':''}}>
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Active')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="radio" name="status" value="0" {{$data_sendgrid['status']==0?'checked':''}}>
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Inactive')}}</label>
                                    <br>
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('mailer_name')}}</label><br>
                                    <input type="text" placeholder="ex : Alex" class="form-control" name="name"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['name']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Host')}}</label><br>
                                    <input type="text" class="form-control" name="host"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['host']}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Driver')}}</label><br>
                                    <input type="text" class="form-control" name="driver"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['driver']}}">
                                </div>
                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('port')}}</label><br>
                                    <input type="text" class="form-control" name="port"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['port']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Username')}}</label><br>
                                    <input type="text" placeholder="ex : ex@yahoo.com" class="form-control"
                                           name="username" value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['username']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('email_id')}}</label><br>
                                    <input type="text" placeholder="ex : ex@yahoo.com" class="form-control" name="email"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['email_id']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('Encryption')}}</label><br>
                                    <input type="text" placeholder="ex : tls" class="form-control" name="encryption"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['encryption']}}">
                                </div>

                                <div class="form-group mb-2">
                                    <label style="padding-left: 10px">{{\App\CPU\translate('password')}}</label><br>
                                    <input type="text" class="form-control" name="password"
                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['password']}}">
                                </div>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                        onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                        class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('save')}}</button>
                            @else
                                <button type="submit"
                                        class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('Configure')}}</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
