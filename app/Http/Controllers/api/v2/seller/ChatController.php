<?php

namespace App\Http\Controllers\api\v2\seller;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;

class ChatController extends Controller
{
    public function messages(Request $request)
    {
        $data = Helpers::get_seller_by_token($request);

        if ($data['success'] == 1) {
            $seller = $data['data'];
        } else {
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }

        try {
            $messages = Chatting::with(['seller_info', 'customer', 'shop'])->where('seller_id', $seller['id'])->latest()
            ->get();
            return response()->json($messages, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function send_message(Request $request)
    {
        $data = Helpers::get_seller_by_token($request);

        if ($data['success'] == 1) {
            $seller = $data['data'];
        } else {
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }

        if ($request->message == '') {
            return response()->json(translate('type something!'), 200);
        } else {
            $shop_id = Shop::where('seller_id', $seller['id'])->first()->id;
            $message = $request->message;
            $time = now();

            DB::table('chattings')->insert([
                'user_id' => $request->user_id, //user_id == seller_id
                'shop_id' => $shop_id,
                'seller_id' => $seller['id'],
                'message' => $request->message,
                'sent_by_seller' => 1,
                'seen_by_seller' => 0,
                'created_at' => now(),
            ]);
            return response()->json(['message' => $message, 'time' => $time]);
        }
    }
}
