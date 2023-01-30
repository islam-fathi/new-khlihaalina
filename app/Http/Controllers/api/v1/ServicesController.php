<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Services;
use App\Model\ServicesOrders;
use App\Model\ReviewsOtherType;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function App\CPU\translate;

class ServicesController extends Controller 
{
    public function get_all() 
    {
        try {
            $default_city = Helpers::default_city();
            $Services = Services::with(['cities'])->where('city', $default_city)->get(); 
            // $Services['Services'] = Helpers::decode_images_formatting($Services, true);
            return response()->json($Services, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403); 
        }
    }

    public function get_service($id){
        try {
            $Service = Services::with(['cities'])->where("id" , $id)->get();
            // $Service['Service'] = Helpers::decode_images_formatting($Service, true);
            return response()->json($Service, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function service_order(Request $request){
        $validator = Validator::make($request->all(), [
            'service_id'    => 'required',
            'name'          => 'required',
            'phone'         => 'required',
            'subject'       => 'required',
        ], [
            'service_id.required'   => 'Server Name is required!',
            'request_by_id.required'=> 'User Created is required!',
            'name.required'         => 'Name is required!',
            'phone.required'        => 'Phone is Required',
            'subject.required'      => 'Subject is Required',
        ]);
        
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        
        $serviceOrder  = new ServicesOrders();
        $serviceOrder->service_id       = $request->service_id;
        $serviceOrder->request_by_id    = $request->user()->id; 
        $serviceOrder->name             = $request->name;
        $serviceOrder->email            = $request->email;
        $serviceOrder->phone            = $request->phone;
        $serviceOrder->subject          = $request->subject;
        $serviceOrder->message          = $request->message;
        $serviceOrder->order_date       = now();
        $serviceOrder->order_status     = 'pending';
        $serviceOrder->save();

        $return = [
            'status' => 1,
            'message' => 'successfully_added!'
        ];
        return response()->json($return, 200);
    }

    public function get_orders_list(Request $request)
    { 
        $orders = ServicesOrders::with(['service'])->where(['request_by_id' => $request->user()->id])->get();
        $orders->map(function ($data) {
            return $data;
        });
        return response()->json($orders, 200);
    }

    public function get_order(Request $request , $id)
    { 
        $order = ServicesOrders::with(['service'])->where('id', $id)->where(['request_by_id' => $request->user()->id])->first();
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
        $order = ServicesOrders::where(['id' => $request->order_id])->first();
        if($order['request_by_id'] == $request->user()->id){
            if ($order['order_status'] == 'pending') {
                ServicesOrders::where(['id' => $request->order_id])->update([
                    'order_status' => 'canceled'
                ]);
                return response()->json(translate('order_canceled_successfully'), 200);
            }
            return response()->json(translate('status_not_changable_now'), 302);
        }else{
            return response()->json(translate('this_order_did_not_requested_by_you'), 302);
        }
        
    }

    public function get_service_reviews($id)
    {
        $reviews = ReviewsOtherType::with(['customer'])->where('type','service')->where(['type_id' => $id])->get();

        $storage = [];
        foreach ($reviews as $item) {
            $item['attachment'] = json_decode($item['attachment']);
            array_push($storage, $item);
        }

        return response()->json($storage, 200);
    }

    public function get_service_rating($id)
    {
        try {
            $service = Services::find($id);
            $overallRating = \App\CPU\ProductManager::get_overall_rating($service->reviews);
            
            return response()->json(strval(floatval($overallRating[0])), 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function counter($service_id)
    {
        try {
            $countOrder = ServicesOrders::where('service_id', $service_id)->count();  
            return response()->json(['order_count' => $countOrder], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function social_share_link($service_id) 
    {
        $service = Services::where('id', $service_id)->first();
        $link = route('serviceView', $service->id);
        try {

            return response()->json($link, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function submit_service_review(Request $request)
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
        $review->type = "service";
        $review->customer_id = $request->user()->id;
        $review->type_id = $request->type_id;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->attachment = json_encode($image_array);
        $review->save();

        return response()->json(['message' => translate('successfully review submitted!')], 200);
    }
}
