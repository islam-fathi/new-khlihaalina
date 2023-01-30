@foreach($products as $product)
    @if(!empty($product['product_id']))
        @php($product=$product->product)
    @endif
    <div class=" {{Request::is('products*')?'col-lg-3 col-md-4 col-sm-4 col-6':'col-lg-2 col-md-3 col-sm-4 col-6'}} {{Request::is('shopView*')?'col-lg-3 col-md-4 col-sm-4 col-6':''}} mb-2 p-2">
        @if(!empty($product))
            @include('web-views.partials._filter-single-product',['p'=>$product])
        @endif
    </div>
@endforeach

<div class="col-12">
    <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation"
         id="paginator-ajax">
        {!! $products->links() !!}
    </nav>
</div>
