<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;

class ChatController extends Controller
{
    public function chat_with_seller(Request $request)
    {
        try {
            $last_chat = Chatting::with(['seller_info', 'customer', 'shop'])->where('user_id', $request->user()->id)
                ->orderBy('created_at', 'DESC')
                ->first();

            if (isset($last_chat)) {

                $chattings = Chatting::with(['seller_info', 'customer', 'shop'])->join('shops', 'shops.id', '=', 'chattings.shop_id')
                    ->select('chattings.*', 'shops.name', 'shops.image')
                    ->where('chattings.user_id', $request->user()->id)
                    ->where('shop_id', $last_chat->shop_id)
                    ->get();

                $unique_shops = Chatting::with(['seller_info', 'shop'])
                    ->where('user_id', $request->user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->unique('shop_id');

                $store = [];
                foreach ($unique_shops as $shop) {
                    array_push($store, $shop);
                }

                // $unique_shops = Chatting::with(['seller_info', 'shop'])->groupBy('shop_id')->get();

                return response()->json([
                    'last_chat' => $last_chat,
                    'chat_list' => $chattings,
                    'unique_shops' => $store,
                ], 200);
            } else {
                return response()->json($last_chat, 200);
            }

        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function messages(Request $request)
    {
        try {
            $messages = Chatting::with(['seller_info', 'customer', 'shop'])->where('user_id', $request->user()->id)
                ->where('shop_id', $request->shop_id)
                ->get();

            return response()->json($messages, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function messages_store(Request $request)
    {
        try {
            if ($request->message == '') {
                return response()->json(translate('type something!'));
            } else {
                $shop = Shop::find($request->shop_id);
                DB::table('chattings')->insert([
                    'user_id' => $request->user()->id,
                    'shop_id' => $request->shop_id,
                    'seller_id' => $shop->seller_id,
                    'message' => $request->message,
                    'sent_by_customer' => 1,
                    'seen_by_customer' => 0,
                    'created_at' => now(),
                ]);

                return response()->json(['message' => translate('sent')], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }
}
