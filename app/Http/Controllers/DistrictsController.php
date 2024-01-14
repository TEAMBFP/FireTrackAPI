<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use Illuminate\Http\Request;

class DistrictsController extends Controller
{
   
    public function index()
    {
        $districts = Districts::all();
        return $districts;
    }

  
    public function create(Request $request)
    {
        $districts = new Districts;
        $districts->name = $request->name;
        $districts->save();
        return $districts;
    }

    public function update(Request $request)
    {
        $districts = Districts::find($request->id);
        $districts->name = $request->name;
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
