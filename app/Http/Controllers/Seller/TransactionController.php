<?php

namespace App\Http\Controllers\Seller;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\OrderTransaction;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function order_list(Request $request)
    {
        $query_param  = [];
        $search       = $request['search'];
        $from         = $request['from'];
        $to           = $request['to'];
        $status       = $request['status'];
        $customer_id       = $request['customer_id'];

        $customers = User::whereNotIn('id',[0])->get();

        $transactions = OrderTransaction::with(['customer'])
            ->where(['seller_id'=>auth('seller')->id()])
            ->when($search, function($q) use($search){
                $q->orWhere('order_id', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%");
            })
            ->when($customer_id, function($q) use($customer_id){
                $q->where('customer_id', $customer_id);
            })
            ->when($status == 'all', function ($q) use($status){
                $q;
            })
            ->when(!empty($status) && ($status != 'all'), function ($q) use($status){
                $q->where('status', 'like', "%{$status}%");
            })
            ->when(!empty($from) && !empty($to),function($query) use($from,$to){
                $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
            })
            ->latest()->paginate(Helpers::pagination_limit())->appends([
                'status'=>$status,
                'from'=>$from,
                'to'=>$to,
                'search'=>$search]);

        return view('seller-views.transaction.order-list', compact('customers', 'transactions','search','status', 'from', 'to', 'customer_id'));
    }

    public function expense_list(Request $request)
    {
        return view('seller-views.transaction.expense-list');
    }
}
