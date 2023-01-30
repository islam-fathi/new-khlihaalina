<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Review;
use Illuminate\Http\Request;
use App\Model\Product;
use App\User;

class ReviewsController extends Controller
{
    function list(Request $request) {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $product_id = Product::where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->where('name', 'like', "%{$value}%");
                    }
                })->pluck('id')->toArray();
                
            $customer_id = User::where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('f_name', 'like', "%{$value}%")
                        ->orWhere('l_name', 'like', "%{$value}%");
                    }
                })->pluck('id')->toArray();
            
            $reviews = Review::WhereIn('product_id',  $product_id )->orWhereIn('customer_id',$customer_id);
       
            $query_param = ['search' => $request['search']];
        }else{
            $reviews = Review::with(['product', 'customer']);
        }
        $reviews = $reviews->latest()->paginate(Helpers::pagination_limit());
        return view('admin-views.reviews.list', compact('reviews','search'));
    }
}
