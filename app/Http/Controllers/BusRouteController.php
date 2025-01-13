<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusRouteController extends Controller
{
    public function show(){
        $regMerchants = Merchant::all();

        $regBusRoutes = DB::table('merchants')
            ->join('bus_routes', 'merchants.id', '=', 'bus_routes.merchant_id')
            ->select('merchants.*', 'bus_routes.id', 'bus_routes.routename','bus_routes.fare')
            ->get();

        return view('admin.manageRoutes',compact('regMerchants'),compact('regBusRoutes'));
    }

    public function showMerchantRoutes(string $phone)
    {
        $regBusRoutes = DB::table('merchants')
            ->join('users', 'merchants.phone', '=', 'users.phone')
            ->join('bus_routes', 'merchants.id', '=', 'bus_routes.merchant_id')
            ->select('merchants.*', 'users.phone', 'bus_routes.id', 'bus_routes.merchant_id', 'bus_routes.routename', 'bus_routes.fare')
            ->where('merchants.phone',$phone)
            ->get();

            return view('merchant.merchantBusRoutes',compact('regBusRoutes'));
    }

    public function store(Request $request) {
        $request->validate([
            'routename' => 'required|unique:bus_routes,routename'
        ],[
            'routename.unique' => 'This Route already exists',
        ]);

        $newBusRoute = BusRoute::create([
            'merchant_id' => $request->merchantID,
            'routename' => $request->routename,
            'from' => $request->from,
            'to' => $request->to,
            'fare' => $request->fare,
        ]);

        $newBusRoute->save();

        return redirect('admin/routeList')->with('message','Bus Route added Successfully');
    }

    public function destroy($id)
    {
        $data = BusRoute::find($id);

        $data->delete();

        return redirect()->back();
        
    }

}
