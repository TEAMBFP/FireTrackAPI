<?php

namespace App\Http\Controllers;

use App\Models\FireOccupancy;
use Illuminate\Http\Request;

class FireOccupancyController extends Controller
{
   
    public function index()
    {
        $occupancies = FireOccupancy::with('fireType')->get();
        foreach ($occupancies as $occupancy) {
            $occupancy->fire_type_name = $occupancy->fireType->name;
        }
        return $occupancies;
    }

    
    public function create (Request $request)
    {
        $occupancy = FireOccupancy::create([
            'name' => $request->name,
            'fire_type_id' => $request->fire_type_id
        ]);
        return $occupancy;
    }
    

    
    public function update(Request $request)
    {
        $occupancy = FireOccupancy::find($request->id);
        $occupancy->update([
            'name' => $request->name,
            'fire_type_id' => $request->fire_type_id
        ]);
        return $occupancy;
    }

  
    public function delete (Request $request)
    {
        $occupancy = FireOccupancy::find($request->id);
        $occupancy->delete();
        return $occupancy;
    }
   
}
