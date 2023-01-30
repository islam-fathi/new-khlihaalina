@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Edit Role'))
@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Role Update')}}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="submit-create-role" action="{{route('admin.custom-role.update',[$role['id']])}}" method="post"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{\App\CPU\translate('role_name')}}</label>
                                <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name"
                                       aria-describedby="emailHelp"
                                       placeholder="{{\App\CPU\translate('Ex')}} : {{\App\CPU\translate('Store')}}">
                            </div>

                            <label for="module">{{\App\CPU\translate('module_permission')}} : </label>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="order_management" class="form-check-input"
                                               id="order" {{in_array('order_management',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};" for="order">{{\App\CPU\translate('Order_Management')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="product_management" class="form-check-input"
                                               id="product" {{in_array('product_management',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="product">{{\App\CPU\translate('Product_Management')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="marketing_section"
                                               class="form-check-input"
                                               id="marketing" {{in_array('marketing_section',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="marketing">{{\App\CPU\translate('Marketing_Section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="business_section"
                                               class="form-check-input"
                                               id="business_section" {{in_array('business_section',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="business_section">{{\App\CPU\translate('Business_Section')}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="user_section"
                                               class="form-check-input"
                                               id="user_section" {{in_array('user_section',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="user_section">{{\App\CPU\translate('user_section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="support_section"
                                               class="form-check-input"
                                               id="support_section" {{in_array('support_section',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="support_section">{{\App\CPU\translate('Support_Section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="business_settings"
                                               class="form-check-input"
                                               id="business_settings" {{in_array('business_settings',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="business_settings">{{\App\CPU\translate('Business_Settings')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="web_&_app_settings"
                                               class="form-check-input"
                                               id="web_&_app_settings" {{in_array('web_&_app_settings',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="web_&_app_settings">{{\App\CPU\translate('Web_&_App_Settings')}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                               id="report" {{in_array('report',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="report">{{\App\CPU\translate('Report_&_Analytics')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="employee_section"
                                               class="form-check-input"
                                               id="employee_section" {{in_array('employee_section',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="employee_section">{{\App\CPU\translate('employee_section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="dashboard" class="form-check-input"
                                               id="dashboard" {{in_array('dashboard',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="dashboard">{{\App\CPU\translate('Dashboard')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="pos_management" class="form-check-input"
                                               id="pos_management" {{in_array('pos_management',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="pos_management">{{\App\CPU\translate('pos_management')}}</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>

    $('#submit-create-role').on('submit',function(e){
        
        var fields = $("input[name='modules[]']").serializeArray(); 
        if (fields.length === 0) 
        { 
            toastr.warning('{{ \App\CPU\translate('select_minimum_one_selection_box') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
            return false;
        }else{
            $('#submit-create-role').submit();
        } 
    });
</script>
@endpush
