<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class CityController extends Controller 
{
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $cities = City::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $cities = NEW City;
        }

        $cities = $cities->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.city.view', compact('cities','search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'City name is required!',
        ]);

        $city = new City;
        $city->name = $request->name[array_search('en', $request->lang)];
        $city->save();

        $data = [];
        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                array_push($data, array(
                    'translationable_type' => 'App\Model\City',
                    'translationable_id' => $city->id,
                    'locale' => $key,
                    'key' => 'name',
                    'value' => $request->name[$index],
                ));
            }
        }
        if (count($data)) {
            Translation::insert($data);
        }

        Toastr::success('City added successfully!');
        return back();
    }

    public function edit(Request $request, $id)
    {
        $city = City::withoutGlobalScopes()->find($id);
        return view('admin-views.city.edit', compact('city'));
    }

    public function update(Request $request)
    {
        $city = City::find($request->id);
        $city->name = $request->name[array_search('en', $request->lang)];
        $city->save();

        foreach ($request->lang as $index => $key) {
            if ($request->name[$index] && $key != 'en') {
                Translation::updateOrInsert(
                    ['translationable_type' => 'App\Model\City',
                        'translationable_id' => $city->id,
                        'locale' => $key,
                        'key' => 'name'],
                    ['value' => $request->name[$index]]
                );
            }
        }

        Toastr::success('City updated successfully!');
        return back();
    }

    public function delete(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\City')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        City::destroy($request->id);

        return response()->json();
    }

    public function status(Request $request)
    {
        $city = City::find($request->id);
        $city->status = $request->status;
        $city->save();
        return response()->json([
            'success' => 1,
        ], 200);
    }
}
