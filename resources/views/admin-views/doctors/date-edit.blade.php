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
                        <form action="{{ route('admin.doctor.update-date', [$doctor_date['id']]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <div class="form-group" >
                                        <label class="input-label" for="exampleFormControlInput1">{{ \App\CPU\translate('Doctor Date') }}</label>
                                        <select name="day_name" class="form-control" >
                                            <option value="Saturday" {{ $doctor_date['day_name'] == "Saturday" ? 'selected' : '' }}>{{ \App\CPU\translate('Saturday') }}</option>
                                            <option value="Sunday" {{ $doctor_date['day_name'] == "Sunday" ? 'selected' : '' }}>{{ \App\CPU\translate('Sunday') }}</option>
                                            <option value="Monday" {{ $doctor_date['day_name'] == "Monday" ? 'selected' : '' }}>{{ \App\CPU\translate('Monday') }}</option>
                                            <option value="Tuesday" {{ $doctor_date['day_name'] == "Tuesday" ? 'selected' : '' }}>{{ \App\CPU\translate('Tuesday') }}</option>
                                            <option value="Wednesday" {{ $doctor_date['day_name'] == "Wednesday" ? 'selected' : '' }}>{{ \App\CPU\translate('Wednesday') }}</option>
                                            <option value="Thursday" {{ $doctor_date['day_name'] == "Thursday" ? 'selected' : '' }}>{{ \App\CPU\translate('Thursday') }}</option>
                                            <option value="Friday" {{ $doctor_date['day_name'] == "Friday" ? 'selected' : '' }}>{{ \App\CPU\translate('Friday') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{ \App\CPU\translate('Doctor Start Time') }}</label>
                                        <input type="time" name="start_time" class="form-control" value="{{$doctor_date['start_time']}}" placeholder="{{ \App\CPU\translate('New') }} {{ \App\CPU\translate('Doctor Start Time Like 00:00 AM') }}" >
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{ \App\CPU\translate('Doctor End Time') }}</label>
                                        <input type="time" name="end_time" class="form-control" value="{{$doctor_date['end_time']}}" placeholder="{{ \App\CPU\translate('New') }} {{ \App\CPU\translate('Doctor End Time Like 00:00 PM') }}" >
                                    </div>
                                    <input type="hidden" name="doctor_id" value="{{$doctor_date['doctor_id']}}">
                                    <button type="submit" class="btn btn-primary float-right">{{ \App\CPU\translate('submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
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
