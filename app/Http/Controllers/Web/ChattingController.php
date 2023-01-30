<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Chatting;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChattingController extends Controller
{
    public function chat_with_seller(Request $request)
    {
        // $last_chat = Chatting::with('seller_info')->where('user_id', auth('customer')->id())
        //     ->orderBy('created_at', 'DESC')
        //     ->first();
        $last_chat = Chatting::with(['shop'])->where('user_id', auth('customer')->id())
            ->orderBy('created_at', 'DESC')
            ->first();

        if (isset($last_chat)) {
            $chattings = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
                ->select('chattings.*', 'shops.name', 'shops.image')
                ->where('chattings.user_id', auth('customer')->id())
                ->where('shop_id', $last_chat->shop_id)
                ->get();

            $unique_shops = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
                ->select('chattings.*', 'shops.name', 'shops.image')
                ->where('chattings.user_id', auth('customer')->id())
                ->orderBy('chattings.created_at', 'desc')
                ->get()
                ->unique('shop_id');

            return view('web-views.users-profile.profile.chat-with-seller', compact('chattings', 'unique_shops', 'last_chat'));
        }
        return view('web-views.users-profile.profile.chat-with-seller');

    }
    public function messages(Request $request)
    {
        $last_chat = Chatting::where('user_id', auth('customer')->id())
            ->where('shop_id', $request->shop_id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $last_chat->seen_by_customer = 0;
        $last_chat->save();

        $shops = Chatting::join('shops', 'shops.id', '=', 'chattings.shop_id')
            ->select('chattings.*', 'shops.name', 'shops.image')
            ->where('user_id', auth('customer')->id())
            ->where('chattings.shop_id', json_decode($request->shop_id))
            ->orderBy('created_at', 'ASC')
            ->get();

        return response()->json($shops);
    }

    public function messages_store(Request $request)
    {

        if ($request->message == '') {
            Toastr::warning('Type Something!');
            return response()->json('type something!');
        } else {
            $message = $request->message;
            DB::table('chattings')->insert([
                'user_id'          => auth('customer')->id(),
                'shop_id'          => $request->shop_id,
                'seller_id'        => $request->seller_id,

                'message'          => $request->message,
                'sent_by_customer' => 1,
                'seen_by_customer' => 0,
                'created_at'       => now(),
            ]);

            return response()->json($message);
        }
    }

}
