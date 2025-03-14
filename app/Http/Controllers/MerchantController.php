<?php

namespace App\Http\Controllers;

use App\Models\BusInfo;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MerchantController extends Controller
{
    public function index(){
        if (Auth::check()){
            $user_id = Auth::user()->id;
            $bus_num = BusInfo::where('merchant_id', $user_id)->count();
            $day_summary = Transaction::where('account_id', $user_id)
            ->where('desc', '=', 'credit')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->sum('amount');
            
        }
        return view('merchant.dashboard',compact('bus_num','day_summary'));
    }

    public function show(){
        $merchants = DB::table('users')
            ->join('merchants', 'users.email', '=', 'merchants.email')
            ->select('users.*', 'merchants.merchantname')
            ->get();
        
        return view('admin.showMerchants',compact('merchants'));
    }
}
