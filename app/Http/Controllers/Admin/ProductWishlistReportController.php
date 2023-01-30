<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductWishlistReportController extends Controller
{
    public function index()
    {
        return view('admin-views.report.product-in-wishlist');
    }

    public function filter(Request $request)
    {
        if ($request['seller_id'] == 'all') {
            $products = Product::with(['wish_list'])->get();
        } elseif ($request['seller_id'] == 'in_house') {
            $products = Product::with(['wish_list'])->where(['added_by' => 'admin'])->get();
        } else {
            $products = Product::with(['wish_list'])->where(['added_by' => 'seller', 'user_id' => $request['seller_id']])->get();
        }
        return response()->json([
            'view' => view('admin-views.report.partials.products-wishlist-table', compact('products'))->render()
        ]);
    }
}
