<?php

namespace App\Http\Controllers\Seller\Auth;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use App\Model\City;
use App\Model\SellerCategories;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
    {
        $cities = City::where('status', 1)->get();
        $cat = SellerCategories::where(['parent_id' => 0])->get();
        return view('seller-views.auth.register',compact('cities','cat'));
    }

    public function store(Request $request)
    {
         

        $this->validate($request, [
            'email' => 'required|unique:sellers',
            'shop_address' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'shop_name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:8',
            'category_id' => 'required',
        ]);

        

        DB::transaction(function ($r) use ($request) {
            $seller = new Seller();
            $seller->f_name = $request->f_name;
            $seller->l_name = $request->l_name;
            $seller->phone = $request->phone;
            $seller->email = $request->email;
            $seller->image = ImageManager::upload('seller/', 'png', $request->file('image'));
            $seller->password = bcrypt($request->password);
            $seller->city     = $request->city;
            $seller->status =  $request->status == 'approved'?'approved': "pending";
            $seller->save();

            $shop = new Shop();
            $category = [];
            if ($request->category_id != null) {
                array_push($category, [
                    'id' => $request->category_id,
                    'position' => 1,
                ]);
            }
            if ($request->sub_category_id != null) {
                array_push($category, [
                    'id' => $request->sub_category_id,
                    'position' => 2,
                ]);
            }
            if ($request->sub_sub_category_id != null) {
                array_push($category, [
                    'id' => $request->sub_sub_category_id,
                    'position' => 3,
                ]);
            }
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->category_ids = json_encode($category);
            $shop->working_from_time = $request->working_from_time;
            $shop->working_to_time = $request->working_to_time;
            $shop->address = $request->shop_address;
            $shop->city     = $request->city;
            $shop->contact = $request->phone;
            $shop->image = ImageManager::upload('shop/', 'png', $request->file('logo'));
            $shop->banner = ImageManager::upload('shop/banner/', 'png', $request->file('banner'));
            $shop->save();

            DB::table('seller_wallets')->insert([
                'seller_id' => $seller['id'],
                'withdrawn' => 0,
                'commission_given' => 0,
                'total_earning' => 0,
                'pending_withdraw' => 0,
                'delivery_charge_earned' => 0,
                'collected_cash' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        });

        if($request->status == 'approved'){
            Toastr::success('Shop apply successfully!');
            return back();
        }else{
            Toastr::success('Shop apply successfully!');
            return redirect()->route('seller.auth.login');
        }
        

    }
}
