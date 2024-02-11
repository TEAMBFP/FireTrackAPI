<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
  
    public function index()
    {
        $regions = Region::with('user')->get();
        foreach($regions as $region){
            if($region->user){
                $region->office_head = $region->user->firstname . " " . $region->user->lastname;
            }
        }
        return $regions;
    }


    public function create(Request $request)
    {
        $region = new Region;
        $region->name = $request->name;
        $region->address = $request->address;
        $region->contact = $request->contact;
        $region->user_id = $request->user_id;
        $region->save();
        return $region;
    }


    public function update(Request $request)
    {
        $regions = Region::find($request->id);
        $regions->name = $request->name;
        $regions->address = $request->address;
        $regions->contact = $request->contact;
        $regions->user_id = $request->user_id;
        $regions->save();
        return $regions;
    }

    public function delete(Request $request)
    {
        $regions = Region::find($request->id);
        $regions->delete();
        return $regions;
    }
  
}
