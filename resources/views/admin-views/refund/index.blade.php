@extends('layouts.back-end.app')

@section('content')
<div class="content container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="text-center"><i class="tio-settings-outlined"></i>
                 {{\App\CPU\translate('refund_request_day_limit')}}
            </h5>

        </div>
        <div class="card-body">
             @php($refund_day_limit=\App\CPU\Helpers::get_business_settings('refund_day_limit'))
            
            <form action="{{route('admin.business-settings.web-config.refund-update')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="input-label" for="name">{{\App\CPU\translate('day_limit')}}</label>
                        <input class="form-control col-12" type="number" name="refund_day_limit" value="{{$refund_day_limit}}" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('submit')}}</button>
            </form>
        </div>
    </div>
</div>

@endsection
