<?php

namespace App\Http\Controllers;

use App\Models\FireStation;
use Illuminate\Http\Request;

class FireStationController extends Controller
{

    public function index(Request $request)
    {
       $fireStations = [] ;
       $fireStations = FireStation::with(['district', 'district.region']);


        if($request->district_id){
            $fireStations = $fireStations->where('district_id', $request->district_id);
        }

        if($request->region_id){
            $fireStations = $fireStations->whereHas('district', function ($query) use ($request) {
                $query->where('region_id', $request->region_id);
            });
        }

        $fireStations = $fireStations->get();

        foreach($fireStations as $fireStation){
           if($fireStation->district){
               $fireStation->district_name = $fireStation->district->name;
           }
        }

        return response()->json($fireStations);
    }

    public function create(Request  $request)
    {
        $fireStation = new FireStation;
        $fireStation->name = $request->name;
        $fireStation->address = $request->address;
        $fireStation->district_id = $request->district_id;
        $fireStation->latitude = $request->latitude;
        $fireStation->longitude = $request->longitude;
        $fireStation->number = $request->number;
        $fireStation->save();
        return response()->json($fireStation);
    }

    public function update(Request $request){
        $fireStation = FireStation::find($request->id);
        $fireStation->address = $request->address;
        $fireStation->district_id = $request->district_id;
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
