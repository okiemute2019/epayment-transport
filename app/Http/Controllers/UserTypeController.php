<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserTypeController extends Controller
{
    public function index(){
        $user_num = User::where('role', 'customer')->count();
        $merchant_num = User::where('role', 'merchant')->count();
        $transactions = DB::table('transactions')->count();
        $trans_amount = Transaction::where('desc', '<>', 'debit')->sum('amount');
        return view('admin.dashboard',compact('user_num','merchant_num','transactions','trans_amount'));
    }
}
