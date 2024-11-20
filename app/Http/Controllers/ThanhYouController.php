<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThanhYouController extends Controller
{
    public function thankyou() {
        return view('client.pages.thankyou');
    }
}
