<style>
    .btn-check {
        position: absolute;
        clip: rect(0, 0, 0, 0);
        pointer-events: none;
    }

    .choice-input {
        width: 7rem;
    }

    .addon-input {
        height: 7rem;
        width: 7rem;
    }

    .addon-quantity-input {
        height: 2rem;
        width: 7rem;
        z-index: 9;
        bottom: 1rem;
        visibility: hidden;
    }

    .check-label {
        background-color: #F3F3F3;
        color: #000000;
        border-width: 2px;
        border-color: #BABFC4;
        font-weight: bold;
    }

    .btn-check:checked + .check-label {
        background-color: #EF7822;
        color: #FFFFFF;
        border: none;
    }
    .color-border{
        border-color: #ffffff;
    }
    .border-add{
        border-color: #ff0303 !important;
        border:2px;
        border-style:solid;
    }
    
}
</style>
<div class="modal-header p-2">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="d-flex flex-row">
        <!-- Product gallery-->
        <div class="d-flex align-items-center justify-content-center active" style="height:9.5rem;">
            <img class="img-responsive" style="height:100%;width:auto;overflow:hidden;border-radius: 5%;"
                src="{{asset('storage/app/public/product/thumbnail')}}/{{$product->thumbnail}}"
                 onerror="this.src='{{asset('public/assets/back-end/img/160x160/img2.jpg')}}'"
                 data-zoom="{{asset('storage/app/public/product')}}/{{$product['image']}}"
                 alt="Product image" width="">
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="details pl-2">
            <a href="#" class="h3 mb-2 product-title">{{ Str::limit($product->name, 26) }}</a>

            <div class="mb-3 text-dark">
                <span class="h3 font-weight-normal text-accent mr-1">
                    {{\App\CPU\Helpers::get_price_range($product) }}
                </span>
                @if($product->discount > 0)
                    <strike style="font-size: 12px!important;">
                        {{ \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['unit_price'])) }}
                    </strike>
                @endif
            </div>

            @if($product->discount > 0)
                <div class="mb-3 text-dark">
                    <strong>Discount : </strong>
                    <strong
                        id="set-discount-amount">{{\App\CPU\BackEndHelper::usd_to_currency(\App\CPU\Helpers::get_product_discount($product, $product['unit_price']))}}</strong>
                </div>
            @endif
        
            
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <?php
            $cart = false;
            if (session()->has('cart')) {
                foreach (session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $product['id']) {
                        $cart = $cartItem;
                    }
                }
            }

            ?>
            <h2>{{__('messages.description')}}</h2>
            <span class="d-block text-dark">
                {!! $product->description !!}
            </span>
            <form id="add-to-cart-form" class="mb-2">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="position-relative {{Session::get('direction') === "rtl" ? 'ml-n4' : 'mr-n4'}} mb-3">
                    @if (count(json_decode($product->colors)) > 0)
                        <div class="flex-start">
                            <div class="product-description-label mt-2">{{\App\CPU\translate('color')}}:
                            </div>
                            <div class="d-flex justify-content-left flex-wrap" id="option1">
                                @foreach (json_decode($product->colors) as $key => $color)          
                                    <input class="btn-check" type="radio" onclick="color_change(this);"
                                            id="{{ $product->id }}-color-{{ $key }}"
                                            name="color" value="{{ $color }}"
                                            @if($key == 0) checked @endif autocomplete="off">
                                    <label id="label-{{ $product->id }}-color-{{ $key }}" class="btn m-2 color-border {{$key==0?'border-add':""}}" style="background: {{ $color }};"
                                            for="{{ $product->id }}-color-{{ $key }}"
                                            data-toggle="tooltip"></label> 
                                @endforeach
                            
                            </div>
                        </div>
                    @endif
                    @php
                        $qty = 0;
                        if(!empty($product->variation)){
                        foreach (json_decode($product->variation) as $key => $variation) {
                                $qty += $variation->qty;
                            }
                        }
                    @endphp
                </div>
                @foreach (json_decode($product->choice_options) as $key => $choice)

                    <div class="h3 p-0 pt-2">{{ $choice->title }}
                    </div>

                    <div class="d-flex justify-content-left flex-wrap">
                        @foreach ($choice->options as $key => $option)
                            <input class="btn-check" type="radio"
                                   id="{{ $choice->name }}-{{ $option }}"
                                   name="{{ $choice->name }}" value="{{ $option }}"
                                   @if($key == 0) checked @endif autocomplete="off">
                            <label class="btn btn-sm check-label mx-1 choice-input"
                                   for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                        @endforeach
                    </div>
                @endforeach

            <!-- Quantity + Add to cart -->
                <div class="d-flex justify-content-between">
                    <div class="product-description-label mt-2 text-dark h3">{{__('Quantity')}}:</div>
                    <div class="product-quantity d-flex align-items-center">
                        <div class="input-group input-group--style-2 pr-3"
                             style="width: 160px;">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark" type="button"
                                        data-type="minus" data-field="quantity"
                                        disabled="disabled" style="padding: 10px">
                                        <i class="tio-remove  font-weight-bold"></i>
                                </button>
                            </span>
                            <input type="text" name="quantity"
                                   class="form-control input-number text-center cart-qty-field"
                                   placeholder="1" value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark" type="button" data-type="plus"
                                        data-field="quantity" style="padding: 10px">
                                        <i class="tio-add  font-weight-bold"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="row no-gutters mt-2 text-dark" id="chosen_price_div">
                    <div class="col-2">
                        <div class="product-description-label">Total Price:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong id="chosen_price"></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    <button class="btn btn-primary"
                            onclick="addToCart()"
                            type="button"
                            style="width:37%; height: 45px">
                        <i class="tio-shopping-cart"></i>
                        {{trans('messages.add')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function () {
        getVariantPrice();
    });
</script>
<script>
    function color_change(val)
    {
        console.log(val.id);
        $('.color-border').removeClass("border-add");
        $('#label-'+val.id).addClass("border-add");
    }
</script>

