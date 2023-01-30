<div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
    <!-- Card -->
    <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['pending'])}}" style="background: #FFFFFF">
        <div class="card-body">
            <div class="flex-between align-items-center mb-1">
                <div style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <h6 class="card-subtitle" style="color: #F14A16!important;">{{\App\CPU\translate('pending')}}</h6>
                    <span class="card-title h2" style="color: #F14A16!important;">
                        {{$data['pending']}}
                    </span>
                </div>
                <div class="mt-2">
                    <i class="tio-shopping-cart" style="font-size: 30px;color: #F14A16;"></i>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
    <!-- Card -->
    <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['confirmed'])}}" style="background: #FFFFFF;">
        <div class="card-body">
            <div class="flex-between align-items-center mb-1">
                <div style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <h6 class="card-subtitle" style="color: #F14A16!important;">{{\App\CPU\translate('confirmed')}}</h6>
                     <span class="card-title h2" style="color: #F14A16!important;">
                         {{$data['confirmed']}}
                     </span>
                </div>

                <div class="mt-2">
                    <i class="tio-checkmark-circle" style="font-size: 30px;color: #F14A16"></i>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
    <!-- Card -->
    <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['processing'])}}" style="background: #FFFFFF">
        <div class="card-body">
            <div class="flex-between align-items-center gx-2 mb-1">
                <div style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <h6 class="card-subtitle" style="color: #F14A16!important;">{{\App\CPU\translate('Processing')}}</h6>
                    <span class="card-title h2" style="color: #F14A16!important;">
                        {{$data['processing']}}
                    </span>
                </div>

                <div class="mt-2">
                    <i class="tio-time" style="font-size: 30px;color: #F14A16"></i>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
    <!-- Card -->
    <a class="card card-hover-shadow h-100" href="{{route('admin.orders.list',['out_for_delivery'])}}" style="background: #FFFFFFff">
        <div class="card-body">
            <div class="flex-between align-items-center gx-2 mb-1">
                <div style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <h6 class="card-subtitle" style="color: #F14A16!important;">{{\App\CPU\translate('out_for_delivery')}}</h6>
                    <span class="card-title h2" style="color: #F14A16!important;">
                        {{$data['out_for_delivery']}}
                    </span>
                </div>

                <div class="mt-2">
                    <i class="tio-bike" style="font-size: 30px;color: #F14A16"></i>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </a>
    <!-- End Card -->
</div>

<div class="col-12">
    <div class="card card-body" style="background: #FFFFFF!important;">
        <div class="row gx-lg-4">
            <div class="col-sm-6 col-lg-3">
                <div class="media flex-between align-items-center" style="cursor: pointer"
                     onclick="location.href='{{route('admin.orders.list',['delivered'])}}'">
                    <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <h6 class="card-subtitle">{{\App\CPU\translate('delivered')}}</h6>
                        <span class="card-title h3">{{$data['delivered']}}</span>
                    </div>
                    <div>
                        <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                            <i class="tio-checkmark-circle-outlined"></i>
                        </span>
                    </div>
                </div>
                <div class="d-lg-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-sm">
                <div class="media flex-between align-items-center" style="cursor: pointer"
                     onclick="location.href='{{route('admin.orders.list',['canceled'])}}'">
                    <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <h6 class="card-subtitle">{{\App\CPU\translate('canceled')}}</h6>
                        <span class="card-title h3">{{$data['canceled']}}</span>
                    </div>
                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                      <i class="tio-remove-from-trash"></i>
                    </span>
                </div>
                <div class="d-lg-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-lg">
                <div class="media flex-between align-items-center" style="cursor: pointer"
                     onclick="location.href='{{route('admin.orders.list',['returned'])}}'">
                    <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <h6 class="card-subtitle">{{\App\CPU\translate('returned')}}</h6>
                        <span class="card-title h3">{{$data['returned']}}</span>
                    </div>
                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                      <i class="tio-history"></i>
                    </span>
                </div>
                <div class="d-lg-none">
                    <hr>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 column-divider-sm">
                <div class="media flex-between align-items-center" style="cursor: pointer"
                     onclick="location.href='{{route('admin.orders.list',['failed'])}}'">
                    <div class="media-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <h6 class="card-subtitle">{{\App\CPU\translate('failed')}}</h6>
                        <span
                            class="card-title h3">{{$data['failed']}}</span>
                    </div>
                    <span class="icon icon-sm icon-soft-secondary icon-circle ml-3">
                      <i class="tio-message-failed"></i>
                    </span>
                </div>
                <div class="d-lg-none">
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
