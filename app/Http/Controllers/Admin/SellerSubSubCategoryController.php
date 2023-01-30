<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\SellerCategories;
use App\Model\Translation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerSubSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $categories = SellerCategories::where(['position'=>2])->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $categories=SellerCategories::where(['position'=>2]);
        }
        $categories = $categories->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.seller.category.sub-sub-category-view',compact('categories','search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'required'
        ], [
            'name.required' => 'Seller Category name is required!',
            'parent_id.required' => 'Seller Sub Category field is required!',
        ]);

        $category = new SellerCategories;
        $category->name = $request->name[array_search('en', $request->lang)];
        $category->slug = Str::slug($request->name[array_search('en', $request->lang)]);
        $category->parent_id = $request->parent_id;
        $category->position = 2;
        $category->priority = $request->priority;
        $category->save();
        foreach($request->lang as $index=>$key)
        {
            if($request->name[$index] && $key != 'en')
            {
                Translation::updateOrInsert(
                    ['translationable_type'  => 'App\Model\SellerCategories',
                        'translationable_id'    => $category->id,
                        'locale'                => $key,
                        'key'                   => 'name'],
                    ['value'                 => $request->name[$index]]
                );
            }
        }
        Toastr::success('Seller Sub Sub Category updated successfully!');
        return back();
    }

    public function edit(Request $request)
    {
        $data = SellerCategories::where('id',$request->id)->first();
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'required'
        ], [
            'name.required' => 'seller Category name is required!',
            'parent_id.required' => 'Seller Sub Category field is required!',
        ]);
        
        $category = SellerCategories::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = $request->parent_id;
        $category->position = 2;
        $category->priority = $request->priority;
        $category->save();
        return response()->json();
    }
    public function delete(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\SellerCategories')
                                    ->where('translationable_id',$request->id);
        $translation->delete();
        SellerCategories::destroy($request->id);
        return response()->json();
    }
    public function fetch(Request $request){
        if($request->ajax())
        {
            $data = SellerCategories::where('position',2)->orderBy('id','desc')->get();
            return response()->json($data);
        }
    }

    public function getSubCategory(Request $request)
    {
        $data = SellerCategories::where("parent_id",$request->id)->get();
        $output="";
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    public function getCategoryId(Request $request)
    {
        $data= SellerCategories::where('id',$request->id)->first();
        return response()->json($data);
    }
}
