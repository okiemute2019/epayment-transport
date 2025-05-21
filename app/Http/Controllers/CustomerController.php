<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\BusInfo;
use App\Models\BusRoute;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;


class CustomerController extends Controller
{
    public function loginUser(LoginRequest $request){
        
        $request->authenticate();
        
        $token = $request->user()->createToken('api_token');

        if (!Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json([
                'message'=>'Invalid Login credentials',
            ],401);
        } else {
            
            $user = Auth::user();
            return response()->json([
                'message'=>'Login Successful',
                'data'=>$user,
                'api-token'=>$token->plainTextToken,
                'token_type'=>'Bearer'
            ],200);
        }

    }

    public function registerUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:11', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()){

            return response()->json([
                'message'=>'Registration Failed. Phone and Email must be unique',
                'errors'=>$validator->errors(),
            ],422);

        } else {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $user->save();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message'=>'Registration Successful',
            'data'=>$user,
            'access_token'=>$token,
            'token_type'=>'Bearer'
        ],201);
        }
    }

    public function logoutUser(Request $request){
        if (session('_token')){
        $request->session()->invalidate();

        return response()->json([
            'message'=>'Logout Successful'
        ],200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function updateUserProfile(Request $request){
        if (Auth::check()){
            $userID = Auth::user()->id;
            $user = User::find($userID);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->trans_pin = $request->trans_pin;

            $user->save();

            return response()->json([
                'message'=>'Update Successful',
                'data'=>$user
            ],200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function getMerchants(){
        if (Auth::check()){
            $merchants = Merchant::all();
            return response()->json($merchants,200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function getRouteCount($id){
        if (Auth::check()){
            $routes = BusRoute::where('merchant_id',$id)->get();
            $routeCount = $routes->count();
            return response()->json($routeCount,200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function getMerchantRoutes($id){
        if (Auth::check()){
            $routes = DB::table('bus_routes')
                        ->join('merchants', 'bus_routes.merchant_id', '=', 'merchants.id')
                        ->select('bus_routes.*', 'merchants.merchantname')
                        ->where('bus_routes.merchant_id',$id)
                        ->get();

            return response()->json($routes,200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function getBusCount($id){
        if (Auth::check()){
            $buses = BusInfo::where('merchant_id',$id)->get();
            $busCount = $buses->count();
            return response()->json($busCount,200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function getMerchantBuses($id){
        if (Auth::check()){
            $buses = BusInfo::where('merchant_id',$id)->get();

            return response()->json([
                'data'=>$buses
            ],200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }

    public function sendUserComplaint(Request $request){
        if (Auth::check()){
            $userID = Auth::user()->id;
            $user = User::find($userID);
            $senderEmail = $user->email;
            $senderPhone = $user->phone;
            $senderMessage = $request->message;

            return response()->json([
                'message'=>'Dispute submitted Successfully',
                'data'=>$senderEmail
            ],200);
        } else {
            return response()->json([
                'message'=>'Unauthorized'
            ],401);
        }
    }
}
