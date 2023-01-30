@foreach ($productReviews as $productReview)
<div class="p-2" style="margin-bottom: 20px">
    <div class="row product-review d-flex ">
        <div
            class="col-md-3 d-flex mb-3 {{Session::get('direction') === "rtl" ? 'pl-5' : 'pr-5'}}">
            <div
                class="media media-ie-fix  {{Session::get('direction') === "rtl" ? 'ml-4 pl-2' : 'mr-4 pr-2'}}">
                <img style="max-height: 64px;"
                    class="rounded-circle" width="64"
                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                    src="{{asset("storage/app/public/profile")}}/{{(isset($productReview->user)?$productReview->user->image:'')}}"
                    alt="{{isset($productReview->user)?$productReview->user->f_name:'not exist'}}"/>
                <div
                    class="media-body {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}} text-body">
                    <span class="font-size-sm mb-0 text-body" style="font-weight: 700;font-size: 12px;">{{isset($productReview->user)?$productReview->user->f_name:'not exist'}}</span>
                    <div class="d-flex ">
                        
                        <div class=" {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">
                            
                                    <i class="sr-star czi-star-filled active"></i>
                                
                        </div>
                        <div
                            class="text-body" style="font-weight: 400;font-size: 15px;">{{$productReview->rating}}/{{\App\CPU\translate('5')}} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <p class="mb-2 text-body" style="word-wrap:break-word;">{{$productReview->comment}}</p>
            @if (!empty(json_decode($productReview->attachment)))
                @foreach (json_decode($productReview->attachment) as $key => $photo)
                    <img
                        style="cursor: pointer;border-radius: 5px;border:1px;border-color: #7a6969; height: 67px ; margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 5px;"
                        onclick="showInstaImage('{{asset("storage/app/public/review/$photo")}}')"
                        class="cz-image-zoom"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset("storage/app/public/review/$photo")}}"
                        alt="Product review" width="67">
                @endforeach
            @endif
        </div>
        <div class="col-md-2 text-body">
            <span style="float: right;font-weight: 400;font-size: 13px;">{{$productReview->created_at->format('M-d-Y')}}</span>
        </div>
    </div>
</div>
@endforeach