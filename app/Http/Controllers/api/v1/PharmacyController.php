<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Pharmacies;
use App\Model\PharmaciesOrders;
use App\Model\ReviewsOtherType; 
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function App\CPU\translate;

class PharmacyController extends Controller
{
    public function get_all()  
    {
        try {
            $default_city = Helpers::default_city();
            $pharmacies = Pharmacies::with(['cities'])->where('city', $default_city)->get(); 
            // $pharmacies['pharmacies'] = Helpers::decode_images_formatting($pharmacies, true);
            return response()->json($pharmacies, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        } 
    }

    public function get_pharmacy($id){
        try {
            $pharmacy = Pharmacies::with(['cities'])->where("id" , $id)->get();
            // $pharmacy['pharmacy'] = Helpers::decode_images_formatting($pharmacy, true);
            return response()->json($pharmacy, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    } 

    public function pharmacy_order(Request $request){
        $validator = Validator::make($request->all(), [ 
            'pharmacy_id'   => 'required',
            'name'          => 'required',
            'phone'         => 'required',
            'prescription_image'=> 'required',
        ], [
            'pharmacy_id.required'  => 'Pharmacy Name is required!',
            'request_by_id.required'=> 'User Created is required!',
            'name.required'         => 'Name is required!',
            'phone.required'        => 'Phone is Required',
            'prescription_image.required' => 'Prescription image is required!',
        ]);
        
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        
        $pharmaciesOrders  = new PharmaciesOrders();
        $pharmaciesOrders->pharmacy_id          = $request->pharmacy_id; 
        $pharmaciesOrders->request_by_id        = $request->user()->id;
        $pharmaciesOrders->name                 = $request->name;
        $pharmaciesOrders->email                = $request->email;
        $pharmaciesOrders->phone                = $request->phone;
        $pharmaciesOrders->prescription_image   = ImageManager::upload('pharmacies/prescription_image/', 'png', $request->prescription_image);
        $pharmaciesOrders->message              = $request->message;
        $pharmaciesOrders->order_date           = now();
        $pharmaciesOrders->order_status         = 'pending';
        $pharmaciesOrders->save();

        $return = [
            'status' => 1,
            'message' => 'successfully_added!'
        ];
        return response()->json($return, 200);
    }

    public function get_orders_list(Request $request)
    { 
        $orders = PharmaciesOrders::with('pharmacy')->where(['request_by_id' => $request->user()->id])->get();
        $orders->map(function ($data) { 
            return $data;
        });
        return response()->json($orders, 200);
    }

    public function get_order(Request $request , $id)
    { 
        $order = PharmaciesOrders::with(['pharmacy'])->where('id', $id)->where(['request_by_id' => $request->user()->id])->first();
        return response()->json($order, 200);
    }

    public function order_cancel(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $order = PharmaciesOrders::where(['id' => $request->order_id])->first();
        if($order['request_by_id'] == $request->user()->id){
            if ($order['order_status'] == 'pending') {
                PharmaciesOrders::where(['id' => $request->order_id])->update([
                    'order_status' => 'canceled'
                ]);
                
                return response()->json(translate('order_canceled_successfully'), 200);
            }
            
            return response()->json(translate('status_not_changable_now'), 302);
        }else{
            return response()->json(translate('this_order_did_not_requested_by_you'), 302);
        }
        
    }

    public function get_pharmacy_reviews($id)
    {
        $reviews = ReviewsOtherType::with(['customer'])->where('type','pharmacy')->where(['type_id' => $id])->get();

        $storage = [];
        foreach ($reviews as $item) {
            $item['attachment'] = json_decode($item['attachment']);
            array_push($storage, $item);
        }

        return response()->json($storage, 200);
    }

    public function get_pharmacy_rating($id)
    {
        try {
            $pharmacy = Pharmacies::find($id);
            $overallRating = \App\CPU\ProductManager::get_overall_rating($pharmacy->reviews);
            return response()->json(strval(floatval($overallRating[0])), 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function counter($pharmacy_id)
    {
        try {
            $countOrder = PharmaciesOrders::where('pharmacy_id', $pharmacy_id)->count();
            return response()->json(['order_count' => $countOrder], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function social_share_link($pharmacy_id) 
    {
        $pharmacy = Pharmacies::where('id', $pharmacy_id)->first();
        $link = route('pharmacyView', $pharmacy_id);
        try {

            return response()->json($link, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function submit_pharmacy_review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'comment' => 'required',
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $image_array = [];
        if (!empty($request->file('fileUpload'))) {
            foreach ($request->file('fileUpload') as $image) {
                if ($image != null) {
                    array_push($image_array, ImageManager::upload('review_other_type/', 'png', $image));
                }
            }
        }

        $review = new ReviewsOtherType;
        $review->type = "pharmacy";
        $review->customer_id = $request->user()->id;
        $review->type_id = $request->type_id;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->attachment = json_encode($image_array);
        $review->save();

        return response()->json(['message' => translate('successfully review submitted!')], 200);
    }
}
