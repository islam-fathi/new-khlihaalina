@extends('layouts.front-end.app')

@section('title','Track Order')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="{{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="{{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>
@endpush

@section('content')
    <!-- Order Details Modal-->
    <?php
    $order = \App\Model\OrderDetail::where('order_id', $orderDetails->id)->get();
    ?>
    <div class="modal fade" id="order-details">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order No - {{$orderDetails['id']}}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body pb-0">
                    @php( $totalTax = 0)

                    @php($sub_total=0)
                    @php($total_tax=0)
                    @php($total_shipping_cost=0)
                    @php($total_discount_on_product=0)
                    @php($extra_discount=0)
                    @php($coupon_discount=0)
                    @foreach($order as $product)
                        @php($productDetails = App\Model\Product::where('id', $product->product_id)->first())

                        <div class="d-sm-flex justify-content-between mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="media d-block d-sm-flex text-center text-sm-left">
                                <a class="d-inline-block mx-auto mr-sm-4"
                                   href="{{route('product',$productDetails->slug)}}" style="width: 10rem;">
                                    <img
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$productDetails['thumbnail']}}">
                                </a>
                                <div class="media-body pt-2">
                                    <h4 class="product-title font-size-base mb-2"><a
                                            href="{{route('product',$productDetails->slug)}}">{{$productDetails['name']}}</a>
                                    </h4>
                                    @if($product['variation'])
                                        @foreach(json_decode($product['variation'],true) as $key1 =>$variation)
                                            <div class="text-muted"><span
                                                    class="mr-2">{{$key1}} :</span>{{$variation}}</div>
                                        @endforeach
                                    @endif
                                    <div
                                        class="font-size-lg text-accent pt-2">{{\App\CPU\Helpers::currency_converter($product['price'])}}</div>
                                </div>
                            </div>
                            <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">Quantity:</div>{{$product['qty']}}
                            </div>
                            <div class="pt-2 pl-sm-2 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">Tax:
                                </div>{{\App\CPU\Helpers::currency_converter($product['tax'])}}
                            </div>
                            <div class="pt-2 pl-sm-3 mx-auto mx-sm-0 text-center">
                                <div class="text-muted mb-2">Subtotal</div>{{\App\CPU\Helpers::currency_converter($product['price']*$product['qty'])}}
                            </div>
                        </div>
                        @php($sub_total+=$product['price']*$product['qty'])
                        @php($total_tax+=$product['tax'])
                        @php($total_discount_on_product+=$product['discount'])
                    @endforeach

                    @php($total_shipping_cost=$orderDetails['shipping_cost'])
                    
                    <?php
                            if ($orderDetails['extra_discount_type'] == 'percent') {
                                $extra_discount = ($sub_total / 100) * $orderDetails['extra_discount'];
                            } else {
                                $extra_discount = $orderDetails['extra_discount'];
                            }
                            if(isset($orderDetails['discount_amount'])){
                                $coupon_discount =$orderDetails['discount_amount'];
                            }
                        ?>
                </div>
                <!-- Footer-->
                <div class="modal-footer flex-wrap justify-content-between bg-secondary font-size-md">
                    
                        <div class="px-2 py-1">
                            <span
                                class="text-muted">Subtotal:&nbsp;</span>{{\App\CPU\Helpers::currency_converter($sub_total)}}
                            <span></span>
                        </div>
                        <div class="px-2 py-1">
                            <span
                                class="text-muted">Shipping:&nbsp;</span>{{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
                            <span></span>
                        </div>
                        <div class="px-2 py-1">
                            <span class="text-muted">Tax:&nbsp;</span> {{\App\CPU\Helpers::currency_converter($total_tax)}}
                            <span></span>
                        </div>
    
                        <div class="px-2 py-1">
                            <span
                                class="text-muted">Discount:&nbsp;</span>
                            - {{\App\CPU\Helpers::currency_converter($total_discount_on_product)}}
                            <span></span>
                        </div>
                </div>
                <div class="modal-footer flex-wrap justify-content-between bg-secondary font-size-md">
                    <div class="px-2 py-1">
                        <span
                            class="text-muted">Coupon Discount:&nbsp;</span>
                        - {{\App\CPU\Helpers::currency_converter($coupon_discount)}}
                        <span></span>
                    </div>
                    @if ($orderDetails['order_type'] == 'POS')
                    <div class="px-2 py-1">
                        <span
                            class="text-muted">Extra Discount:&nbsp;</span>
                        - {{\App\CPU\Helpers::currency_converter($extra_discount)}}
                        <span></span>
                    </div>
                    @endif
                    <div class="px-2 py-1">
                        <span class="text-muted">Total:&nbsp; </span>
                        <span class="font-size-lg">
                             {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-($orderDetails->discount)-$total_discount_on_product - $coupon_discount - $extra_discount)}}
                        </span>
                    </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Page Title (Dark)-->
    <div class="container">

        <div class="pt-3 pb-3">
            <h2>My Order</h2>
        </div>
        <div class="btn-primary">
            <div class="container d-lg-flex justify-content-between py-2 py-lg-3">

                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h4 class="text-light mb-0">Order ID : <span
                            class="h4 font-weight-normal text-light">{{$orderDetails['id']}}</span></h4>
                </div>
            </div>
        </div>

    </div>
    <!-- Page Content-->
    <div class="container mb-md-3">
        <!-- Details-->
        <div class="row" style="background: #e2f0ff; margin: 0; width: 100%;">
            <div class="col-sm-4">
                <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2">Order Status:</span><br>
                    <span class="text-uppercase ">{{$orderDetails['order_status']}}</span>
                    {{-- <span class="text-uppercase ">Courier</span> --}}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2">Payment Status:</span> <br>
                    <span class="text-uppercase">{{$orderDetails['payment_status']}}</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="pt-2 pb-2 text-center rounded-lg">
                    <span class="font-weight-medium text-dark mr-2"> Estimated Delivary Date: </span> <br>
                    <span class="text-uppercase"
                          style="font-weight: 600; color: {{$web_config['primary_color']}}">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$orderDetails['updated_at'])->format('Y-m-d')}}</span>
                </div>
            </div>
        </div>
        <!-- Progress-->
        <div class="card border-0 box-shadow-lg mt-5">
            <div class="card-body pb-2">
                <ul class="nav nav-tabs media-tabs nav-justified">
                    @if ($orderDetails['order_status']!='returned' && $orderDetails['order_status']!='failed')

                        <li class="nav-item">
                            <div class="nav-link">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; background: #4bcc02; color: white;">
                                        <i class="czi-check"></i>
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">First step</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">Order placed</h6>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item ">
                            <div class="nav-link ">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; @if(($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered')) background: #4bcc02; color: white; @endif ">
                                        @if(($orderDetails['order_status']=='processing') || ($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered'))
                                            <i class="czi-check"></i>
                                        @endif
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">Second step</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">Processing order</h6>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <div class="nav-link  ">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; @if(($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered')) background: #4bcc02; color: white; @endif ">
                                        @if(($orderDetails['order_status']=='processed') || ($orderDetails['order_status']=='delivered'))
                                            <i class="czi-check"></i>
                                        @endif
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">Third step</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">Preparing Shipment</h6>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <div class="nav-link ">
                                <div class="align-items-center">
                                    <div class="media-tab-media"
                                         style="margin: 0 auto; @if(($orderDetails['order_status']=='delivered')) background: #4bcc02; color: white; @endif">
                                        @if(($orderDetails['order_status']=='delivered'))
                                            <i class="czi-check"></i>
                                        @endif
                                    </div>
                                    <div class="media-body" style="text-align: center;">
                                        <div class="media-tab-subtitle text-muted font-size-xs mb-1">Fourth step</div>
                                        <h6 class="media-tab-title text-nowrap mb-0">Order Shipped</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @elseif($orderDetails['order_status']=='returned')
                        <li class="nav-item">
                            <div class="nav-link" style="text-align: center;">
                                <h1 class="text-warning">Product Successfully Returned</h1>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <div class="nav-link" style="text-align: center;">
                                <h1 class="text-danger">Sorry we can't complete your order</h1>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <!-- Footer-->
        <div class="d-sm-flex flex-wrap justify-content-between align-items-center text-center pt-3">
            <div class="custom-control custom-checkbox mt-1 mr-3">
            </div>
            <a class="btn btn-primary btn-sm mt-2 mb-2" href="#order-details" data-toggle="modal">View Order Details</a>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
@endpush
