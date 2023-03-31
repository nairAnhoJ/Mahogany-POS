<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index(){
        return view('user.cook.kitchen-display');
    }
}