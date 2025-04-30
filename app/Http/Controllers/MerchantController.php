<?php

namespace App\Http\Controllers;

use App\Models\BusInfo;
use App\Models\Transaction;
use Carbon\Carbon;
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
            ->select('users.id', 'users.name', 'users.wallet_balance', 'users.email', 'merchants.merchantname')
            ->get();
        
        return view('admin.showMerchants',compact('merchants'));
    }

    public function displayTransDetails($id){

        $trans_details = DB::table('transactions')->where('account_id', $id)->orderBy('id','desc')->paginate(10);
            
        return view('merchant.transDetails',compact('trans_details'));
    }

    public function allTransDetails(){

        $alltrans_details = DB::table('transactions')->orderBy('id','desc')->paginate(20);
            
        return view('admin.transDetail',compact('alltrans_details'));
    }

    public function displayTransSummary($id){

        $dailySums = DB::table('transactions')
                        ->select(DB::raw('DATE(created_at) as record_date,account_id'), DB::raw('SUM(amount) as day_sum'))
                        ->where('account_id','=',$id)
                        ->whereBetween('created_at',[Carbon::now()->firstOfMonth(),Carbon::now()->endOfMonth()])
                        ->groupBy(DB::raw('DATE(created_at),account_id'))
                        ->orderBy('record_date','desc')
                        ->get();
        return view('merchant.transSummary',compact('dailySums'));
    }

    public function allTransSummary(){

        $alltrans_summary = DB::table('transactions')
                        ->select(DB::raw('DATE(created_at) as record_date'), DB::raw('SUM(amount) as day_sum'))
                        ->whereBetween('created_at',[Carbon::now()->firstOfMonth(),Carbon::now()->endOfMonth()])
                        ->groupBy(DB::raw('DATE(created_at)'))
                        ->orderBy('record_date','desc')
                        ->get();
        return view('admin.transSum',compact('alltrans_summary'));
    }

    public function displayBalHistory($id){

        $bal_history = DB::table('transactions')->where('account_id', $id)->where('desc','<>','credit')->orderBy('created_at','desc')->paginate(10);
    
        return view('merchant.balHistory',compact('bal_history'));
    }
}
