@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Social Login'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('social_login')}}</li>
            </ol>
        </nav>

        <?php
        $data = App\Model\BusinessSetting::where(['type' => 'social_login'])->first();
        $socialLoginServices = json_decode($data['value'], true);
        ?>
        <div class="row" style="padding-bottom: 20px">
            @if (isset($socialLoginServices))
            @foreach ($socialLoginServices as $socialLoginService)
                    <div class="col-md-6 mt-4">
                        <div class="card">
                            <div class="card-body text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}" style="padding: 20px">
                                <div class="flex-between">
                                    <h4 class="text-center">{{\App\CPU\translate(''.$socialLoginService['login_medium'])}}</h4>
                                    <div class="btn btn-dark p-2" data-toggle="modal" data-target="#{{$socialLoginService['login_medium']}}-modal" style="cursor: pointer">
                                        <i class="tio-info-outined"></i> {{\App\CPU\translate('Credentials SetUp')}}
                                    </div>
                                </div>
                                <form
                                    action="{{route('admin.social-login.update',[$socialLoginService['login_medium']])}}"
                                    method="post">
                                    @csrf
                                    <div class="form-group mb-2 mt-5">
                                        <input type="radio" name="status"
                                               value="1" {{$socialLoginService['status']==1?'checked':''}}>
                                        <label style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{\App\CPU\translate('Active')}}</label>
                                        <br>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="radio" name="status"
                                               value="0" {{$socialLoginService['status']==0?'checked':''}}>
                                        <label style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{\App\CPU\translate('Inactive')}}</label>
                                        <br>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{\App\CPU\translate('Callback_URI')}}</label>
                                        <span class="btn btn-secondary btn-sm m-2" onclick="copyToClipboard('#id_{{$socialLoginService['login_medium']}}')"><i class="tio-copy"></i> {{\App\CPU\translate('Copy URI')}}</span>
                                        <br>
                                        <span class="form-control" id="id_{{$socialLoginService['login_medium']}}" style="height: unset">{{ url('/') }}/customer/auth/login/{{$socialLoginService['login_medium']}}/callback</span>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label
                                            style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{\App\CPU\translate('Store')}} {{\App\CPU\translate('client_id')}} </label><br>
                                        <input type="text" class="form-control" name="client_id"
                                               value="{{ $socialLoginService['client_id'] }}">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label
                                            style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10px">{{\App\CPU\translate('Store')}} {{\App\CPU\translate('client_secret')}}</label><br>
                                        <input type="text" class="form-control" name="client_secret"
                                               value="{{ $socialLoginService['client_secret'] }}">
                                    </div>
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                            class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('save')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach
            @endif
        </div>
        {{-- Modal Starts--}}
        <!-- Google -->
        <div class="modal fade" id="google-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{\App\CPU\translate('Google API Set up Instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ol>
                            <li>{{\App\CPU\translate('Go to the Credentials page')}} ({{\App\CPU\translate('Click')}} <a href="https://console.cloud.google.com/apis/credentials" target="_blank">{{\App\CPU\translate('here')}}</a>)</li>
                            <li>{{\App\CPU\translate('Click')}} <b>{{\App\CPU\translate('Create credentials')}}</b> > <b>{{\App\CPU\translate('OAuth client ID')}}</b>.</li>
                            <li>{{\App\CPU\translate('Select the')}} <b>{{\App\CPU\translate('Web application')}}</b> {{\App\CPU\translate('type')}}.</li>
                            <li>{{\App\CPU\translate('Name your OAuth 2.0 client')}}</li>
                            <li>{{\App\CPU\translate('Click')}} <b>{{\App\CPU\translate('ADD URI')}}</b> {{\App\CPU\translate('from')}} <b>{{\App\CPU\translate('Authorized redirect URIs')}}</b> , {{\App\CPU\translate('provide the')}} <code>{{\App\CPU\translate('Callback URI')}}</code> {{\App\CPU\translate('from below and click')}} <b>{{\App\CPU\translate('Create')}}</b></li>
                            <li>{{\App\CPU\translate('Copy')}} <b>{{\App\CPU\translate('Client ID')}}</b> {{\App\CPU\translate('and')}} <b>{{\App\CPU\translate('Client Secret')}}</b>, {{\App\CPU\translate('paste in the input filed below and')}} <b>{{\App\CPU\translate('Save')}}</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{\App\CPU\translate('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facebook -->
        <div class="modal fade" id="facebook-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{\App\CPU\translate('Facebook API Set up Instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        <ol>
                            <li>{{\App\CPU\translate('Go to the facebook developer page')}} (<a href="https://developers.facebook.com/apps/" target="_blank">{{\App\CPU\translate('Click Here')}}</a>)</li>
                            <li>{{\App\CPU\translate('Go to')}} <b>{{\App\CPU\translate('Get Started')}}</b> {{\App\CPU\translate('from Navbar')}}</li>
                            <li>{{\App\CPU\translate('From Register tab press')}} <b>{{\App\CPU\translate('Continue')}}</b> <small>({{\App\CPU\translate('If needed')}})</small></li>
                            <li>{{\App\CPU\translate('Provide Primary Email and press')}} <b>{{\App\CPU\translate('Confirm Email')}}</b> <small>({{\App\CPU\translate('If needed')}})</small></li>
                            <li>{{\App\CPU\translate('In about section select')}} <b>{{\App\CPU\translate('Other')}}</b> {{\App\CPU\translate('and press')}} <b>{{\App\CPU\translate('Complete Registration')}}</b></li>

                            <li><b>{{\App\CPU\translate('Create App')}}</b> > {{\App\CPU\translate('Select an app type and press')}} <b>{{\App\CPU\translate('Next')}}</b></li>
                            <li>{{\App\CPU\translate('Complete the add details form and press')}} <b>{{\App\CPU\translate('Create App')}}</b></li><br/>

                            <li>{{\App\CPU\translate('From')}} <b>{{\App\CPU\translate('Facebook Login')}}</b> {{\App\CPU\translate('press')}} <b>{{\App\CPU\translate('Set Up')}}</b></li>
                            <li>{{\App\CPU\translate('Select')}} <b>{{\App\CPU\translate('Web')}}</b></li>
                            <li>{{\App\CPU\translate('Provide')}} <b>{{\App\CPU\translate('Site URL')}}</b> <small>({{\App\CPU\translate('Base URL of the site ex:')}} https://example.com)</small> > <b>{{\App\CPU\translate('Save')}}</b></li><br/>
                            <li>{{\App\CPU\translate('Now go to')}} <b>{{\App\CPU\translate('Setting')}}</b> {{\App\CPU\translate('from')}} <b>{{\App\CPU\translate('Facebook Login')}}</b> ({{\App\CPU\translate('left sidebar')}})</li>
                            <li>{{\App\CPU\translate('Make sure to check')}} <b>{{\App\CPU\translate('Client OAuth Login')}}</b> <small>({{\App\CPU\translate('must on')}})</small></li>
                            <li>{{\App\CPU\translate('Provide')}} <code>{{\App\CPU\translate('Valid OAuth Redirect URIs')}}</code> {{\App\CPU\translate('from below and click')}} <b>{{\App\CPU\translate('Save Changes')}}</b></li>

                            <li>{{\App\CPU\translate('Now go to')}} <b>{{\App\CPU\translate('Setting')}}</b> ({{\App\CPU\translate('from left sidebar')}}) > <b>{{\App\CPU\translate('Basic')}}</b></li>
                            <li>{{\App\CPU\translate('Fill the form and press')}} <b>{{\App\CPU\translate('Save Changes')}}</b></li>
                            <li>{{\App\CPU\translate('Now, copy')}} <b>{{\App\CPU\translate('Client ID')}}</b> & <b>{{\App\CPU\translate('Client Secret')}}</b>, {{\App\CPU\translate('paste in the input filed below and')}} <b>{{\App\CPU\translate('Save')}}</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary float-right" data-dismiss="modal">{{\App\CPU\translate('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Twitter -->
        <div class="modal fade" id="twitter-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{\App\CPU\translate('Twitter API Set up Instructions')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        {{\App\CPU\translate('Instruction will be available very soon')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary float-right" data-dismiss="modal">{{\App\CPU\translate('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Ends--}}
    </div>
@endsection

@push('script')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();

            toastr.success("{{\App\CPU\translate('Copied to the clipboard')}}");
        }
    </script>

@endpush
