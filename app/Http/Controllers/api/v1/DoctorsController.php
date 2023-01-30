<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Doctor;
use App\Model\DoctorsSpecialties;
use App\Model\DoctorsAppointments;
use App\Model\ReviewsOtherType;
use App\User;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use function App\CPU\translate;


class DoctorsController extends Controller
{
    public function get_all()
    {
        try {
            $default_city = Helpers::default_city();
            $doctors = Doctor::with(['specialities', 'cities'])->where('city', $default_city)->get();
            // $doctors['doctors'] = Helpers::decode_images_formatting($doctors, true);
            return response()->json($doctors, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403); 
        } 
    }

    public function get_specialities(){
        try {
            $specialities = DoctorsSpecialties::where('status', 1)->get();
            return response()->json($specialities, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function get_doctor($id){
        try {
            $doctors = Doctor::with(['specialities', 'cities'])->where("id" , $id)->get();
            // $doctors['doctors'] = Helpers::decode_images_formatting($doctors, true);
            return response()->json($doctors, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function get_all_doctors()
    {
        $default_city = Helpers::default_city();
        $doctors = Doctor::with(['specialities', 'cities'])->where('city', $default_city)->get();
        // $doctors['doctors'] = Helpers::decode_images_formatting($doctors, true);
        return response()->json($doctors, 200);
    }

    public function doctorAppointment(Request $request){
        $doctor = Doctor::find($request->doctor_id);

        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
            'name'      => 'required',
            'phone'     => 'required',
            'subject'   => 'required',
        ], [
            'doctor_id.required'    => 'Doctor is required',
            'request_by_id.required'=> 'User Created is required',
            'name.required'         => 'Name is required!',
            'phone.required'        => 'Phone is Required',
            'subject.required'      => 'Subject is Required',
        ]);
        
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        
        $doctorAppointment  = new DoctorsAppointments();  
        $doctorAppointment->doctor_id           = $request->doctor_id;
        $doctorAppointment->request_by_id       = $request->user()->id;
        $doctorAppointment->name                = $request->name;
        $doctorAppointment->email               = $request->email;
        $doctorAppointment->phone               = $request->phone;
        $doctorAppointment->subject             = $request->subject;
        $doctorAppointment->message             = $request->message;
        $doctorAppointment->appointment_date    = now();
        $doctorAppointment->appointment_status  = 'pending';
        $doctorAppointment->payment_value       = $doctor->visit_cost;
        $doctorAppointment->save();

        $return = [
            'status' => 1,
            'message' => 'successfully_added!'
        ];
        return response()->json($return, 200); 
    } 

    public function get_appointments_list(Request $request)
    { 
        $appointments = DoctorsAppointments::with(['doctors'])->where(['request_by_id' => $request->user()->id])->get();
        $appointments->map(function ($data) {
            return $data;
        });
        return response()->json($appointments, 200);
    }

    public function get_appointment(Request $request , $id)
    { 
        $appointment = DoctorsAppointments::with(['doctors'])->where('id', $id)->where(['request_by_id' => $request->user()->id])->first();
        return response()->json($appointment, 200);
    }

    public function appointment_cancel(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $appointment = DoctorsAppointments::where(['id' => $request->order_id])->first();
        if($appointment['request_by_id'] == $request->user()->id){
            if ($appointment['appointment_status'] == 'pending') {
                DoctorsAppointments::where(['id' => $request->order_id])->update([
                    'appointment_status' => 'canceled'
                ]);
                
                return response()->json(translate('appointments_canceled_successfully'), 200);
            }
            
            return response()->json(translate('status_not_changable_now'), 302);
        }else{
            return response()->json(translate('this_appointment_did_not_requested_by_you'), 302);
        }
        
    }

    public function get_doctor_reviews($id)
    {
        $reviews = ReviewsOtherType::with(['customer'])->where('type','doctor')->where(['type_id' => $id])->get();

        $storage = [];
        foreach ($reviews as $item) {
            $item['attachment'] = json_decode($item['attachment']);
            array_push($storage, $item);
        }

        return response()->json($storage, 200);
    }

    public function get_doctor_rating($id)
    {
        try {
            $doctor = Doctor::find($id);
            $overallRating = \App\CPU\ProductManager::get_overall_rating($doctor->reviews);
            return response()->json(strval(floatval($overallRating[0])), 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function counter($doctor_id)
    {
        try {
            $countOrder = DoctorsAppointments::where('doctor_id', $doctor_id)->count();
            return response()->json(['order_count' => $countOrder], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function social_share_link($doctor_id) 
    {
        $doctor = Doctor::where('id', $doctor_id)->first();
        $link = route('doctorView', $doctor_id);
        try {

            return response()->json($link, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function submit_doctor_review(Request $request)
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
        $review->type = "doctor";
        $review->customer_id = $request->user()->id;
        $review->type_id = $request->type_id;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->attachment = json_encode($image_array);
        $review->save();

        return response()->json(['message' => translate('successfully review submitted!')], 200);
    }



}
