<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    
    public function index()
    {
        $userTypes = UserType::all();
        return $userTypes;
    }

  
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:user_types',
        ]);
        $userType = UserType::create([
            'name' => $request->name,
        ]);
        return $userType;
    }


  

    public function edit(Request $request)
    {
        $userType = UserType::find($request->id);
        $userType->name = $request->name;
        $userType->save();
        return $userType;
    }

    public function delete(Request $request)
    {
        $userType = UserType::find($request->id);
        $userType->delete();
        return $userType;
    }

}
