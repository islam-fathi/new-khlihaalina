@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Withdraw Request'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Withdraw')}}  </li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ \App\CPU\translate('Withdraw Request Table')}}
                            <span style="color: red;">({{ $withdraw_req->total() }})</span>
                        </h5>
                        <select name="withdraw_status_filter" onchange="status_filter(this.value)" class="custom-select float-right" style="width: 200px">
                            <option value="all" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all'?'selected':''}}>{{\App\CPU\translate('All')}}</option>
                            <option value="approved" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved'?'selected':''}}>{{\App\CPU\translate('Approved')}}</option>
                            <option value="denied" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied'?'selected':''}}>{{\App\CPU\translate('Denied')}}</option>
                            <option value="pending" {{session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending'?'selected':''}}>{{\App\CPU\translate('Pending')}}</option>

                        </select>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{\App\CPU\translate('SL#')}}</th>
                                    <th>{{\App\CPU\translate('amount')}}</th>
                                    {{-- <th>{{\App\CPU\translate('note')}}</th> --}}
                                    <th>{{ \App\CPU\translate('Name') }}</th>
                                    <th>{{\App\CPU\translate('request_time')}}</th>
                                    <th>{{\App\CPU\translate('status')}}</th>
                                    <th style="width: 5px">{{\App\CPU\translate('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($withdraw_req as $k=>$wr)
                                    <tr>
                                        <td scope="row">{{$withdraw_req->firstItem()+$k}}</td>
                                        <td>{{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($wr['amount']))}}</td>
                                        {{-- <td>{{$wr->transaction_note}}</td> --}}
                                        <td>
                                            @if (isset($wr->seller))
                                                <a href="{{route('admin.sellers.view',$wr->seller_id)}}">{{ $wr->seller->f_name . ' ' . $wr->seller->l_name }}</a>
                                            @else
                                            <a href="#">{{\App\CPU\translate('not_found')}}</a>
                                            @endif
                                        </td>
                                        <td>{{$wr->created_at}}</td>
                                        <td>
                                            @if($wr->approved==0)
                                                <label class="badge badge-primary">{{\App\CPU\translate('Pending')}}</label>
                                            @elseif($wr->approved==1)
                                                <label class="badge badge-success">{{\App\CPU\translate('Approved')}}</label>
                                            @else
                                                <label class="badge badge-danger">{{\App\CPU\translate('Denied')}}</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($wr->seller))
                                            <a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}"
                                                class="btn btn-info btn-sm"
                                                title="{{\App\CPU\translate('View')}}">
                                                <i class="tio-visible"></i>
                                             </a>
                                            @else
                                            <a href="#">
                                                {{\App\CPU\translate('action_disabled')}}
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if(count($withdraw_req)==0)
                                <div class="text-center p-4">
                                    <img class="mb-3"
                                         src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg"
                                         alt="Image Description" style="width: 7rem;">
                                    <p class="mb-0">{{\App\CPU\translate('No_data_to_show')}}</p>
                                </div>
                        @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        {{$withdraw_req->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('script_2')
  <script>
      function status_filter(type) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.post({
              url: '{{route('admin.withdraw.status-filter')}}',
              data: {
                  withdraw_status_filter: type
              },
              beforeSend: function () {
                  $('#loading').show()
              },
              success: function (data) {
                 location.reload();
              },
              complete: function () {
                  $('#loading').hide()
              }
          });
      }
  </script>
@endpush
