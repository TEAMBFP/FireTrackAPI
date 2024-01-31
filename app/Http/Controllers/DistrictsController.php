<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use Illuminate\Http\Request;

class DistrictsController extends Controller
{
   
    public function index()
    {
        $districts = Districts::with('region')->with('user')->get();
        foreach($districts as $district){
            if($district->region){
                 $district->region_name = $district->region->name;
            }
           
            if($district->user){
                $district->district_head = $district->user->firstname . " " . $district->user->lastname;
            }
            
        }
        return $districts;
    }

  
    public function create(Request $request)
    {
        $districts = new Districts;
        $districts->name = $request->name;
        $districts->user_id = $request->user_id;
        $districts->post_code = $request->post_code;
        $districts->region_id = $request->region_id;
        $districts->save();
        return $districts;
    }

    public function update(Request $request)
    {
        $districts = Districts::find($request->id);
        $districts->name = $request->name;
        $districts->user_id = $request->user_id;
        $districts->post_code = $request->post_code;
        $districts->region_id = $request->region_id;
        $districts->save();
        return $districts;
    }

    public function delete(Request $request)
    {
        $districts = Districts::find($request->id);
        $districts->delete();
        return $districts;
    }

}
