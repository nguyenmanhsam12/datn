<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplanintsController extends Controller
{
    public function complaints(){
        return view('client.pages.complaint');
    }
}
