<?php

namespace App\Http\Controllers;

use App\Models\FireType;
use Illuminate\Http\Request;

class FireTypeController extends Controller
{
    public function index()
    {
        $fireTypes = FireType::all();
        return $fireTypes;
    }
    


    public function fireTypes(Request $request)
    {
         $types = FireType::where('type', $request->type)->get();
         return $types;
    }

    public function fireTypeName(Request $request)
    {
        $fireTypeName = FireType::where('type', $request->type)->where('name', $request->name)->first();
        return $fireTypeName;
    }

    


    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $fireType = FireType::create([
            'name' => $request->name,
        ]);

        return $fireType;
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
        ]);

        $fireType = FireType::find($request->id);
        $fireType->name = $request->name;
        $fireType->save();
        return $fireType;
    }

    public function delete (Request $request){
        $fireType = FireType::find($request->id);
        $fireType->delete();
        return $fireType;
    }

}
