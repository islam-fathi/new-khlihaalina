@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Coupon Edit'))
@push('css_or_js')
    <link href="{{ asset('public/assets/back-end') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i> {{ \App\CPU\translate('Coupon') }}
                        {{ \App\CPU\translate('update') }}</h1>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <form action="{{ route('admin.coupon.update', [$c['id']]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Type') }}</label>
                                        <select class="form-control" name="coupon_type" style="width: 100%" required>
                                            {{-- <option value="delivery_charge_free">Delivery Charge Free</option> --}}
                                            <option value="discount_on_purchase"
                                                {{ $c['coupon_type'] == 'discount_on_purchase' ? 'selected' : '' }}>
                                                {{ \App\CPU\translate('Discount on Purchase') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Title') }}</label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            value="{{ $c['title'] }}" placeholder="{{ \App\CPU\translate('Title') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Code') }}</label>
                                        <input type="text" name="code" value="{{ $c['code'] }}"
                                            class="form-control" id="code" placeholder="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('start_date') }}</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            value="{{ date('Y-m-d', strtotime($c['start_date'])) }}"
                                            placeholder="{{ \App\CPU\translate('start date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('expire_date') }}</label>
                                        <input type="date" name="expire_date" class="form-control" id="expire_date"
                                            value="{{ date('Y-m-d', strtotime($c['expire_date'])) }}"
                                            placeholder="{{ \App\CPU\translate('expire date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">{{ \App\CPU\translate('limit') }}
                                            {{ \App\CPU\translate('for') }} {{ \App\CPU\translate('same') }}
                                            {{ \App\CPU\translate('user') }}</label>
                                        <input type="number" name="limit" value="{{ $c['limit'] }}" id="coupon_limit"
                                            class="form-control"
                                            placeholder="{{ \App\CPU\translate('EX') }}: {{ \App\CPU\translate('10') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('discount_type') }}</label>
                                        <select id="discount_type" class="form-control" name="discount_type"
                                            onchange="checkDiscountType(this.value)" style="width: 100%">
                                            <option value="amount" {{ $c['discount_type'] == 'amount' ? 'selected' : '' }}>
                                                {{ \App\CPU\translate('Amount') }}</option>
                                            <option value="percentage"
                                                {{ $c['discount_type'] == 'percentage' ? 'selected' : '' }}>
                                                {{ \App\CPU\translate('percentage') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Discount') }}</label>
                                        <input type="number" min="0" max="1000000" step=".01" name="discount"
                                            class="form-control" id="discount"
                                            value="{{ $c['discount_type'] == 'amount' ? \App\CPU\Convert::default($c['discount']) : $c['discount'] }}"
                                            placeholder="{{ \App\CPU\translate('discount') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label for="name">{{ \App\CPU\translate('minimum_purchase') }}</label>
                                    <input type="number" min="0" max="1000000" step=".01" name="min_purchase"
                                        class="form-control" id="minimum purchase"
                                        value="{{ \App\CPU\Convert::default($c['min_purchase']) }}"
                                        placeholder="{{ \App\CPU\translate('minimum purchase') }}" required>
                                </div>
                                <div id="max-discount" class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('maximum_discount') }}</label>
                                        <input type="number" min="0" max="1000000" step=".01"
                                            name="max_discount" class="form-control" id="maximum discount"
                                            value="{{ \App\CPU\Convert::default($c['max_discount']) }}"
                                            placeholder="{{ \App\CPU\translate('maximum discount') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('City') }}</label>
                                        <select class="form-control" name="city" style="width: 100%">
                                            <option value="0" selected disabled>
                                                ---{{ \App\CPU\translate('select') }}---</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ $c['city'] == $city->id ? 'selected' : '' }}> {{ $city->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit"
                                    class="btn btn-primary float-right">{{ \App\CPU\translate('Submit') }}</button>
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
            let discount_type = $('#discount_type').val();
            if (discount_type == 'amount') {
                $('#max-discount').hide()
            } else if (discount_type == 'percentage') {
                $('#max-discount').show()
            }
            $('#start_date').attr('min', (new Date()).toISOString().split('T')[0]);
            $('#expire_date').attr('min', (new Date()).toISOString().split('T')[0]);
        });

        $("#start_date").on("change", function() {
            $('#expire_date').attr('min', $(this).val());
        });

        $("#expire_date").on("change", function() {
            $('#start_date').attr('max', $(this).val());
        });


        function checkDiscountType(val) {
            if (val == 'amount') {
                $('#max-discount').hide()
            } else if (val == 'percentage') {
                $('#max-discount').show()
            }
        }
    </script>
    <script src="{{ asset('public/assets/back-end') }}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>
@endpush
