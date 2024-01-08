<?php

namespace App\Http\Controllers;

use App\Models\FireStatus;
use Illuminate\Http\Request;

class FireStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fireStatus = FireStatus::all();
        return $fireStatus;
    }

    public function create(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $fireStatus = FireStatus::create([
            'status' => $request->status,
        ]);

        return $fireStatus;
    }

    public function update(Request $request){
        $request->validate([
            'status' => 'required',
        ]);

        $fireStatus = FireStatus::find($request->id);
        $fireStatus->status = $request->status;
        $fireStatus->save();
        return $fireStatus;
    }

    public function delete (Request $request){
        $fireStatus = FireStatus::find($request->id);
        $fireStatus->delete();
        return $fireStatus;
    }

   
}
