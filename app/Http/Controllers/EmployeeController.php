<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();
        $employees = User::with('userType')->where('email_verified_at', '!=', null);

        if($user->user_type_id === 1 ){
            $employees->whereNotNull('info->district_id');
            
        }
        
        if($user->user_type_id === 2 && json_decode($user->info)->district_id){
            $employees->where('info->district_id', json_decode($user->info)->district_id)
            ->whereNotNull('info->firestation_id');
        }

        if($user->user_type_id === 3 && json_decode($user->info)->firestation_id){
              $employees = User::where('user_type_id', '!=', 3)->where('info->firestation_id', json_decode($user->info)->firestation_id);
        }

        if($user->user_type_id === 5){
            $employees = User::where('user_type_id', '!=', 5);
        }

        

        $employees = $employees->get();
        foreach($employees as $employee){
            $employee->position = $employee->userType->name;
            $employee->contact_number = json_decode($employee->info)->phone_no;
        }
       return $employees;
    }

  
    public function delete (Request $request){
        $user = User::find($request->id);
        $user->delete();
        return $user;
    }

    public function update (Request $request){
        $user = User::find($request->id);
        $user->user_type_id = $request->user_type_id;
        $user->save();
    }

  
    
}
