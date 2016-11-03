<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;

class IndexController extends Controller{

    public function index(){
        echo 111;
        return view('wx.index');
    }
}