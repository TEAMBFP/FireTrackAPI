<?php

namespace App\Http\Controllers;

use App\Models\FireStation;
use Illuminate\Http\Request;

class FireStationController extends Controller
{

    public function index(Request $request)
    {
       $fireStations = [] ;
       if($request->district){
        $fireStations = FireStation::whereRaw('LOWER(district) = ?', [strtolower($request->district)])->get();
       }else{
            $fireStations = FireStation::all();
       }
     
        return response()->json($fireStations);
    }

    public function create(Request  $request)
    {
        $fireStation = new FireStation;
        $fireStation->address = $request->address;
        $fireStation->district = $request->district;
        $fireStation->latitude = $request->latitude;
        $fireStation->longitude = $request->longitude;
        $fireStation->number = $request->number;
        $fireStation->save();
        return response()->json($fireStation);
    }

    public function update(Request $request){
        $fireStation = FireStation::find($request->id);
        $fireStation->address = $request->address;
        $fireStation->district = $request->district;
        $fireStation->latitude = $request->latitude;
        $fireStation->longitude = $request->longitude;
        $fireStation->number = $request->number;
        $fireStation->save();
        return response()->json($fireStation);
    }

    public function delete(Request $request){
        $fireStation = FireStation::find($request->id)->delete();
        return response()->json($fireStation);
    }

}
