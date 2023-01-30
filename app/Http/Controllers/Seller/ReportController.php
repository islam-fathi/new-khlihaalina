<?php

namespace App\Http\Controllers\Seller;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function all_product(Request $request){
        $search = $request['search'];
        $from = $request['from'];
        $to = $request['to'];

        return view('seller-views.report.all-product', compact('search', 'from', 'to'));
    }

    public function stock_product_report(Request $request)
    {
        $search = $request['search'];
        $sort = $request['sort'] ?? 'ASC';

        $query_param = ['search' => $search, 'sort' => $sort];

        $products = Product::where(['product_type'=>'physical','added_by'=>'seller','user_id'=>auth('seller')->id()])
            ->when($search, function($q) use($search){
                $q->where('name','Like','%'.$search.'%');
            })
            ->orderBy('current_stock', $sort)
            ->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('seller-views.report.product-stock', compact('products','search', 'sort'));
    }

    public function order_report(Request $request)
    {
        $from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to_date = Carbon::now()->endOfMonth()->format('Y-m-d');

        if (session()->has('from_date') == false) {
            session()->put('from_date', $from_date);
            session()->put('to_date', $to_date);
        }

        return view('seller-views.report.order-report');
    }

    public function set_date(Request $request)
    {
        $from = $request['from'];
        $to = $request['to'];

        session()->put('from_date', $from);
        session()->put('to_date', $to);

        $previousUrl = strtok(url()->previous(), '?');
        return redirect()->to($previousUrl . '?' . http_build_query(['from_date' => $request['from'], 'to_date' => $request['to']]))->with(['from' => $from, 'to' => $to]);
    }
}
