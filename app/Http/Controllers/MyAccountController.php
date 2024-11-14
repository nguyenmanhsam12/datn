<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    public function myAccount(){
        $user = Auth::user();
        $status = OrderStatus::all();
        $order =  Order::with('cartItems','orderStatus')
            ->where('user_id',$user->id)
            ->get();
        return view('client.pages.myaccount',compact('status','order'));
    }
}
