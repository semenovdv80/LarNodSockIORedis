<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Support\Facades\Redis;
use Request;

class ChatController extends Controller {

    public function sendMessage(){
        $data = ['message' => request()->message, 'user' => auth()->id()];
        $redis = Redis::connection();
        $redis->publish('message', json_encode($data));
        return response()->json([]);
    }
}