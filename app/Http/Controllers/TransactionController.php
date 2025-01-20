<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function makeDeposit(Request $request)
    {
        if (Auth::check())
        {
            $userID = Auth::user()->id;
            $user = User::find($userID);
            $depositAmount = $request->amount;
            if ($depositAmount > 0)
            {
                $user->deposit($depositAmount);
                $trans = Transaction::create([
                    'desc'=>"deposit",
                    'account_id'=>$userID,
                    'amount'=>$depositAmount,
                    'balance'=>$user->wallet_balance
                ]);

                $trans->save();

                return response()->json([
                    'message'=>'Deposit Successful',
                    'data'=>$user
                ],201);
            } else {
                return response()->json([
                    'message'=>'Invalid Deposit Amount',
                ],401);
            }
        } else {
            return response()->json([
                'message'=>'Invalid Request',
            ],401);
        }
    }

    public function makeTransfer(Request $request)
    {
        if (Auth::check())
        {
            $senderuserID = Auth::user()->id;
            $senderuser = User::find($senderuserID);
            $senderBalance = Auth::user()->wallet_balance;
            $receiveruserID = $request->account_id;
            $receiveruser = User::find($receiveruserID);
            

            if ($receiveruser->count() > 0)
            {
                $transferAmount = $request->amount;
                if ($transferAmount > 0)
                {
                    if($senderBalance > $transferAmount)
                    {
                        $senderuser->withdraw($transferAmount);
                        $receiveruser->deposit($transferAmount);
                        DB::table('transactions')->insert([
                        [
                            'desc'=>"debit",
                            'account_id'=>$senderuserID,
                            'amount'=>$transferAmount,
                            'balance'=>$senderuser->wallet_balance,
                            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
                            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
                        ],[
                            'desc'=>"credit",
                            'account_id'=>$receiveruserID,
                            'amount'=>$transferAmount,
                            'balance'=>$receiveruser->wallet_balance,
                            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
                            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
                        ]]);
                        return response()->json([
                            'message'=>'Transfer Successful',
                            'data'=>$senderuser,
                            'old_balance'=>$senderBalance
                        ],200);
                    } else {
                        return response()->json([
                            'message'=>'Insufficient Funds',
                        ],401); 
                    }
                } else {
                    return response()->json([
                        'message'=>'Invalid Transfer Amount',
                    ],401);
                }
            } else {
                return response()->json([
                    'message'=>'Invalid Receiver Account',
                ],401);
            }    
        } else {
            return response()->json([
                'message'=>'Invalid Request',
            ],401);
        }
    }

    public function getBalance()
    {
        if (Auth::check())
        {
            $balance = Auth::user()->wallet_balance;
            $name = Auth::user()->name;
            return response()->json([
                'name'=>$name,
                'balance'=>$balance
            ],200);
        } else {
            return response()->json([
                'message'=>'Invalid Request',
            ],401);
        }
    }

    public function getHistory()
    {
        if (Auth::check())
        {
            $accountID = Auth::user()->id;

            $userHistory = DB::table('transactions')->where('account_id', $accountID)->orderBy('id','desc')->limit(10)->get();
            return response()->json($userHistory,200);
        } else {
            return response()->json([
                'message'=>'Invalid Request',
            ],401);
        }
    }

    public function buyTicket(Request $request)
    {
        if (Auth::check())
        {
            $routeID = $request->route_id;
            $busRoute = BusRoute::find($routeID);
            $senderuserID = Auth::user()->id;
            $senderuser = User::find($senderuserID);
            $senderBalance = Auth::user()->wallet_balance;
            $merchantID = $request->merchant_id;
            $merchantUser = User::find($merchantID);
            

            if ($merchantUser->count() > 0)
            {
                $ticketAmount = $request->amount;
                if ($ticketAmount > 0)
                {
                    if($senderBalance > $ticketAmount)
                    {
                        $senderuser->withdraw($ticketAmount);
                        $merchantUser->deposit($ticketAmount);
                        DB::table('transactions')->insert([
                        [
                            'desc'=>"debit",
                            'account_id'=>$senderuserID,
                            'amount'=>$ticketAmount,
                            'balance'=>$senderuser->wallet_balance,
                            'route'=>$busRoute->routename,
                            'merchant_id'=>$busRoute->merchant_id,
                            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
                            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
                        ],[
                            'desc'=>"credit",
                            'account_id'=>$merchantID,
                            'amount'=>$ticketAmount,
                            'balance'=>$merchantUser->wallet_balance,
                            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
                            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
                        ]]);
                        return response()->json([
                            'message'=>'Payment Successful',
                            'data'=>$senderuser,
                            'old_balance'=>$senderBalance
                        ],200);
                    } else {
                        return response()->json([
                            'message'=>'Insufficient Funds',
                        ],401); 
                    }
                } else {
                    return response()->json([
                        'message'=>'Invalid Ticket Amount',
                    ],401);
                }
            } else {
                return response()->json([
                    'message'=>'Invalid Merchant Account',
                ],401);
            }    
        } else {
            return response()->json([
                'message'=>'Invalid Request',
            ],401);
        }
    }
}
