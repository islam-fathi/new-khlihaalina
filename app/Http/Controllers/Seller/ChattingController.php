<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChattingController extends Controller
{
    public function chat()
    {
        $shop_id = Shop::where('seller_id', auth('seller')->id())->first()->id;

        $last_chat = Chatting::where('shop_id', $shop_id)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (isset($last_chat)) {
            //get messages of last user chatting
            $chattings = Chatting::join('users', 'users.id', '=', 'chattings.user_id')
                ->select('chattings.*', 'users.f_name', 'users.l_name', 'users.image')
                ->where('chattings.shop_id', $shop_id)
                ->where('user_id', $last_chat->user_id)
                ->get();

            $chattings_user = Chatting::join('users', 'users.id', '=', 'chattings.user_id')
                ->select('chattings.*', 'users.f_name', 'users.l_name', 'users.image')
                ->where('chattings.shop_id', $shop_id)
                ->orderBy('chattings.created_at', 'desc')
                ->get()
                ->unique('user_id');

            return view('seller-views.chatting.chat', compact('chattings', 'chattings_user', 'last_chat'));
        }

        return view('seller-views.chatting.chat', compact('last_chat'));
    }

    public function message_by_user(Request $request)
    {
        $shop_id = Shop::where('seller_id', auth('seller')->id())->first()->id;
        $last_chat = Chatting::where('seller_id', auth('seller')->id())
            ->where('user_id', $request->user_id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $last_chat->seen_by_seller = 0;
        $last_chat->save();

        $sellers = Chatting::join('users', 'users.id', '=', 'chattings.user_id')
            ->select('chattings.*', 'users.f_name', 'users.l_name', 'users.image')
            ->where('chattings.shop_id', $shop_id)
            ->where('chattings.user_id', $request->user_id)
            ->orderBy('created_at', 'ASC')
            ->get();

        return response()->json($sellers);
    }

    // Store massage
    public function seller_message_store(Request $request)
    {
        if ($request->message == '') {
            Toastr::warning('Type Something!');
            return response()->json(['message' =>'type something!']);
        } else {
            $shop_id = Shop::where('seller_id', auth('seller')->id())->first()->id;

            $message = $request->message;
            $time = now();

            DB::table('chattings')->insert([
                'user_id'        => $request->user_id, //user_id == seller_id
                'seller_id'      => auth('seller')->id(),
                'shop_id'        => $shop_id,
                'message'        => $request->message,
                'sent_by_seller' => 1,
                'seen_by_seller' => 0,
                'created_at'     => now(),
            ]);

            return response()->json(['message' => $message, 'time' => $time]);

        }
    }

}
