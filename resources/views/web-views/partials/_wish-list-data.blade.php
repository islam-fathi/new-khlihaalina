<style>

    body {
        font-family: 'Titillium Web', sans-serif
    }

    .card {
        border: none
    }

    .totals tr td {
        font-size: 13px
    }

    .footer span {
        font-size: 12px
    }

    .product-qty span {
        font-size: 12px;
        color: #6A6A6A;
    }

    .font-name {
        font-weight: 600;
        font-size: 15px;
        color: #030303;
    }

    .sellerName {

        font-weight: 600;
        font-size: 14px;
        color: #030303;
    }

    .wishlist_product_img img {
        margin: 15px;
    }

    @media (max-width: 600px) {
        .font-name {
            font-size: 12px;
            font-weight: 400;
        }

        .amount {
            font-size: 12px;
        }
    }

    @media (max-width: 600px) {
        .wishlist_product_img {
            width: 20%;
        }

        .forPadding {
            padding: 6px;
        }

        .sellerName {

            font-weight: 400;
            font-size: 12px;
            color: #030303;
        }

        .wishlist_product_desc {
            width: 50%;
            margin-top: 0px !important;
        }

        .wishlist_product_icon {
            margin-left: 1px !important;
        }

        .wishlist_product_btn {
            width: 30%;
            margin-top: 10px !important;
        }

        .wishlist_product_img img {
            margin: 8px;
        }
    }
</style>
@if($wishlists->count()>0)
    @foreach($wishlists as $wishlist)
        @php($product = $wishlist->product_full_info)
        @if( $wishlist->product_full_info)
            <div class="card box-shadow-sm mt-2">
                <div class="product mb-2">
                    <div class="card">
                        <div class="row forPadding">
                            <div class="wishlist_product_img col-md-2 col-lg-2 col-sm-2">
                                <a href="{{route('product',$product->slug)}}">
                                    <img
                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                        >
                                </a>
                            </div>
                            <div class="wishlist_product_desc col-md-6 mt-4 {{Session::get('direction') === "rtl" ? 'pr-4' : 'pl-4'}}">
                                <span class="font-name">
                                    <a href="{{route('product',$product['slug'])}}">{{$product['name']}}</a>
                                </span>
                                <br>
                                <span
                                    class="sellerName"> {{\App\CPU\translate('Brand')}} :{{$product->brand?$product->brand['name']:''}} </span>
                    
                                <div class="">
                                    @if($product->discount > 0)
                                    <strike style="color: #E96A6A;" class="{{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-3'}}">
                                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                    </strike>
                                @endif
                                <span
                                    class="font-weight-bold amount">{{\App\CPU\Helpers::get_price_range($product) }}</span>
                                </div>
                            </div>
                            <div
                                class="wishlist_product_btn col-md-4 mt-5 float-right bodytr font-weight-bold"
                                style="color: #92C6FF;">

                                <a href="javascript:" class="wishlist_product_icon ml-2 pull-right mr-3">
                                    <i class="czi-close-circle" onclick="removeWishlist('{{$product['id']}}')"
                                       style="color: red"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <span class="badge badge-danger">{{\App\CPU\translate('item_removed')}}</span>
        @endif
    @endforeach
@else
    <center>
        <h6 class="text-muted">
            {{\App\CPU\translate('No data found')}}.
        </h6>
    </center>
@endif
