<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\RefundTransaction;
use App\CPU\Helpers;

class RefundTransactionController extends Controller
{
    public function list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $refund_transactions = RefundTransaction::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('order_id', 'like', "%{$value}%")
                        ->orWhere('refund_id', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }else{
            $refund_transactions = new RefundTransaction;
        }
    
        $refund_transactions = $refund_transactions->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.refund-transaction.list',compact('search','refund_transactions'));
    }
}
