<?php

namespace App\Http\Controllers;

use App\Models\AlarmLevel;
use Illuminate\Http\Request;

class AlarmLevelController extends Controller
{

    public function index()
    {
        return AlarmLevel::all();
    }

  
    public function create(Request $request)
    {
        $alarm = new AlarmLevel;
        $alarm->name = $request->name;
        $alarm->save();
        return $alarm;
    }
    
    public function update(Request $request)
    {
        $alarm = AlarmLevel::find($request->id);
        $alarm->name = $request->name;
        $alarm->save();
        return $alarm;
    }
  

    public function delete(Request $request)
    {
        $alarm = AlarmLevel::find($request->id);
        $alarm->delete();
        return $alarm;
    }
}
