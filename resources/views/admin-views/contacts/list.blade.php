@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Contact List'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Customer Message')}}</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{\App\CPU\translate('Customer')}} {{\App\CPU\translate('Message')}} {{\App\CPU\translate('List')}}</h1>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="row justify-content-between align-items-center flex-grow-1">
                        <div class="flex-start col-lg-3 mb-3 mb-lg-0">
                            <h5>{{\App\CPU\translate('Customer')}} {{\App\CPU\translate('Message')}} {{\App\CPU\translate('table')}} </h5>
                            <h5 style="color: red; margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 5px">({{ $contacts->total() }})</h5>
                        </div>
                        <div class="col-lg-6">
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{\App\CPU\translate('Search_by_Name_or_Mobile_No_or_Email')}}" aria-label="Search orders" value="{{ $search }}" required>
                                    <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CPU\translate('SL')}}#</th>
                                <th>{{\App\CPU\translate('Name')}}</th>
                                <th>{{\App\CPU\translate('mobile_no')}}</th>
                                <th>{{\App\CPU\translate('Email')}}</th>
                                <th>{{\App\CPU\translate('Subject')}}</th>
                                <th>{{\App\CPU\translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $k=>$contact)
                                <tr>
                                    <td>{{$contacts->firstItem()+$k}}</td>
                                    <td>{{$contact['name']}}</td>
                                    <td>{{$contact['mobile_number']}}</td>
                                    <td>{{$contact['email']}}</td>
                                    <td>{{$contact['subject']}}</td>
                                    <td>

                                    
                                        <a  title="{{\App\CPU\translate('View')}}"
                                            class="btn btn-info btn-sm" style="cursor: pointer;"
                                            href="{{route('admin.contact.view',$contact->id)}}"> 
                                            <i class="tio-visible"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm delete" style="cursor: pointer;"
                                            id="{{$contact['id']}}"
                                            title="{{ \App\CPU\translate('Delete')}}"> 
                                            <i class="tio-delete"></i>
                                        </a>
                                    
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{$contacts->links()}}
                </div>
                @if(count($contacts)==0)
                    <div class="text-center p-4">
                        <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">{{\App\CPU\translate('No_data_to_show')}}</p>
                    </div>
                @endif
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{\App\CPU\translate('Are_you_sure_delete_this')}}?',
                text: "{{\App\CPU\translate('You_will_not_be_able_to_revert_this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{\App\CPU\translate('Yes')}}, {{\App\CPU\translate('delete_it')}}!',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.contact.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{\App\CPU\translate('Contact_deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
