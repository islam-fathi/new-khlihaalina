<?php

namespace App\Http\Controllers\Web;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Review;
use App\Model\ReviewsOtherType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function App\CPU\translate;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $image_array = [];
        if ($request->has('fileUpload')) {
            foreach ($request->file('fileUpload') as $image) {
                array_push($image_array, ImageManager::upload('review/', 'png', $image));
            }
        }

        if (auth('customer')->check()) {
            $review = new Review;
            $review->customer_id = auth('customer')->id();
            $review->product_id = $request->product_id;
            $review->comment = $request->comment;
            $review->rating = $request->rating;
            $review->attachment = json_encode($image_array);
            $review->save();
            Toastr::success(translate('successfully_added_review'));
            return redirect()->route('account-order-details', ['id'=>$request->order_id]);
        } else {
            Toastr::error(translate('login_first'));
            return redirect()->back();
        }
    }

    public function other_type_store(Request $request)
    {
        $image_array = [];
        if ($request->has('fileUpload')) {
            foreach ($request->file('fileUpload') as $image) { 
                array_push($image_array, ImageManager::upload('review_other_type/', 'png', $image));
            }
        }

        if (auth('customer')->check()) {
            $review = new ReviewsOtherType;
            $review->type       = $request->type;
            $review->type_id    = $request->type_id;
            $review->customer_id = auth('customer')->id();
            $review->comment    = $request->comment;
            $review->rating     = $request->rating;
            $review->attachment = json_encode($image_array);
            $review->save();
            Toastr::success(translate('successfully_added_review'));
            if($request->type == "doctor"){
                return redirect()->route('doctor-appointment-details', ['id'=>$request->request_id]);
            }elseif($request->type == "pharmacy"){
                return redirect()->route('pharmacy-order-details', ['id'=>$request->request_id]);
            }elseif($request->type == "service"){
                return redirect()->route('service-order-details', ['id'=>$request->request_id]);
            }
        } else {
            Toastr::error(translate('login_first'));
            return redirect()->back();
        }
    }
}
