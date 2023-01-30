@extends('layouts.back-end.app')
{{--@section('title','Customer')--}}
@section('title', \App\CPU\translate('subscriber_list'))

@push('css_or_js')

@endpush

@section('content')
<div class="conatainer container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{\App\CPU\translate('subscriber_list')}} <span style="color: rgb(252, 59, 10);">({{ $subscription_list->total() }})</span></h1>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- Search -->
                    <div class="col-4">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="{{ \App\CPU\translate('Search_by_email')}}"  aria-label="Search orders" value="{{ $search }}" required>
                                <button type="submit" class="btn btn-primary">{{ \App\CPU\translate('Search')}}</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Search -->
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ \App\CPU\translate('SL')}}#</th>
                                <th scope="col">{{ \App\CPU\translate('email')}}</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscription_list as $key=>$item)
                                    <tr>
                                        <td>{{$subscription_list->firstItem()+$key}}</td>
                                        <td>{{$item->email}}</td>
                                    </tr>
                                @endforeach
                            

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="card-footer">
                    {{$subscription_list->links()}}
                </div>
                @if(count($subscription_list)==0)
                    <div class="text-center p-4">
                        <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection