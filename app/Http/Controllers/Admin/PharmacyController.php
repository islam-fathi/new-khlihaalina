<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Convert;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\CPU\BackEndHelper;
use App\Http\Controllers\Controller;
use App\Model\Pharmacies;
use App\Model\City;
use App\Model\PharmaciesOrders;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PharmacyController extends Controller
{
    public function index(Request $request) 
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $pharmacies = Pharmacies::with(['cities'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('city', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $pharmacies = Pharmacies::with(['cities']);
        }
        $pharmacies = $pharmacies->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.pharmacy.list', compact('pharmacies', 'search'));  
    }

    public function add(){
        $cities = City::where('status', 1)->get();
        return view('admin-views.pharmacy.add-new',compact('cities'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name'              => 'required',
            'phone'             => 'required',
            'city'              => 'required',
            'address'           => 'required',
            'working_from_time' => 'required',
            'working_to_time'   => 'required',
            'description'       => 'required',
            'images'            => 'required',
            'image'             => 'required',
            'app_image'         => 'required',
            'app_bunner'        => 'required',

        ], [
            'name.required'             => 'Name is required!',
            'phone.required'            => 'Phone is Required',
            'city.required'             => 'City is Required',
            'address.required'          => 'Address is Required',
            'working_from_time.required'=> 'Working from time is Required',
            'working_to_time.required'  => 'Working to time is Required',
            'description.required'      => 'Description is Required',
            'images.required'           => 'Pharmacy images is required!',
            'image.required'            => 'Pharmacy thumbnail is required!',
            'app_image.required'        => 'Pharmacy app image is required!',
            'app_bunner.required'       => 'Pharmacy app bunner is required!',
        ]);
        
        $pharmacy = new Pharmacies();
        $pharmacy->name               = $request->name;
        $pharmacy->phone              = $request->phone;
        $pharmacy->working_from_time  = $request->working_from_time;
        $pharmacy->working_to_time    = $request->working_to_time;
        $pharmacy->city               = $request->city;
        $pharmacy->address            = $request->address;
        $pharmacy->description        = $request->description;
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $pharmacy_images[] = ImageManager::upload('pharmacies/', 'png', $img);
            }
            $pharmacy->images = json_encode($pharmacy_images);
        }
        $pharmacy->thumbnail = ImageManager::upload('pharmacies/thumbnail/', 'png', $request->image);
        $pharmacy->app_image = ImageManager::upload('pharmacies/app_image/', 'png', $request->app_image);
        $pharmacy->app_bunner= ImageManager::upload('pharmacies/app_bunner/', 'png', $request->app_bunner);
        // $pharmacy->image              = ImageManager::upload('pharmacies/', 'png', $request->file('image'));
        $pharmacy->status             = 1;
        $pharmacy->created_at         = now();
        $pharmacy->updated_at         = now();
        $pharmacy->save();

        Toastr::success('Pharmacy added successfully!');
        return redirect()->route('admin.pharmacy.list');
    }

    public function edit($id){
        $pharmacy = Pharmacies::find($id);
        $cities = City::where('status', 1)->get();
        return view('admin-views.pharmacy.edit',compact('pharmacy','cities'));
    }

    public function update(Request $request , $id){
        $request->validate([
            'name'              => 'required',
            'phone'             => 'required',
            'city'              => 'required',
            'address'           => 'required',
            'working_from_time' => 'required',
            'working_to_time'   => 'required',
            'description'       => 'required',

        ], [
            'name.required'             => 'Name is required!',
            'phone.required'            => 'Phone is Required',
            'city.required'             => 'City is Required',
            'address.required'          => 'Address is Required',
            'working_from_time.required'=> 'Working from time is Required',
            'working_to_time.required'  => 'Working to time is Required',
            'description.required'      => 'Description is Required',
        ]);
        
        $pharmacy = Pharmacies::find($id); 
        $pharmacy->name               = $request->name;
        $pharmacy->phone              = $request->phone;
        $pharmacy->working_from_time  = $request->working_from_time;
        $pharmacy->working_to_time    = $request->working_to_time;
        $pharmacy->city               = $request->city;
        $pharmacy->address            = $request->address;
        $pharmacy->description        = $request->description;
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $pharmacy_images[] = ImageManager::upload('pharmacies/', 'png', $img);
            }
            $pharmacy->images = json_encode($pharmacy_images);
        }

        if ($request->file('image')) {
            $pharmacy->thumbnail = ImageManager::update('pharmacies/thumbnail/', $pharmacy->thumbnail, 'png', $request->file('image'));
        }
        if ($request->file('app_image')) {
            $pharmacy->app_image = ImageManager::update('pharmacies/app_image/', $pharmacy->app_image, 'png', $request->file('app_image'));
        }
        if ($request->file('app_bunner')) {
            $pharmacy->app_bunner = ImageManager::update('pharmacies/app_bunner/', $pharmacy->app_bunner, 'png', $request->file('app_bunner'));
        }
        
        $pharmacy->status             = 1;
        $pharmacy->updated_at         = now();
        $pharmacy->save();

        Toastr::success('Pharmacy added successfully!');
        return redirect()->route('admin.pharmacy.list');
    }

    public function status(Request $request)
    {
        $pharmacy = Pharmacies::find($request->id);
        $pharmacy->status = $request->status;
        $pharmacy->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function delete(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\Pharmacies')
                                    ->where('translationable_id',$request->id);
        if($translation){
            $translation->delete();
        }
        Pharmacies::destroy($request->id);

        return response()->json();
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/pharmacies/' . $request['image']);
        $pharmacy = Pharmacies::find($request['id']);
        $array = [];
        if (count(json_decode($pharmacy['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($pharmacy['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Pharmacies::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Pharmacy image removed successfully!');
        return back();
    }

    public function orders(Request $request){
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $pharmacy_orders = PharmaciesOrders::with(['pharmacy','customer'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('pharmacy_id', '=', $value);
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $pharmacy_orders = PharmaciesOrders::with(['pharmacy','customer']);
        }
        $pharmacies = Pharmacies::all();
        $pharmacy_orders = $pharmacy_orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.pharmacy.orders', compact('pharmacies', 'pharmacy_orders','search'));  
    }

    public function order_status(Request $request)
    {
        $order = PharmaciesOrders::find($request->id);
        $order->order_status = $request->order_status;
        $order->save();
        return response()->json($request->order_status);
    }

}
