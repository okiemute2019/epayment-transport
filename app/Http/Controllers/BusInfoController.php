<?php

namespace App\Http\Controllers;

use App\Models\BusInfo;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusInfoController extends Controller
{
    public function show(){
        $regMerchants = Merchant::all();

        $regBuses = DB::table('merchants')
            ->join('bus_infos', 'merchants.id', '=', 'bus_infos.merchant_id')
            ->select('merchants.*', 'bus_infos.id', 'bus_infos.bus_code','bus_infos.bus_model')
            ->get();

        return view('admin.manageBuses',compact('regMerchants'),compact('regBuses'));
    }

    public function showMerchantBuses(string $phone)
    {
        $regBusInfos = DB::table('merchants')
            ->join('users', 'merchants.phone', '=', 'users.phone')
            ->join('bus_infos', 'merchants.id', '=', 'bus_infos.merchant_id')
            ->select('merchants.*', 'users.phone', 'bus_infos.id', 'bus_infos.merchant_id', 'bus_infos.bus_code', 'bus_infos.bus_model','bus_infos.plate_no')
            ->where('merchants.phone',$phone)
            ->get();

            return view('merchant.merchantBuses',compact('regBusInfos'));
    }

    public function store(Request $request) {
        $newBusInfo = BusInfo::create([
            'bus_code' => $request->buscode,
            'bus_model' => $request->busmodel,
            'plate_no' => $request->plate_no,
            'merchant_id' => $request->merchantID,
        ]);

        $newBusInfo->save();

        return redirect('admin/busList')->with('message','Bus Info added Successfully');
    }

    public function destroy($id)
    {
        $data = BusInfo::find($id);

        $data->delete();

        return redirect()->back();
        
    }
}
