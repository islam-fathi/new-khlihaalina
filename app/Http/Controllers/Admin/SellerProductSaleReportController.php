<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Model\OrderDetail;

class SellerProductSaleReportController extends Controller
{
    public function index(Request $request)
    {
        $query_param = ['category_id' => $request['category_id'], 'seller_id' => $request['seller_id']];

        $products = Product::where(['added_by' => 'seller'])
            ->when($request->has('seller_id') && $request['seller_id'] != 'all', function ($query) use ($request) {
                $query->where('user_id', $request['seller_id']);
            })
            ->when($request->has('category_id') && $request['category_id'] != 'all', function ($query) use ($request) {
                $query->whereJsonContains('category_ids', [[['id' => (string)$request['category_id']]]]);
            })->with(['order_details'])->paginate(Helpers::pagination_limit())->appends($query_param);
        $category_id = $request['category_id'];
        $seller_id = $request['seller_id'];
        $categories = Category::where(['parent_id' => 0])->get();
        return view('admin-views.report.seller-product-sale', compact('products', 'categories', 'category_id', 'seller_id'));
    }
}
