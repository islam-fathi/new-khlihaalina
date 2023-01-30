@extends('layouts.front-end.app')

@section('title','')

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        .sidebar {
            max-width: 20rem;
        }

        .custom-control-label {
            cursor: pointer;
        }

        .btnF {
            cursor: pointer;
        }

        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        .list-link:hover {
            color: #030303 !important;
        }

        .border:hover {
            border: 3px solid #4884ea;
            margin-bottom: 5px;
            margin-top: -6px;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .card {
            border: none
        }

        .totals tr td {
            font-size: 13px
        }


        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 13px;

        }

        .spandHead {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 20px;
            margin-left: 25px;
        }

        .spandHeadO {
            color: #FFFFFF;
            font-weight: 600;
            font-size: 14px;

        }

        .font-name {
            font-weight: 600;
            font-size: 12px;
            color: #030303;
        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;


        }

        .tdBorder {
            border-right: 1px solid #f7f0f0;
            text-align: center;
        }

        .bodytr {
            border: 1px solid #dadada;
        }

        .sellerName {
            font-size: 15px;
            font-weight: 600;
        }

        /* a{
            color: #030303;
            cursor: pointer;
        }
        a:hover{
            color: #4884ea;
            cursor: pointer;
        } */
        .divider-role {
            border-bottom: 1px solid whitesmoke;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid #1b7fed !important;
            transition: .2s ease-in-out;
        }

        /*//for -message*/
        /* .container {
            max-width: 1170px;
            margin: auto;
        } */

        img {
            max-width: 100%;
        }

        .inbox_people {
            background: #ffffff none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            /*width:;*/
            border-right: 1px;
        }

        .inbox_msg {
            border: none;
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }


        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            color: #92C6FF;
            width: 100%;
            /*padding:;*/
        }

        input {
            border: none;

        }

        .headind_srch {
            padding: {{Session::get('direction') === "rtl" ? '10px 20px 10px 29px' : '10px 29px 10px 20px'}};
            overflow: hidden;
            border-bottom: none;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }


        .chat_ib h5 {
            font-size: 15px;
            font-size: 13px;
            color: #030303;
            cursor: pointer;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 80%;
            float: right;
            padding: 10px;
            background: #4884ea;
            color: white;
            border-radius: 100%;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto;
        }

        .chat_img {
            float: left;
            width: 12%;
            cursor: pointer;
        }

        .chat_ib {
            float: left;
            padding: {{Session::get('direction') === "rtl" ? '0 15px 6px 0' : '0 0 6px 15px'}};
            width: 88%;
            margin-top: 0.56rem;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: none;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 510px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #ebebeb;
        }

        .received_msg {
            display: inline-block;
            padding: {{Session::get('direction') === "rtl" ? '0 10px 0 0' : '0 0 0 10px'}};
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #E2F0FF none repeat scroll 0 0;
            border-radius: 10px;
            color: #030303;
            font-size: 14px;
            margin: 0;
            padding: {{Session::get('direction') === "rtl" ? '4px 10px 3px 8px' : '4px 8px 3px 10px'}};
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            padding: {{Session::get('direction') === "rtl" ? '30px 25px 0 15px' : '30px 15px 0 25px'}};

        }

        .send_msg p {
            background: #4884ea none repeat scroll 0 0;
            border-radius: 8px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: {{Session::get('direction') === "rtl" ? '5px 12px 5px 10px' : '5px 10px 5px 12px'}};
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .send_msg {
            float: right;
            width: 46%;
            margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 10px;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #4884ea;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }

        .aSend {
            padding: 10px;
            color: #4884ea;
            font-size: 16px;
            font-weight: 600;
        }

        .price_sidebar {
            padding: 20px;
        }


        .active {
            background: #1B7FED;
        }

        .active h5 {
            color: white;
        }

        .incoming_msg {
            display: flex;
        }

        .incoming_msg_img img {
            width: 20px;
            border-radius: 10px;
        }

        .active-text {
            font-weight: 900 !important;
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: #1B7FED;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }

            .Chat {
                margin-top: 2rem;
            }

            .sidebarR {
                padding: 24px;
            }

            .price_sidebar {
                padding: 20px;
            }

            .mr-3 {
                /*margin-right: none !important;*/
            }

            .send_msg {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 7px;
            }
        }

        /* @media(max-width:992px)
        {
            .price_sidebar {
            padding: 20px;
            max-width: 230px;
        }
        .chatSel{
            max-width: 262px;
            display: flex;
            margin-top: 1rem;
        }
        } */

    </style>

@endpush

@section('content')

    <!-- Page Title-->
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="sidebar_heading col-md-9">
                <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\translate('chat_with_seller')}}</h1>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row mt-3">
            <!-- Sidebar-->
            @include('web-views.partials._profile-aside')

            {{-- Seller List start --}}
            @if (isset($unique_shops))

                <div class="col-lg-3 chatSel">
                    <div class="card box-shadow-sm">
                        <div class="inbox_people">
                            <div class="headind_srch">
                                <form
                                    class="form-inline d-flex justify-content-center md-form form-sm active-cyan-2 mt-2">
                                    <input
                                        class="form-control form-control-sm {{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}} w-75"
                                        id="myInput" type="text"
                                        placeholder="{{\App\CPU\translate('Search')}}"
                                        aria-label="Search" 
                                        style="border: none !important;">
                                    <i class="fa fa-search" style="color: #92C6FF" aria-hidden="true"></i>
                                </form>
                                <hr>
                            </div>
                            <div class="inbox_chat">
                                @if (isset($unique_shops))
                                    @foreach($unique_shops as $key=>$shop)
                                        <div class="chat_list @if ($key == 0) btn-primary @endif"
                                             id="user_{{$shop->shop_id}}">
                                            <div class="chat_people" id="chat_people">
                                                <div class="chat_img">
                                                    <img
                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                        src="{{asset('storage/app/public/shop/'.$shop->image)}}"
                                                        style="border-radius: 10px">
                                                </div>
                                                <div class="chat_ib">
                                                    <h5 class="seller @if($shop->seen_by_customer)active-text @endif"
                                                        id="{{$shop->shop_id}}">{{$shop->name}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endForeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <section class="col-lg-6">
                    <div class="card box-shadow-sm Chat">
                        <div class="messaging">
                            <div class="inbox_msg">

                                <div class="mesgs">
                                    <div class="msg_history" id="show_msg">
                                        @if (isset($chattings))

                                            @foreach($chattings as $key => $chat)
                                                @if ($chat->sent_by_seller)
                                                    <div class="incoming_msg">
                                                        <div class="incoming_msg_img"><img
                                                                src="@if($chat->image == 'def.png'){{asset('storage/app/public/'.$chat->image)}} @else {{asset('storage/app/public/shop/'.$chat->image)}} @endif"
                                                                alt="sunil"></div>
                                                        <div class="received_msg">
                                                            <div class="received_withd_msg">
                                                                <p>
                                                                    {{$chat->message}}
                                                                </p>
                                                                <span class="time_date"> {{$chat->created_at->format('h:i A')}}    |    {{$chat->created_at->format('M d')}} </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @else

                                                    <div class="outgoing_msg">
                                                        <div class="send_msg">
                                                            <p class="btn-primary">
                                                                {{$chat->message}}
                                                            </p>
                                                            <span class="time_date"> {{$chat->created_at->format('h:i A')}}    |    {{$chat->created_at->format('M d')}} </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endForeach
                                            {{-- for scroll down --}}
                                            <div id="down"></div>

                                        @endif
                                    </div>
                                    <div class="type_msg">
                                        <div class="input_msg_write">
                                            <form
                                                class="form-inline d-flex justify-content-center md-form form-sm active-cyan-2 mt-2"
                                                id="myForm">
                                                @csrf

                                                <input type="text" id="hidden_value" hidden
                                                       value="{{$last_chat->shop_id}}" name="">
                                                <input type="text" id="seller_value" hidden
                                                       value="{{$last_chat->shop->seller_id}}" name="">

                                                <input
                                                    class="form-control form-control-sm {{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}} w-75"
                                                    id="msgInputValue"
                                                    type="text" placeholder="{{\App\CPU\translate('Send a message')}}" aria-label="Search">
                                                <input class="aSend" type="submit" id="msgSendBtn" style="width: 45px;"
                                                       value="Send">
                                                {{-- <a class="aSend" id="msgSendBtn">Send</a> --}}
                                                {{-- <i class="fa fa-send" style="color: #92C6FF" aria-hidden="true"></i> --}}

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @else
                <div class="col-md-8" style="display: flex; justify-content: center;align-items: center;">
                    <p>{{\App\CPU\translate('No conversation found')}}</p>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var shop_id;
            $(".msg_history").stop().animate({scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
            // var perams_url = window.location.search.substring(1);
            // var perams_url_split = perams_url.split('&');

            $(".seller").click(function (e) {
                e.stopPropagation();
                shop_id = e.target.id;
                //active when click on seller
                $('.chat_list.btn-primary').removeClass('btn-primary');
                $(`#user_${shop_id}`).addClass("btn-primary");
                $('.seller').css('color', 'black');
                $(`#user_${shop_id} h5`).css('color', 'white');

                $.ajax({
                    type: "get",
                    url: "messages?shop_id=" + shop_id,
                    success: function (data) {
                        $('.msg_history').html('');
                        $('.chat_ib').find('#' + shop_id).removeClass('active-text');

                        if (data.length != 0) {
                            data.map((element, index) => {
                                let dateTime = new Date(element.created_at);
                                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                                let time = dateTime.toLocaleTimeString().toLowerCase();
                                let date = month[dateTime.getMonth().toString()] + " " + dateTime.getDate().toString();

                                if (element.sent_by_customer) {

                                    $(".msg_history").append(`
                    <div class="outgoing_msg">
                      <div class='send_msg'>
                        <p  class="btn-primary">${element.message}</p>
                        <span class='time_date'> ${time}    |    ${date}</span>
                      </div>
                    </div>`
                                    )

                                } else {
                                    let img_path = element.image == 'def.png' ? `${window.location.origin}/storage/app/public/${element.image}` : `${window.location.origin}/storage/app/public/shop/${element.image}`;

                                    $(".msg_history").append(`
                    <div class="incoming_msg" style="display: flex;" id="incoming_msg">
                      <div class="incoming_msg_img" id="">
                        <img src="${img_path}" alt="">
                      </div>
                      <div class="received_msg">
                        <div class="received_withd_msg">
                          <p id="receive_msg">${element.message}</p>
                        <span class="time_date">${time}    |    ${date}</span></div>
                      </div>
                    </div>`
                                    )
                                }
                                $('#hidden_value').attr("value", shop_id);
                            });
                        } else {
                            $(".msg_history").html(`<p> No Message available </p>`);
                            data = [];
                        }
                        // data = "";
                        // $('.msg_history > div').remove();

                    }
                });

                $('.type_msg').css('display', 'block');
                $(".msg_history").stop().animate({scrollTop: $('.msg_history').prop("scrollHeight")}, 1000);

            });

            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".chat_list").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $("#msgSendBtn").click(function (e) {
                e.preventDefault();
                // get all the inputs into an array.
                var inputs = $('#myForm').find('#msgInputValue').val();
                var new_shop_id = $('#myForm').find('#hidden_value').val();
                var new_seller_id = $('#myForm').find('#seller_value').val();


                let data = {
                    message: inputs,
                    shop_id: new_shop_id,
                    seller_id: new_seller_id
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: '{{route('messages_store')}}',
                    data: data,
                    success: function (respons) {
                        $(".msg_history").append(`
                <div class="outgoing_msg" id="outgoing_msg">
                  <div class='send_msg'>
                    <p>${respons}</p>
                    <span class='time_date'> now</span>
                  </div>
                </div>`
                        )
                    }
                });
                $('#myForm').find('#msgInputValue').val('');
                $(".msg_history").stop().animate({scrollTop: $(".msg_history")[0].scrollHeight}, 1000);

            });
        });
    </script>

@endpush

