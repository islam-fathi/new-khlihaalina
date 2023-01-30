<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Doctor;
use App\Model\DoctorsSpecialties;
use App\Model\DoctorsDates;
use App\Model\DoctorsAppointments;
use App\Model\City;
use App\Model\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr; 

class DoctorsController extends Controller
{
    public function index(Request $request) 
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $doctors = Doctor::with(['specialities', 'cities'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%")
                            ->orWhere('city', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $doctors = Doctor::with(['specialities', 'cities']);  
        }
        $doctors = $doctors->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.doctors.list', compact('doctors', 'search'));  
    }

    public function add_doctors(){
        $cities = City::where('status', 1)->get();
        $specialties = DoctorsSpecialties::where('status', 1)->get();
        return view('admin-views.doctors.add-new',compact('cities','specialties'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name'          => 'required',
            'phone'         => 'required',
            'email'         => 'required|email|unique:doctors',
            'speciality'    => 'required',
            'visit_cost'    => 'required',
            'city'          => 'required',
            'address'       => 'required',
            'description'   => 'required',
            'images'        => 'required',
            'image'         => 'required',
            'app_image'     => 'required',
            'app_bunner'    => 'required',

        ], [
            'name.required'         => 'Name is required!',
            'phone.required'        => 'Phone is Required',
            'email.required'        => 'Email id is Required',
            'speciality.required'   => 'Speciality is Required',
            'visit_cost.required'   => 'Visit Cost is Required',
            'city.required'         => 'City is Required',
            'address.required'      => 'Address is Required',
            'description.required'  => 'Description is Required',
            'images.required'       => 'Doctor images is required!',
            'image.required'        => 'Doctor thumbnail is required!',
            'app_image.required'    => 'Doctor app image is required!',
            'app_bunner.required'   => 'Doctor app bunner is required!',
        ]);
        
        $doctor = new Doctor();
        $doctor->name       = $request->name;
        $doctor->phone      = $request->phone;
        $doctor->email      = $request->email;
        $doctor->speciality = $request->speciality;
        $doctor->visit_cost = $request->visit_cost;
        $doctor->city       = $request->city;
        $doctor->address    = $request->address;
        $doctor->description= $request->description;
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $doctor_images[] = ImageManager::upload('doctors/', 'png', $img);
            }
            $doctor->images = json_encode($doctor_images);
        }
        $doctor->thumbnail = ImageManager::upload('doctors/thumbnail/', 'png', $request->image);
        $doctor->app_image = ImageManager::upload('doctors/app_image/', 'png', $request->app_image);
        $doctor->app_bunner= ImageManager::upload('doctors/app_bunner/', 'png', $request->app_bunner);
        $doctor->status     = 1;
        $doctor->created_at = now();
        $doctor->updated_at = now();
        $doctor->save();

