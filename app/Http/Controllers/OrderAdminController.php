<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    // Giao diện admin
    public function index(){
        return view('admin.order.list');
    }

    public function detail() {
        return view('admin.order.detailOrder');
    }
}
