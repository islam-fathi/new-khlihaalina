@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Services List'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('Services') }}</li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('List') }}</li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5>{{ \App\CPU\translate('Services table') }}
                                <span style="color: red; padding: 0 .4375rem;">
                                </span>
                            </h5>
                        </div>
                        <div style="width: 40vw">
                            <!-- Search -->
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input type="search" name="search" class="form-control"
                                        placeholder="{{ \App\CPU\translate('search_by_name_or_phone') }}"
                                        value="" required>
                                    <button type="submit"
                                        class="btn btn-primary">{{ \App\CPU\translate('search') }}</button>
                                </div>
                            </form>
                            <!-- End Search -->
                        </div>
                        <div>
                            <a href="{{ route('admin.service.add') }}" class="btn btn-primary  float-right">
                                <i class="tio-add-circle"></i>
                                <span class="text">{{ \App\CPU\translate('Add') }}
                                    {{ \App\CPU\translate('New') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ \App\CPU\translate('SL') }}#</th>
                                        <th>{{ \App\CPU\translate('Name') }}</th>
                                        <th>{{ \App\CPU\translate('Phone') }}</th>
                                        <th>{{ \App\CPU\translate('City') }}</th>
                                        <th>{{ \App\CPU\translate('Address') }}</th>
                                        <th>{{ \App\CPU\translate('Working From Time') }}</th>
                                        <th>{{ \App\CPU\translate('Working To Time') }}</th>
                                        <th>{{ \App\CPU\translate('Description') }}</th>
                                        <th>{{ \App\CPU\translate('Category') }}</th>
                                        <th>{{ \App\CPU\translate('Status') }}</th>
                                        <th style="width: 50px">{{ \App\CPU\translate('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach($services as $service)
                                    <tr class="">
                                        <td class="">{{$i++}}</td>
                                        <td class="table-column-pl-0">
                                            <a href="#">{{$service->name}}</a>
                                        </td>
                                        <td>{{$service->phone}}</td>
                                        <td>
                                            @isset($service->cities['name'])
                                                {{$service->cities['name']}}  
                                            @endisset
                                        </td>
                                        <td>{{$service->address}}</td>
                                        <td>{{$service->working_from_time}}</td>
                                        <td>{{$service->working_to_time}}</td>
                                        <td>{{$service->description}}</td>
                                        <td>
                                            @isset($service->categories['name'])
                                                {{$service->categories['name']}}  
                                            @endisset
                                        </td>
                                        <td>
                                            <label class="switch switch-status">
                                                <input type="checkbox" class="status"
                                                    id="{{ $service['id'] }}"
                                                    {{ $service->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm edit" style="cursor: pointer;"
                                                title="{{ \App\CPU\translate('Edit') }}"
                                                href="{{ route('admin.service.edit', [$service['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm delete" style="cursor: pointer;"
                                                title="{{ \App\CPU\translate('Delete') }}"
                                                id="{{ $service['id'] }}">
                                                <i class="tio-add-to-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <script>
        $(document).on('change', '.status', function() {
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
                url: "{{ route('admin.service.status') }}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function(data) {
                    if (data.success == true) {
                        toastr.success('{{ \App\CPU\translate('Service updated successfully') }}');
                    }
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            Swal.fire({
                title: '{{ \App\CPU\translate('Are_you_sure') }}?',
                text: "{{ \App\CPU\translate('You_will_not_be_able_to_revert_this') }}!",
                showCancelButton: true,
                type: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ \App\CPU\translate('Yes') }}, {{ \App\CPU\translate('delete_it') }}!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('admin.service.delete') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function() {
                            toastr.success(
                                '{{ \App\CPU\translate('Service Deleted Successfully.') }}'
                                );
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