        Toastr::success('Doctor added successfully!');
        return redirect()->route('admin.doctor.list');
    }

    public function edit_doctor($id){
        $doctor = Doctor::find($id);
        $cities = City::where('status', 1)->get();
        $specialties = DoctorsSpecialties::where('status', 1)->get();
        return view('admin-views.doctors.edit',compact('doctor','cities','specialties'));
    }

    public function update_doctor(Request $request , $id){
        $request->validate([
            'name'          => 'required',
            'phone'         => 'required',
            'email'         => 'required|email|unique:doctors,email,'.$id,
            'speciality'    => 'required',
            'visit_cost'    => 'required',
            'city'          => 'required',
            'address'       => 'required',
            'description'   => 'required',
            'app_image'     => 'required',
            'app_bunner'    => 'required',

        ], [
            'name.required'         => 'Name is required!',
            'phone.required'        => 'Phone is Required',
            'email.required'        => 'Email id is Required',
            'speciality.required'   => 'Speciality is Required',
            'visit_cost.required'   => 'Visit Cost is Required',
            'city.required'         => 'City is Required',
            'address.required'      => 'Address is Required',
            'description.required'  => 'Description is Required',
            'app_image.required'    => 'Doctor app image is required!',
            'app_bunner.required'   => 'Doctor app bunner is required!',
        ]);
        
        $doctor = Doctor::find($id); 
        $doctor->name       = $request->name;
        $doctor->phone      = $request->phone;
        $doctor->email      = $request->email;
        $doctor->speciality = $request->speciality;
        $doctor->visit_cost = $request->visit_cost;
        $doctor->city       = $request->city;
        $doctor->address    = $request->address;
        $doctor->description= $request->description;
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $doctor_images[] = ImageManager::upload('doctors/', 'png', $img);
            }
            $doctor->images = json_encode($doctor_images);
        }

        if ($request->file('image')) {
            $doctor->thumbnail = ImageManager::update('doctors/thumbnail/', $doctor->thumbnail, 'png', $request->file('image'));
        }
        if ($request->file('app_image')) {
            $doctor->app_image = ImageManager::upload('doctors/app_image/', 'png', $request->app_image);
        }
        if ($request->file('app_bunner')) {
            $doctor->app_bunner= ImageManager::upload('doctors/app_bunner/', 'png', $request->app_bunner);
        }
        $doctor->status     = 1;
        $doctor->updated_at = now();
        $doctor->save();

        Toastr::success('Doctor added successfully!');
        return redirect()->route('admin.doctor.list');
    }

    public function status(Request $request)
    {
        $doctor = Doctor::find($request->id);
        $doctor->status = $request->status;
        $doctor->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function delete(Request $request) 
    {
        $translation = Translation::where('translationable_type','App\Model\Doctor')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        Doctor::destroy($request->id);

        return response()->json();
    }

    public function appointments(Request $request){ 
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $doctor_appointments = DoctorsAppointments::with(['doctors','customer'])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('doctor_id', '=', $value);
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $doctor_appointments = DoctorsAppointments::with(['doctors','customer']);
        }
        $doctors = Doctor::all();
        $doctor_appointments = $doctor_appointments->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.doctors.appointments', compact('doctors', 'doctor_appointments','search')); 

        // $doctor_appointments = DoctorsAppointments::with(['doctors','customer'])->get();
        // return view('admin-views.doctors.appointments' , compact('doctor_appointments')); 
    }

    public function appointment_status(Request $request)
    {
        $doctor_appointment = DoctorsAppointments::find($request->id);
        $doctor_appointment->appointment_status = $request->appointment_status;
        $doctor_appointment->save();
        return response()->json($request->appointment_status);
    }

    public function specialities(Request $request){
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $specialities = DoctorsSpecialties::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('speciality', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $specialities = NEW DoctorsSpecialties; 
        }
        $specialities = $specialities->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.doctors.specialities', compact('specialities','search'));
    }

    public function add_speciality(Request $request)
    {
        $request->validate([
            'speciality' => 'required'
        ], [
            'speciality.required' => 'speciality name is required!',
        ]);

        $speciality = new DoctorsSpecialties;
        $speciality->speciality = $request->speciality[array_search('en', $request->lang)];
        $speciality->save();

        $data = [];
        foreach ($request->lang as $index => $key) {
            if ($request->speciality[$index] && $key != 'en') {
                array_push($data, array(
                    'translationable_type'  => 'App\Model\DoctorsSpecialties',
                    'translationable_id'    => $speciality->id,
                    'locale'                => $key,
                    'key'                   => 'speciality',
                    'value'                 => $request->speciality[$index],
                ));
            }
        }
        if (count($data)) {
            Translation::insert($data);
        }
        Toastr::success('Doctor speciality added successfully!');
        return back();
    }

    public function edit_speciality(Request $request, $id)
    {
        $speciality = DoctorsSpecialties::withoutGlobalScopes()->find($id);
        return view('admin-views.doctors.speciality-edit', compact('speciality'));
    }

    public function update_speciality(Request $request)
    {
        $speciality = DoctorsSpecialties::find($request->id);
        $speciality->speciality = $request->speciality[array_search('en', $request->lang)];
        $speciality->save();

        foreach ($request->lang as $index => $key) {
            if ($request->speciality[$index] && $key != 'en') {
                Translation::updateOrInsert(
                    ['translationable_type' => 'App\Model\DoctorsSpecialties',
                        'translationable_id' => $speciality->id,
                        'locale' => $key,
                        'key' => 'name'],
                    ['value' => $request->speciality[$index]]
                );
            }
        }

        Toastr::success('speciality updated successfully!');
        return back(); 
    }

    public function status_speciality(Request $request)
    {
        $speciality = DoctorsSpecialties::find($request->id);
        $speciality->status = $request->status;
        $speciality->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function delete_speciality(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\DoctorsSpecialties')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        DoctorsSpecialties::destroy($request->id);

        return response()->json();
    }

    public function dates(Request $request , $doctor_id){
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $doctor_dates = DoctorsDates::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('day_name', 'like', "%{$value}%");
                    $q->where("doctor_id" , $doctor_id);
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $doctor_dates = DoctorsDates::where('doctor_id' , $doctor_id); 
        }
        $doctor_dates = $doctor_dates->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.doctors.dates', compact('doctor_dates','search' , 'doctor_id'));
    }

    public function add_date(Request $request)
    {
        $request->validate([
            'day_name'  => 'required',
            'start_time'=> 'required',
            'end_time'  => 'required',
        ], [
            'day_name.required'     => 'Day name is required!',
            'start_time.required'   => 'start time is required!',
            'end_time.required'     => 'end time is required!',
        ]);

        $doctor_date = new DoctorsDates;
        $doctor_date->doctor_id     = $request->doctor_id;
        $doctor_date->day_name      = $request->day_name;
        $doctor_date->start_time    = $request->start_time;
        $doctor_date->end_time      = $request->end_time;
        $doctor_date->save();

        Toastr::success('Doctor date added successfully!');
        return back();
    }

    public function edit_date(Request $request, $id)
    {
        $doctor_date = DoctorsDates::withoutGlobalScopes()->find($id);
        return view('admin-views.doctors.date-edit', compact('doctor_date'));
    }

    public function update_date(Request $request)
    {
        $doctor_date = DoctorsDates::find($request->id);
        $doctor_date->doctor_id     = $request->doctor_id;
        $doctor_date->day_name      = $request->day_name;
        $doctor_date->start_time    = $request->start_time;
        $doctor_date->end_time      = $request->end_time;
        $doctor_date->save();

        Toastr::success('Doctors Date updated successfully!');
        return redirect()->route('admin.doctor.list');
    }

    public function status_date(Request $request)
    {
        $doctor_date = DoctorsDates::find($request->id);
        $doctor_date->status = $request->status;
        $doctor_date->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function delete_date(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\DoctorsDates')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        DoctorsDates::destroy($request->id);

        return response()->json();
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/doctors/' . $request['image']);
        $doctor = Doctors::find($request['id']);
        $array = [];
        if (count(json_decode($doctor['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($doctor['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Doctors::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Doctor image removed successfully!');
        return back();
    }
}
