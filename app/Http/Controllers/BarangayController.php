<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangays = Barangay::with(['fireStation','district','region'])->get();
        if($barangays){
            foreach($barangays as $barangay){
                if($barangay->fireStation){
                    $barangay->fire_station_name = $barangay->fireStation->name;
                }
                if($barangay->district){
                    $barangay->district_name = $barangay->district->name;
                }
                if($barangay->region){
                    $barangay->region_name = $barangay->region->name;
                }
            }
        }
        return $barangays;
    }

   
    public function create(Request $request)
    {
        $barangays = new Barangay;
        $barangays->name = $request->name;
        $barangays->address = $request->address;
        $barangays->contact_number = $request->contact_number;
        $barangays->fire_station_id = $request->fire_station_id;
        $barangays->district_id = $request->district_id;
        $barangays->region_id = $request->region_id;
        $barangays->save();
        return $barangays;
    }
 



    public function update(Request $request)
    {
        $barangays = Barangay::find($request->id);
        $barangays->name = $request->name;
        $barangays->address = $request->address;
        $barangays->contact_number = $request->contact_number;
        $barangays->fire_station_id = $request->fire_station_id;
        $barangays->district_id = $request->district_id;
        $barangays->region_id = $request->region_id;
        $barangays->save();
        return $barangays;
    }

    public function delete(Request $request)
    {
        $barangays = Barangay::find($request->id);
        $barangays->delete();
        return $barangays;
    }
}
