@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('DB_clean'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">{{\App\CPU\translate('Clean')}} {{\App\CPU\translate('database')}}</h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="row">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="alert alert-danger mx-2" role="alert">
                {{\App\CPU\translate('This_page_contains_sensitive_information.Make_sure_before_changing.')}}
            </div>
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.business-settings.web-config.clean-db')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach($tables as $key=>$table)
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="tables[]" value="{{$table}}"
                                           class="form-check-input"
                                           id="business_section_{{$key}}">
                                    <label class="form-check-label text-dark"
                                           style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                           for="business_section_{{$key}}">{{ Str::limit($table, 20) }}</label>
                                    <span class="badge-pill badge-secondary mx-2">{{$rows[$key]}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>
                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                            onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                            class="btn btn-primary mb-2 float-right">{{\App\CPU\translate('Clear')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $("#purchase_code_div").click(function () {
            var type = $('#purchase_code').get(0).type;
            if (type === 'password') {
                $('#purchase_code').get(0).type = 'text';
            } else if (type === 'text') {
                $('#purchase_code').get(0).type = 'password';
            }
        });
    })
</script>

<script>
    $("form").on('submit',function(e) {
        e.preventDefault();
        Swal.fire({
            title: '{{\App\CPU\translate('Are you sure?')}}',
            text: "{{\App\CPU\translate('Sensitive_data! Make_sure_before_changing.')}}",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                this.submit();
            }else{
                e.preventDefault();
                toastr.success("{{\App\CPU\translate('Cancelled')}}");
                location.reload();
            }
        })
    });
</script>
@endpush