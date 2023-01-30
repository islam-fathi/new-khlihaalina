@extends('layouts.front-end.app')

@section('title',auth('customer')->user()->f_name.' '.auth('customer')->user()->l_name)

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        .border:hover {
            border: 3px solid{{$web_config['primary_color']}};
            margin-bottom: 5px;
            margin-top: -6px;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }


        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 12px;
            color: #6A6A6A;
        }

        .spandHeadO {
            color: {{$web_config['primary_color']}};
            font-weight: 400;
            font-size: 13px;

        }

        .spandHeadO:hover {
            color: {{$web_config['primary_color']}};
            font-weight: 400;
            font-size: 13px;

        }

        .font-name {
            font-weight: 600;
            margin-top: 0px !important;
            margin-bottom: 0;
            font-size: 15px;
            color: #030303;
        }

        .font-nameA {
            font-weight: 600;
            margin-top: 0px;
            margin-bottom: 7px !important;
            font-size: 17px;
            color: #030303;
        }

        label {
            font-size: 16px;
        }

        .photoHeader {
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 1rem;
            margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 2rem;
            padding: 13px;
        }

        .card-header {
            border-bottom: none;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}          !important;
            transition: .2s ease-in-out;
        }

        @media (max-width: 350px) {

            .photoHeader {
                margin-left: 0.1px !important;
                margin-right: 0.1px !important;
                padding: 0.1px !important;

            }
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: {{$web_config['primary_color']}};
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }

            .photoHeader {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 2px !important;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 1px !important;
                padding: 13px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Page Title-->
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
                <h1 class="h3  mb-0 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('profile_Info')}}</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
        @include('web-views.partials._profile-aside')
        <!-- Content  -->
            <section class="col-lg-9 col-md-9">
                <div class="card box-shadow-sm">
                    <div class="card-header">
                        <form class="mt-3" action="{{route('user-update')}}" method="post"
                              enctype="multipart/form-data">
                            <div class="row photoHeader">
                                @csrf
                                <img id="blah"
                                     style=" border-radius: 50px; width: 50px!important;height: 50px!important;"
                                     class="rounded-circle border"
                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     src="{{asset('storage/app/public/profile')}}/{{$customerDetail['image']}}">

                                <div class="col-md-10 {{Session::get('direction') === "rtl" ? 'pr-2' : 'pl-2'}}">
                                    <h5 class="font-name">{{$customerDetail->f_name. ' '.$customerDetail->l_name}}</h5>
                                    <label for="files"
                                           style="cursor: pointer; color:{{$web_config['primary_color']}};"
                                           class="spandHeadO">
                                        {{\App\CPU\translate('change_your_profile')}}
                                    </label>
                                    <span style="color: red;font-size: 10px">( * {{\App\CPU\translate('Image ratio should be')}} 1:1 )</span>
                                    <input id="files" name="image" style="visibility:hidden;" type="file">
                                </div>

                                <div class="card-body mt-md-3" style="padding: 0px;">
                                    <h3 class="font-nameA">{{\App\CPU\translate('account_information')}} </h3>


                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="firstName">{{\App\CPU\translate('first_name')}} </label>
                                            <input type="text" class="form-control" id="f_name" name="f_name"
                                                   value="{{$customerDetail['f_name']}}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastName"> {{\App\CPU\translate('last_name')}} </label>
                                            <input type="text" class="form-control" id="l_name" name="l_name"
                                                   value="{{$customerDetail['l_name']}}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">{{\App\CPU\translate('Email')}} </label>
                                            <input type="email" class="form-control" type="email" id="account-email"
                                                   value="{{$customerDetail['email']}}" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phone">{{\App\CPU\translate('phone_name')}} </label>
                                            <small class="text-primary">(
                                                * {{\App\CPU\translate('country_code_is_must')}} {{\App\CPU\translate('like_for_BD_880')}}
                                                )</small></label>
                                            <input type="number" class="form-control" type="text" id="phone"
                                                   name="phone"
                                                   value="{{$customerDetail['phone']}}" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="si-password">{{\App\CPU\translate('new_password')}}</label>
                                            <div class="password-toggle">
                                                <input class="form-control" name="password" type="password"
                                                       id="password"
                                                >
                                                <label class="password-toggle-btn">
                                                    <input class="custom-control-input" type="checkbox"
                                                           style="display: none">
                                                    <i class="czi-eye password-toggle-indicator"
                                                       onChange="checkPasswordMatch()"></i>
                                                    <span
                                                        class="sr-only">{{\App\CPU\translate('Show')}} {{\App\CPU\translate('password')}} </span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="newPass">{{\App\CPU\translate('confirm_password')}} </label>
                                            <div class="password-toggle">
                                                <input class="form-control" name="con_password" type="password"
                                                       id="confirm_password">
                                                <div>
                                                    <label class="password-toggle-btn">
                                                        <input class="custom-control-input" type="checkbox"
                                                               style="display: none">
                                                        <i class="czi-eye password-toggle-indicator"
                                                           onChange="checkPasswordMatch()"></i><span
                                                            class="sr-only">{{\App\CPU\translate('Show')}} {{\App\CPU\translate('password')}} </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id='message'></div>
                                        </div>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">{{\App\CPU\translate('update')}} {{\App\CPU\translate('Informations')}}  </button>
                                </div>
                            </div>
                        </form>
                        <a href = {{"delete/".$customerDetail['id']}} class = "del-user" id = "btn-popup"><button type="submit"
                                            class="btn btn-danger small float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">{{\App\CPU\translate('Delete')}} {{\App\CPU\translate('Profile')}}  </button></a>
                    </div>
                </div>
            </section>
            {{-- <section class="col-lg-8">
                <!-- Toolbar-->
                <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
                    <h6 class="font-size-base text-light mb-0">Update you profile details below:</h6><a class="btn btn-primaryrimary btn-sm" href="{{route('customer.auth.logout')}}"><i class="czi-sign-out mr-2"></i>Sign out</a>
                </div>
                <!-- Profile form-->
                    <form action="{{route('user-update')}}" method="post" enctype="multipart/form-data">
                        @foreach($customerDetails as $customerDetail)
                        @csrf
                        <div class="bg-secondary rounded-lg p-4 mb-4">
                            <div class="media align-items-center">
                                <img id="blah" style="width: 80px; height: 80px;" src="{{asset('storage/app/public/profile')}}/{{$customerDetail['image']}}" width="90" alt="{{$customerDetail['f_name']}}">
                                <div class="media-body pl-3">
                                        <label for="files" style="cursor: pointer;"><i class="czi-loading mr-2"></i>Change avatar</label>
                                        <input id="files" name="image" style="visibility:hidden;" type="file">
                                    <div class="p mb-0 font-size-ms text-muted">Upload JPG, GIF or PNG image. 300 x 300 required.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-fn">First Name</label>
                                <input class="form-control" type="text" id="f_name" name="f_name" value="{{$customerDetail['f_name']}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-ln">Last Name</label>
                                <input class="form-control" type="text" id="l_name" name="l_name" value="{{$customerDetail['l_name']}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-email">Email Address</label>
                                <input class="form-control" type="email" id="account-email" value="{{$customerDetail['email']}}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-phone">Phone Number</label>
                                <input class="form-control" type="text" id="phone" name="phone" value="{{$customerDetail['phone']}}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-pass">New Password</label>
                                <div class="password-toggle">
                                    <input class="form-control" type="password" id="password" name="password">
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">Show password</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="account-confirm-pass">Confirm Password</label>
                                <div class="password-toggle">
                                    <input class="form-control" type="password" id="confirm-password" name="con_password">
                                    <label class="password-toggle-btn">
                                        <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">Show password</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="mt-2 mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="custom-control custom-checkbox d-block">
                                </div>
                                <button class="btn btn-primaryrimary mt-3 mt-sm-0" type="submit">Update profile</button>
                            </div>
                        </div>
                    </div>
                        @endforeach
                </form>
            </section> --}}
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
    <script>
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirmPassword = $("#confirm_password").val();
            $("#message").removeAttr("style");
            $("#message").html("");
            if (confirmPassword == "") {
                $("#message").attr("style", "color:black");
                $("#message").html("{{\App\CPU\translate('Please ReType Password')}}");

            } else if (password == "") {
                $("#message").removeAttr("style");
                $("#message").html("");

            } else if (password != confirmPassword) {
                $("#message").html("{{\App\CPU\translate('Passwords do not match')}}!");
                $("#message").attr("style", "color:red");
            } else if (confirmPassword.length <= 6) {
                $("#message").html("{{\App\CPU\translate('password Must Be 6 Character')}}");
                $("#message").attr("style", "color:red");
            } else {

                $("#message").html("{{\App\CPU\translate('Passwords match')}}.");
                $("#message").attr("style", "color:green");
            }

        }

        $(document).ready(function () {
            $("#confirm_password").keyup(checkPasswordMatch);

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#files").change(function () {
            readURL(this);
        });
        
         document.querySelector('#btn-popup').addEventListener('click', (e)=>{
             e.preventDefault();
            Swal.fire({
                title: '{{\App\CPU\translate('Are you sure')}}?',
                text: 'This will delete your account permanately, You will not recover it and you will lose our some services',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    const delUser = document.querySelector('.del-user');
                    window.location.assign(delUser.href);
                }
            })
        
         });
        
        

    </script>
@endpush
