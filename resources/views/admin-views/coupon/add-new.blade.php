@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Coupon Add'))

@push('css_or_js')
    <link href="{{ asset('public/assets/back-end') }}/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> {{ \App\CPU\translate('Add') }}
                        {{ \App\CPU\translate('New') }} {{ \App\CPU\translate('Coupon') }}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Content Row -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    {{-- <div class="card-header">
                        {{\App\CPU\translate('coupon_form')}}
                    </div> --}}
                    <div class="card-body">
                        <form action="{{ route('admin.coupon.store-coupon') }}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Type') }}</label>
                                        <select class="form-control" name="coupon_type" style="width: 100%" required>
                                            {{-- <option value="delivery_charge_free">Delivery Charge Free</option> --}}
                                            <option value="discount_on_purchase">
                                                {{ \App\CPU\translate('Discount_on_Purchase') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Title') }}</label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="{{ \App\CPU\translate('Title') }}" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Code') }}</label>
                                        <input type="text" name="code"
                                            value="{{ \Illuminate\Support\Str::random(10) }}" class="form-control"
                                            id="code" placeholder="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('start_date') }}</label>
                                        <input id="start_date" type="date" name="start_date" class="form-control"
                                            placeholder="{{ \App\CPU\translate('start date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('expire_date') }}</label>
                                        <input id="expire_date" type="date" name="expire_date" class="form-control"
                                            placeholder="{{ \App\CPU\translate('expire date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">{{ \App\CPU\translate('limit') }}
                                            {{ \App\CPU\translate('for') }} {{ \App\CPU\translate('same') }}
                                            {{ \App\CPU\translate('user') }}</label>
                                        <input type="number" name="limit" id="coupon_limit" class="form-control"
                                            placeholder="{{ \App\CPU\translate('EX') }}: {{ \App\CPU\translate('10') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('discount_type') }}</label>
                                        <select id="discount_type" class="form-control" name="discount_type"
                                            onchange="checkDiscountType(this.value)" style="width: 100%">
                                            <option value="amount">{{ \App\CPU\translate('Amount') }}</option>
                                            <option value="percentage">{{ \App\CPU\translate('percentage') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('Discount') }}</label>
                                        <input type="number" min="1" max="1000000" name="discount"
                                            class="form-control" id="discount"
                                            placeholder="{{ \App\CPU\translate('discount') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label for="name">{{ \App\CPU\translate('minimum_purchase') }}</label>
                                    <input type="number" min="1" max="1000000" name="min_purchase"
                                        class="form-control" id="minimum purchase"
                                        placeholder="{{ \App\CPU\translate('minimum purchase') }}" required>
                                </div>
                                <div id="max-discount" class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('maximum_discount') }}</label>
                                        <input type="number" min="1" max="1000000" name="max_discount"
                                            class="form-control" id="maximum discount"
                                            placeholder="{{ \App\CPU\translate('maximum discount') }}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">Address</label>
                                        <input type="text" name="address" class="form-control" id="address" placeholder="Address">
                                    </div>
                                </div> --}}
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="name">{{ \App\CPU\translate('City') }}</label>
                                        <select class="form-control" name="city" style="width: 100%">
                                            <option value="0" selected disabled>
                                                ---{{ \App\CPU\translate('select') }}---</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"> {{ $city->name }} </option>
                                            @endforeach
                                        </select>
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
        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-lg-3 mb-3 mb-lg-0">
                                <h5>{{ \App\CPU\translate('coupons_table') }} <span
                                        style="color: red;">({{ $cou->total() }})</span>
                                </h5>
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
                                            placeholder="{{ \App\CPU\translate('Search by Title or Code or Discount Type') }}"
                                            value="{{ $search }}" aria-label="Search orders" required>
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
                            <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ \App\CPU\translate('SL') }}#</th>
                                        <th>{{ \App\CPU\translate('coupon_type') }}</th>
                                        <th>{{ \App\CPU\translate('Title') }}</th>
                                        <th>{{ \App\CPU\translate('Code') }}</th>
                                        <th>{{ \App\CPU\translate('user') }} {{ \App\CPU\translate('limit') }}</th>
                                        <th>{{ \App\CPU\translate('minimum_purchase') }}</th>
                                        <th>{{ \App\CPU\translate('maximum_discount') }}</th>
                                        <th>{{ \App\CPU\translate('Discount') }}</th>
                                        <th>{{ \App\CPU\translate('discount_type') }}</th>
                                        <th>{{ \App\CPU\translate('start_date') }}</th>
                                        <th>{{ \App\CPU\translate('expire_date') }}</th>
                                        <th>{{ \App\CPU\translate('city') }}</th>
                                        <th>{{ \App\CPU\translate('Status') }}</th>
                                        <th>{{ \App\CPU\translate('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cou as $k => $c)
                                        @php($city = \App\Model\City::find($c['city']))
                                        <tr>
                                            <td>{{ $cou->firstItem() + $k }}</td>
                                            <td style="text-transform: capitalize">
                                                {{ str_replace('_', ' ', $c['coupon_type']) }}</td>
                                            <td class="text-capitalize">
                                                {{ substr($c['title'], 0, 20) }}
                                            </td>
                                            <td>{{ $c['code'] }}</td>
                                            <td>{{ $c['limit'] }}</td>
                                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($c['min_purchase'])) }}
                                            </td>
                                            <td>{{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($c['max_discount'])) }}
                                            </td>
                                            <td>{{ $c['discount_type'] == 'amount' ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($c['discount'])) : $c['discount'] }}
                                            </td>
                                            <td>{{ $c['discount_type'] }}</td>
                                            <td>{{ date('d-M-y', strtotime($c['start_date'])) }}</td>
                                            <td>{{ date('d-M-y', strtotime($c['expire_date'])) }}</td>
                                            <td>{{ $city['name'] }}</td>
                                            <td>
                                                <label class="toggle-switch toggle-switch-sm">
                                                    <input type="checkbox" class="toggle-switch-input"
                                                        onclick="location.href='{{ route('admin.coupon.status', [$c['id'], $c->status ? 0 : 1]) }}'"
                                                        class="toggle-switch-input" {{ $c->status ? 'checked' : '' }}>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-primary btn-sm edit m-1"
                                                        href="{{ route('admin.coupon.update', [$c['id']]) }}"
                                                        title="{{ \App\CPU\translate('Edit') }}">
                                                        <i class="tio-edit"></i>
                                                    </a><br>
                                                    <a class="btn btn-danger btn-sm delete m-1" href="javascript:"
                                                        onclick="form_alert('coupon-{{ $c['id'] }}','Want to delete this coupon ?')"
                                                        title="{{ \App\CPU\translate('delete') }}">
                                                        <i class="tio-add-to-trash"></i>
                                                    </a>
                                                    <form action="{{ route('admin.coupon.delete', [$c['id']]) }}"
                                                        method="post" id="coupon-{{ $c['id'] }}">
                                                        @csrf @method('delete')
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $cou->links() }}
                    </div>
                    @if (count($cou) == 0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{ asset('public/assets/back-end') }}/svg/illustrations/sorry.svg"
                                alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{ \App\CPU\translate('No data to show') }}</p>
                        </div>
                    @endif
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
            //console.log(discount_type);
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
    {{-- <script>
         $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        function checkDiscountType(val) {
            if (val == 'amount') {
                $('#max-discount').hide()
            } else if (val == 'percentage') {
                $('#max-discount').show()
            }
        }
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
                url: "#",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data == 1) {
                        toastr.success('Coupon published successfully');
                    } else {
                        toastr.success('Coupon unpublished successfully');
                    }
                }
            });
        });

    </script> --}}
    <script src="{{ asset('public/assets/back-end') }}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <!-- Page level plugins -->
    <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('public/assets/back-end') }}/js/demo/datatables-demo.js"></script>
@endpush
