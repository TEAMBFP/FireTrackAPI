<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
  
    public function index()
    {
        $regions = Region::get();
        return $regions;
    }


    public function create(Request $request)
    {
        $regions = new Region;
        $regions->name = $request->name;
        $regions->save();
        return $regions;
    }


    public function update(Request $request)
    {
        $regions = Region::find($request->id);
        $regions->name = $request->name;
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
