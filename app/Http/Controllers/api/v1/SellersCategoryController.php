<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CategoryManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\SellerCategories;
use App\Model\Shop;

class SellersCategoryController extends Controller
{
    public function get_categories()
    {
        try {
            $categories = SellerCategories::with(['childes.childes'])->where(['position' => 0])->priority()->get();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function get_sellers($id)
    {
        // $id = '"'.$category_id.'"';
        $get_shops = Shop::with(['seller'])->active()->where('category_ids', 'like', "%{$id}%")->get();
        return response()->json(Helpers::seller_data_formatting($get_shops, true), 200);
    }
}
