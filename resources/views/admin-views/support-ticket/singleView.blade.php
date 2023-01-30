@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Support Ticket'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Support Tickets')}}</li>
            </ol>
        </nav>

        @foreach($supportTicket as $ticket )
            <?php
            $userDetails = \App\User::where('id', $ticket['customer_id'])->first();
            $conversations = \App\Model\SupportTicketConv::where('support_ticket_id', $ticket['id'])->get();
            $admin = \App\Model\Admin::get();
            ?>
            <div class="media pb-4">
                <img class="rounded-circle" style="width: 40px; height:40px;"
                     src="{{asset('storage/app/public/profile')}}/{{isset($userDetails)?$userDetails['image']:''}}"
                     onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}"
                     alt="{{isset($userDetails)?$userDetails['name']:'not found'}}"/>
                <div class="media-body {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">
                    <h6 class="font-size-md mb-2">{{isset($userDetails)?$userDetails['name']:'not found'}}</h6>
                    <p class="font-size-md mb-1">{{$ticket['description']}}</p>
                    <span class="font-size-ms text-muted">
                             <i class="czi-time align-middle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}</i></span>
                </div>
            </div>
            @foreach($conversations as $conversation)
                @if($conversation['admin_message'] ==null )
                    <div class="media pb-4">
                        <img class="rounded-circle" style="width: 40px; height:40px;"
                             src="{{asset('storage/app/public/profile')}}/{{isset($userDetails)?$userDetails['image']:''}}"
                             onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}"
                             alt="{{isset($userDetails)?$userDetails['name']:'not found'}}"/>
                        <div class="media-body {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">
                            <h6 class="font-size-md mb-2">{{isset($userDetails)?$userDetails['name']:'not found'}}</h6>
                            <p class="font-size-md mb-1">{{$conversation['customer_message']}}</p>
                            <span class="font-size-ms text-muted">
                         <i class="czi-time align-middle {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"></i>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['created_at'])->format('Y-m-d h:i A')}}</span>
                        </div>
                    </div>
                @endif
                @if($conversation['customer_message'] ==null )
                    <div class="media pb-4 " style="text-align: right">
                        <div class="media-body {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}} ">
                            <h6 class="font-size-md mb-2"></h6>
                            <p class="font-size-md mb-1">{{$conversation['admin_message']}}</p>
                            <span
                                class="font-size-ms text-muted"> {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$conversation['updated_at'])->format('Y-m-d h:i A')}}</span>
                        </div>
                    </div>
                @endif
            @endforeach

        @endforeach
    <!-- Leave message-->
        <h3 class="h5 mt-2 pt-4 pb-2">{{\App\CPU\translate('Leave a Message')}}</h3>
        @foreach($supportTicket as $reply)
            <form class="needs-validation" href="{{route('admin.support-ticket.replay',$reply['id'])}}" method="post"
                  >
                @csrf
                <input type="hidden" name="id" value="{{$reply['id']}}">
                <input type="hidden" name="adminId" value="1">
                <div class="form-group">
                <textarea class="form-control" name="replay" rows="8" placeholder="Write your message here..."
                          required></textarea>
                    <div class="invalid-tooltip">{{\App\CPU\translate('Please write the message')}}!</div>
                </div>
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div class="custom-control custom-checkbox d-block">
                    </div>
                    <button class="btn btn-primary my-2" type="submit">{{\App\CPU\translate('Submit Reply')}}</button>
                </div>
            </form>
        @endforeach

    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('public/assets/back-end')}}/js/demo/datatables-demo.js"></script>
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>

@endpush
