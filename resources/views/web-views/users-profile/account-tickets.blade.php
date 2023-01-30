@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Support Tickets'))

@push('css_or_js')
    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .font-nameA {
            font-weight: 600;
            display: inline-block;
            margin-bottom: 0;
            font-size: 17px;
            color: #030303;
        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 600 !important;
            font-size: 14px !important;

        }

        .tdBorder {
            text-align: center;
        }

        .bodytr {
            text-align: center;
        }

        .modal-footer {
            border-top: none;
        }

        .sidebarL h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}}         !important;
            transition: .2s ease-in-out;
        }

        .marl {
            margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7px;
        }

        tr td {
            padding: 3px 5px !important;
        }

        td button {
            padding: 3px 13px !important;
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
        }
    </style>
@endpush

@section('content')

    <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};" id="open-ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12"><h5
                                class="modal-title font-nameA ">{{\App\CPU\translate('submit_new_ticket')}}</h5></div>
                        <div class="col-md-12" style=" color: #030303;  margin-top: 1rem;">
                            <span>{{\App\CPU\translate('you_will_get_response')}}.</span>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="mt-3" method="post" action="{{route('ticket-submit')}}" id="open-ticket">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="firstName">{{\App\CPU\translate('Subject')}}</label>
                                <input type="text" class="form-control" id="ticket-subject" name="ticket_subject"
                                       required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="">
                                    <label class="" for="inlineFormCustomSelect">{{\App\CPU\translate('Type')}}</label>
                                    <select class="custom-select " id="ticket-type" name="ticket_type" required>
                                        <option
                                            value="Website problem">{{\App\CPU\translate('Website')}} {{\App\CPU\translate('problem')}}</option>
                                        <option value="Partner request">{{\App\CPU\translate('partner_request')}}</option>
                                        <option value="Complaint">{{\App\CPU\translate('Complaint')}}</option>
                                        <option
                                            value="Info inquiry">{{\App\CPU\translate('Info')}} {{\App\CPU\translate('inquiry')}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="">
                                    <label class="" for="inlineFormCustomSelect">{{\App\CPU\translate('Priority')}}</label>
                                    <select class="form-control custom-select" id="ticket-priority"
                                            name="ticket_priority" required>
                                        <option value>{{\App\CPU\translate('choose_priority')}}</option>
                                        <option value="Urgent">{{\App\CPU\translate('Urgent')}}</option>
                                        <option value="High">{{\App\CPU\translate('High')}}</option>
                                        <option value="Medium">{{\App\CPU\translate('Medium')}}</option>
                                        <option value="Low">{{\App\CPU\translate('Low')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="detaaddressils">{{\App\CPU\translate('describe_your_issue')}}</label>
                                <textarea class="form-control" rows="6" id="ticket-description"
                                          name="ticket_description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 0px!important;">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{\App\CPU\translate('close')}}</button>
                            <button type="submit" class="btn btn-primary">{{\App\CPU\translate('submit_a_ticket')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Title-->
    <div class="container rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9 sidebar_heading">
                <h1 class="h3  mb-0 float-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} headerTitle">{{\App\CPU\translate('support_ticket')}}</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
        @include('web-views.partials._profile-aside')
        <!-- Content  -->
            <section class="col-lg-9 col-md-9">
                <!-- Toolbar-->
                <!-- Tickets list-->
                @php($allTickets =App\Model\SupportTicket::where('customer_id', auth('customer')->id())->get())
                <div class="card box-shadow-sm">
                    <div style="overflow: auto">
                        <table class="table">
                            <thead>
                            <tr style="background: #6b6b6b">
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO ">{{\App\CPU\translate('Topic')}}</span></div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2 {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"><span
                                            class="d-block spandHeadO ">{{\App\CPU\translate('submition_date')}}</span>
                                    </div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span class="d-block spandHeadO">{{\App\CPU\translate('Type')}}</span>
                                    </div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2">
                                        <span class="d-block spandHeadO">
                                            {{\App\CPU\translate('Status')}}
                                        </span>
                                    </div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2">
                                        <span class="d-block spandHeadO"><i class="fa fa-eye"></i></span>
                                    </div>
                                </td>
                                <td class="tdBorder">
                                    <div class="py-2"><span
                                            class="d-block spandHeadO">{{\App\CPU\translate('Action')}} </span></div>
                                </td>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($allTickets as $ticket)
                                <tr>
                                    <td class="bodytr font-weight-bold" style="color: {{$web_config['primary_color']}}">
                                        <span class="marl">{{$ticket['subject']}}</span>
                                    </td>
                                    <td class="bodytr">
                                        <span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ticket['created_at'])->format('Y-m-d h:i A')}}</span>
                                    </td>
                                    <td class="bodytr"><span class="">{{$ticket['type']}}</span></td>
                                    <td class="bodytr"><span class="">{{$ticket['status']}}</span></td>

                                    <td class="bodytr">
                                        <span class="">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{route('support-ticket.index',$ticket['id'])}}">{{\App\CPU\translate('View')}}
                                            </a>
                                        </span>
                                    </td>

                                    <td class="bodytr">
                                        <a href="javascript:"
                                           onclick="Swal.fire({
                                               title: '{{\App\CPU\translate('Do you want to delete this?')}}',
                                               showDenyButton: true,
                                               showCancelButton: true,
                                               confirmButtonColor: '{{$web_config['primary_color']}}',
                                               cancelButtonColor: '{{$web_config['secondary_color']}}',
                                               confirmButtonText: `Yes`,
                                               denyButtonText: `Don't Delete`,
                                               }).then((result) => {
                                               if (result.value) {
                                               Swal.fire('Deleted!', '', 'success')
                                               location.href='{{ route('support-ticket.delete',['id'=>$ticket->id])}}';
                                               } else{
                                               Swal.fire('Cancelled', '', 'info')
                                               }
                                               })"
                                           id="delete" class=" marl">
                                            <i class="czi-trash" style="font-size: 25px; color:#e81616;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}" data-toggle="modal"
                            data-target="#open-ticket">
                            {{\App\CPU\translate('add_new_ticket')}}
                    </button>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')
@endpush
