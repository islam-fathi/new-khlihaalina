@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Create Role'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('custom_role')}}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{\App\CPU\translate('role_form')}}
                    </div>
                    <div class="card-body">
                        <form id="submit-create-role" method="post" action="{{route('admin.custom-role.store')}}"
                              style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{\App\CPU\translate('role_name')}}</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       aria-describedby="emailHelp"
                                       placeholder="{{\App\CPU\translate('Ex')}} : {{\App\CPU\translate('Store')}}" required>
                            </div>

                            <label for="name">{{\App\CPU\translate('module_permission')}} : </label>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="order_management" class="form-check-input"
                                               id="order">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};" for="order">{{\App\CPU\translate('Order_Management')}}</label>
                                    </div>
                                </div>
                                <!--order end-->

                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="product_management" class="form-check-input"
                                               id="product">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="product">{{\App\CPU\translate('Product_Management')}}</label>
                                    </div>
                                </div>
                                <!--product-->

                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="marketing_section"
                                               class="form-check-input"
                                               id="marketing">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="marketing">{{\App\CPU\translate('Marketing_Section')}}</label>
                                    </div>
                                </div>
                                <!--marketing-->

                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="business_section"
                                               class="form-check-input"
                                               id="business_section">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="business_section">{{\App\CPU\translate('Business_Section')}}</label>
                                    </div>
                                </div>
                                <!--business_settings-->
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="user_section"
                                               class="form-check-input"
                                               id="user_section">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="user_section">{{\App\CPU\translate('user_Section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="support_section"
                                               class="form-check-input"
                                               id="support_section">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="support_section">{{\App\CPU\translate('Support_Section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="business_settings"
                                               class="form-check-input"
                                               id="business_settings">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="business_settings">{{\App\CPU\translate('Business_Settings')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="web_&_app_settings"
                                               class="form-check-input"
                                               id="web_&_app_settings">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="web_&_app_settings">{{\App\CPU\translate('Web_&_App_Settings')}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                               id="report">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="report">{{\App\CPU\translate('Report_&_Analytics')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="employee_section" class="form-check-input"
                                               id="employee_section">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="employee_section">{{\App\CPU\translate('Employee_Section')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="dashboard" class="form-check-input"
                                               id="dashboard">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="dashboard">{{\App\CPU\translate('Dashboard')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="pos_management" class="form-check-input"
                                               id="pos_management">
                                        <label class="form-check-label" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1.25rem;' : ''}};"
                                               for="pos_management">{{\App\CPU\translate('pos_management')}}</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">{{\App\CPU\translate('Submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{\App\CPU\translate('roles_table')}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                <thead>
                                <tr>
                                    <th scope="col">{{\App\CPU\translate('SL')}}#</th>
                                    <th scope="col">{{\App\CPU\translate('role_name')}}</th>
                                    <th scope="col">{{\App\CPU\translate('modules')}}</th>
                                    <th scope="col">{{\App\CPU\translate('created_at')}}</th>
                                    <th scope="col">{{\App\CPU\translate('status')}}</th>
                                    <th scope="col" style="width: 50px">{{\App\CPU\translate('action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rl as $k=>$r)
                                    <tr>
                                        <th scope="row">{{$k+1}}</th>
                                        <td>{{$r['name']}}</td>
                                        <td class="text-capitalize">
                                            @if($r['module_access']!=null)
                                                @foreach((array)json_decode($r['module_access']) as $m)
                                                    {{str_replace('_',' ',$m)}} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{date('d-M-y',strtotime($r['created_at']))}}</td>
                                        <td>{{\App\CPU\Helpers::status($r['status'])}}</td>
                                        <td>
                                            <a href="{{route('admin.custom-role.update',[$r['id']])}}"
                                               class="btn btn-primary btn-sm"
                                               title="{{\App\CPU\translate('Edit') }}">
                                               <i class="tio-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
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
