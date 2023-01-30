@extends('layouts.back-end.app')

@section('title',\App\CPU\translate('Deliveryman List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i>
                        {{\App\CPU\translate('deliveryman')}} {{\App\CPU\translate('list')}}
                        ( {{ $delivery_men->total() }} )
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        
                        <div class="col-12 ">
                            <div class="row flex-between justify-content-between align-items-center">
                                <div class="mb-1 col-md-4">
                                    <form action="{{url()->current()}}" method="GET">
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                                    placeholder="Search" aria-label="Search" value="{{$search}}" required>
                                            <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
    
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                </div>
                                
                                <div class="col-md-3 ">
                                    <a href="{{route('admin.delivery-man.add')}}" class="btn btn-primary float-right"><i
                                            class="tio-add-circle"></i> {{\App\CPU\translate('add')}} {{\App\CPU\translate('deliveryman')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CPU\translate('#')}}</th>
                                <th style="width: 30%">{{\App\CPU\translate('name')}}</th>
                                <th style="width: 25%">{{\App\CPU\translate('image')}}</th>
                                <th>{{\App\CPU\translate('email')}}</th>
                                <th>{{\App\CPU\translate('phone')}}</th>
                                <th>{{\App\CPU\translate('status')}}</th>
                                <th>{{\App\CPU\translate('action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            @foreach($delivery_men as $key=>$dm)
                                <tr>
                                    <td>{{$delivery_men->firstitem()+$key}}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{$dm['f_name'].' '.$dm['l_name']}}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="overflow-x: hidden;overflow-y: hidden">
                                            <img width="60" style="border-radius: 50%;height: 60px; width: 60px;"
                                                 onerror="this.src='{{asset('public/assets/back-end/img/160x160/img1.jpg')}}'"
                                                 src="{{asset('storage/app/public/delivery-man')}}/{{$dm['image']}}">
                                        </div>
                                    </td>
                                    <td>
                                        {{$dm['email']}}
                                    </td>
                                    <td>
                                        {{$dm['phone']}}
                                    </td>
                                    <td>
                                        <label class="switch switch-status">
                                            <input type="checkbox" class="status"
                                                   id="{{$dm['id']}}" {{$dm->is_active == 1?'checked':''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                    
                                        <a  class="btn btn-primary btn-sm edit"
                                            title="{{\App\CPU\translate('edit')}}"
                                            href="{{route('admin.delivery-man.edit',[$dm['id']])}}">
                                            <i class="tio-edit"></i></a>
                                        <a class="btn btn-danger btn-sm delete" href="javascript:"
                                            onclick="form_alert('delivery-man-{{$dm['id']}}','Want to remove this information ?')"
                                            title="{{ \App\CPU\translate('Delete')}}">
                                            <i class="tio-add-to-trash"></i>
                                        </a>
                                        <form action="{{route('admin.delivery-man.delete',[$dm['id']])}}"
                                                method="post" id="delivery-man-{{$dm['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                {!! $delivery_men->links() !!}
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.delivery-man.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                }
            });
        });
    </script>
@endpush
