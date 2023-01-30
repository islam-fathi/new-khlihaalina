@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Doctors Dates'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ \App\CPU\translate('Dashboard') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('Doctors Dates') }}</li>
            </ol>
        </nav>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ \App\CPU\translate('Doctor Date Form') }}
                    </div>
                    <div class="card-body"
                        style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
                        <form action="{{ route('admin.doctor.add-date') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <div class="form-group" >
                                        <label class="input-label" for="exampleFormControlInput1">{{ \App\CPU\translate('Doctor Date') }}</label>
                                        <select name="day_name" class="form-control" >
                                            <option value="Saturday">{{ \App\CPU\translate('Saturday') }}</option>
                                            <option value="Sunday">{{ \App\CPU\translate('Sunday') }}</option>
                                            <option value="Monday">{{ \App\CPU\translate('Monday') }}</option>
                                            <option value="Tuesday">{{ \App\CPU\translate('Tuesday') }}</option>
                                            <option value="Wednesday">{{ \App\CPU\translate('Wednesday') }}</option>
                                            <option value="Thursday">{{ \App\CPU\translate('Thursday') }}</option>
                                            <option value="Friday">{{ \App\CPU\translate('Friday') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{ \App\CPU\translate('Doctor Start Time') }}</label>
                                        <input type="time" name="start_time" class="form-control" placeholder="{{ \App\CPU\translate('New') }} {{ \App\CPU\translate('Doctor Start Time Like 00:00 AM') }}" >
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{ \App\CPU\translate('Doctor End Time') }}</label>
                                        <input type="time" name="end_time" class="form-control" placeholder="{{ \App\CPU\translate('New') }} {{ \App\CPU\translate('Doctor End Time Like 00:00 PM') }}" >
                                    </div>
                                    <input type="hidden" name="doctor_id" value="{{$doctor_id}}">
                                    <button type="submit" class="btn btn-primary float-right">{{ \App\CPU\translate('submit') }}</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-between justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 col-sm-6 col-md-6">
                                {{-- <h5>{{ \App\CPU\translate('speciality_table') }} <span
                                        style="color: red;">({{ $specialties->total() }})</span></h5> --}}
                            </div>
                            <div class="col-12 col-sm-6 col-md-4" style="width: 30vw">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="" type="search" name="search" class="form-control"
                                            placeholder="{{ \App\CPU\translate('search_here') }}"
                                            value="{{ $search }}" required>
                                        <button type="submit"
                                            class="btn btn-primary">{{ \App\CPU\translate('search') }}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 100px">{{ \App\CPU\translate('Date') }} {{ \App\CPU\translate('ID') }}</th>
                                        <th>{{ \App\CPU\translate('Day Name') }}</th>
                                        <th>{{ \App\CPU\translate('Start Time') }}</th>
                                        <th>{{ \App\CPU\translate('End Time') }}</th>
                                        <th>{{ \App\CPU\translate('status') }}</th>
                                        <th class="text-center" style="width:15%;">{{ \App\CPU\translate('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctor_dates as $key => $d_date)
                                        <tr>
                                            <td class="text-center">{{ $d_date['id'] }}</td>
                                            <td>{{ $d_date['day_name'] }}</td>
                                            <td>{{ $d_date['start_time'] }}</td>
                                            <td>{{ $d_date['end_time'] }}</td>
                                            <td>
                                                <label class="switch switch-status">
                                                    <input type="checkbox" class="date-status"
                                                        id="{{ $d_date['id'] }}"
                                                        {{ $d_date->status == 1 ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm edit" style="cursor: pointer;"
                                                    title="{{ \App\CPU\translate('Edit') }}"
                                                    href="{{ route('admin.doctor.edit-date', [$d_date['id']]) }}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm delete" style="cursor: pointer;"
                                                    title="{{ \App\CPU\translate('Delete') }}"
                                                    id="{{ $d_date['id'] }}">
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
                        {{-- {{ $specialties->links() }} --}}
                    </div>
                    @if (count($doctor_dates) == 0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{ asset('public/assets/back-end') }}/svg/illustrations/sorry.svg"
                                alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{ \App\CPU\translate('no_data_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        $(document).on('change', '.date-status', function() {
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
                url: "{{ route('admin.doctor.status-date') }}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function(data) {
                    if (data.success == true) {
                        toastr.success('{{ \App\CPU\translate('Status updated successfully') }}');
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
                        url: "{{ route('admin.doctor.delete-date') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: function() {
                            toastr.success(
                                '{{ \App\CPU\translate('speciality_deleted_Successfully.') }}'
                                );
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });
    </script>
@endpush
