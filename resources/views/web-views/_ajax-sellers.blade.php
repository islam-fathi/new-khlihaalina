@foreach ($sellers as $seller)
    @if (!empty($seller['seller_id']))
        @php($sel = $seller->seller_id)
    @endif
    <div
        class=" {{ Request::is('sellers*') ? 'col-lg-3 col-md-4 col-sm-4 col-6' : 'col-lg-2 col-md-3 col-sm-4 col-6' }} {{ Request::is('shopView*') ? 'col-lg-3 col-md-4 col-sm-4 col-6' : '' }} mb-2 p-2">
        @if (!empty($sel))
            <style>
                .quick-view {
                    display: none;
                    padding-bottom: 8px;
                }

                .quick-view,
                .single-product-details {
                    background: #ffffff;
                }

                .product-single-hover:hover>.single-product-details {

                    margin-top: -39px;
                }

                .product-single-hover:hover>.quick-view {
                    display: block;
                }
            </style>

            <div class="product-single-hover" style="">
                <div class=" inline_product clickable d-flex justify-content-center"
                    style="cursor: pointer;background:{{ $web_config['primary_color'] }}10;border-radius: 5px 5px 0px 0px;">
                    <div class="d-flex d-block" style="cursor: pointer;">
                        <a href="{{ route('shopView', $seller->seller_id) }}">
                            <img src="{{asset("storage/app/public/shop/$seller->image")}}"
                                onerror="this.src='{{ asset('public/assets/front-end/img/image-place-holder.png') }}'"
                                style="width: 100%;border-radius:5px 5px 0px 0px;">
                        </a>
                    </div>
                </div>
                <div class="single-product-details"
                    style="position:relative;height:145px;padding-top:10px;border-radius:0px 0px 5px 5px; ">
                    <div class="text-{{ Session::get('direction') === 'rtl' ? 'right pr-3' : 'left pl-3' }}">
                        <a href="{{ route('shopView', $seller->seller_id) }}">
                            {{ Str::limit($seller['name'], 23) }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach

<div class="col-12">
    <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation" id="paginator-ajax">
        {{-- {!! $sellers->links() !!} --}}
    </nav>
</div>
