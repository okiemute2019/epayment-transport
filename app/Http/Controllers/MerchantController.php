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

    public function displayTransDetails($id){

        $trans_details = DB::table('transactions')->where('account_id', $id)->orderBy('id','desc')->paginate(10);
            
        return view('merchant.transDetails',compact('trans_details'));
    }

    public function displayTransSummary($id){

        $trans_summary = DB::table('transactions')->where('account_id', $id)->whereBetween('created_at',[Carbon::now()->firstOfMonth(),Carbon::now()->endOfMonth()])->get();
        
        return view('merchant.transSummary',compact('trans_summary'));
    }

    public function displayBalHistory($id){

        $bal_history = DB::table('transactions')->where('account_id', $id)->where('desc','<>','credit')->orderBy('created_at','desc')->paginate(10);
    
        return view('merchant.balHistory',compact('bal_history'));
    }
}
