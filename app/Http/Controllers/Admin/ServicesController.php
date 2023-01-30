<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Convert;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\CPU\BackEndHelper;
use App\Http\Controllers\Controller;
use App\Model\Services;
use App\Model\City;
use App\Model\ServicesOrders;
use App\Model\ServicesCategories;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    public function index(Request $request) 
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $services = Services::with(['cities' ,'categories'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('city', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $services = Services::with(['cities','categories']);
        }
        $services = $services->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.services.list', compact('services', 'search'));  
    }

    public function add(){
        $cities = City::where('status', 1)->get();
        $categories = ServicesCategories::where('status', 1)->get();
        return view('admin-views.services.add-new',compact('cities','categories'));
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
            'category'          => 'required',
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
            'category.required'         => 'Category is Required',
            'images.required'           => 'Service images is required!',
            'image.required'            => 'Service thumbnail is required!',
            'app_image.required'        => 'Service app image is required!',
            'app_bunner.required'       => 'Service app bunner is required!',
        ]);
        
        $service = new Services();
        $service->name               = $request->name;
        $service->phone              = $request->phone;
        $service->working_from_time  = $request->working_from_time;
        $service->working_to_time    = $request->working_to_time;
        $service->city               = $request->city;
        $service->address            = $request->address;
        $service->description        = $request->description;
        $service->category_id        = $request->category;
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $service_images[] = ImageManager::upload('services/', 'png', $img);
            }
            $service->images = json_encode($service_images);
        }
        $service->thumbnail = ImageManager::upload('services/thumbnail/', 'png', $request->image);
        $service->app_image = ImageManager::upload('services/app_image/', 'png', $request->app_image);
        $service->app_bunner= ImageManager::upload('services/app_bunner/', 'png', $request->app_bunner);
        // $service->image              = ImageManager::upload('services/', 'png', $request->file('image'));
        $service->status             = 1;
        $service->created_at         = now();
        $service->updated_at         = now();
        $service->save();

        Toastr::success('Service added successfully!');
        return redirect()->route('admin.service.list');
    }

    public function edit($id){
        $service = Services::find($id);
        $cities = City::where('status', 1)->get();
        $categories = ServicesCategories::where('status', 1)->get();
        return view('admin-views.services.edit',compact('service','cities','categories'));
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
            'category'          => 'required',

        ], [
            'name.required'             => 'Name is required!',
            'phone.required'            => 'Phone is Required',
            'city.required'             => 'City is Required',
            'address.required'          => 'Address is Required',
            'working_from_time.required'=> 'Working from time is Required',
            'working_to_time.required'  => 'Working to time is Required',
            'description.required'      => 'Description is Required',
            'category.required'         => 'Category is Required',
        ]);
        
        $service = Services::find($id);
        $service->name               = $request->name;
        $service->phone              = $request->phone;
        $service->working_from_time  = $request->working_from_time;
        $service->working_to_time    = $request->working_to_time;
        $service->city               = $request->city;
        $service->address            = $request->address;
        $service->description        = $request->description;
        $service->category_id        = $request->category;
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $service_images[] = ImageManager::upload('services/', 'png', $img);
            }
            $service->images = json_encode($service_images);
        }

        if ($request->file('image')) {
            $service->thumbnail = ImageManager::update('services/thumbnail/', $service->thumbnail, 'png', $request->file('image'));
        }

        if ($request->file('app_image')) {
            $service->app_image = ImageManager::update('services/app_image/', $service->app_image, 'png', $request->file('app_image'));
        }

        if ($request->file('app_bunner')) {
            $service->app_bunner = ImageManager::update('services/app_bunner/', $service->app_bunner, 'png', $request->file('app_bunner'));
        }
        // $service->image              = ImageManager::upload('services/', 'png', $request->file('image'));
        $service->status             = 1;
        $service->updated_at         = now();
        $service->save();

        Toastr::success('Service added successfully!');
        return redirect()->route('admin.service.list');
    }

    public function status(Request $request)
    {
        $service = Services::find($request->id);
        $service->status = $request->status;
        $service->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function delete(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\Services')
                                    ->where('translationable_id',$request->id);
        if($translation){
            $translation->delete();
        }
        Services::destroy($request->id);

        return response()->json();
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/services/' . $request['image']);
        $service = Services::find($request['id']);
        $array = [];
        if (count(json_decode($service['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($service['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Services::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Service image removed successfully!');
        return back();
    }

    public function categories(Request $request){ 
        $query_param = [];
        $search = $request['search'];
        if($request->has('search')){
            $key = explode(' ', $request['search']);
            $categories = ServicesCategories::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $categories =  ServicesCategories::get();
        }
        $categories = ServicesCategories::latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.services.categories', compact('categories','search'));
    }

    public function add_category(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Category name is required!',
        ]);

        $category = new ServicesCategories();
        $category->name = $request->name[array_search('en', $request->lang)];
        $category->save();

        $data = [];
        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                array_push($data, array(
                    'translationable_type'  => 'App\Model\ServicesCategories',
                    'translationable_id'    => $category->id,
                    'locale'                => $key,
                    'key'                   => 'category',
                    'value'                 => $request->name[$index],
                ));
            }
        }
        if (count($data)) {
            Translation::insert($data);
        }
        Toastr::success('Service Category added successfully!');
        return back();
    }

    public function edit_category(Request $request, $id)
    {
        $category = ServicesCategories::withoutGlobalScopes()->find($id);
        return view('admin-views.services.category-edit', compact('category'));
    }

    public function update_category(Request $request)
    {
        $category = ServicesCategories::find($request->id);
        $category->name = $request->name[array_search('en', $request->lang)];
        $category->save();

        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                Translation::updateOrInsert(
                    ['translationable_type' => 'App\Model\ServicesCategories',
                        'translationable_id' => $request->id,
                        'locale' => $key,
                        'key' => 'name'],
                    ['value' => $request->name[$index]]
                );
            }
        }

        Toastr::success('Category updated successfully!');
        return back(); 
    }

    public function status_category(Request $request)
    {
        $category = ServicesCategories::find($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function delete_category(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\ServicesCategories')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        ServicesCategories::destroy($request->id);

        return response()->json();
    }

    public function orders(Request $request){
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $service_orders = ServicesOrders::with(['service','customer'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('service_id', '=', $value);
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $service_orders = ServicesOrders::with(['service','customer']);
        }
        $services = Services::all();
        $service_orders = $service_orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.services.orders', compact('services', 'service_orders','search'));  
    }

    public function order_status(Request $request )
    {
        $order = ServicesOrders::find($request->id);
        $order->order_status = $request->order_status;
        $order->save();
        return response()->json($request->order_status);
    }
    
}
