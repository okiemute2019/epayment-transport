<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MerchantController extends Controller
{
    public function index(){
        return view('merchant.dashboard');
    }

    public function show(){
        $merchants = DB::table('users')
            ->join('merchants', 'users.email', '=', 'merchants.email')
            ->select('users.*', 'merchants.merchantname')
            ->get();
        
        return view('admin.showMerchants',compact('merchants'));
    }
}
