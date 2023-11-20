<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;



class ResetPasswordController extends Controller
{   
    public function request_reset (Request $request) {
        $request->validate([
            'email' => 'email', 
        ]);
        $email =  $request->email;
        $user = User::where('email',$email)->first();
        if(!$user){
            return response()->json([
                'message' => 'Email not registered',
            ], 404);
        }
        $code =Str::random(4);
        $user->code = $code;
        $user->save();
        $data = [
            'code'=>$code
        ];
        Mail::to($request->email)->send(new ResetPassword($data));
    }

    public function find_code (Request $request){
       
        $email = $request->email;
        $code = $request->code;
        $user = User::where('email',$email)->where('code',$code)->first();
        if(!$user){
             return response()->json([
                'message' => 'Not Found code',
            ], 404);
        }
        return $user;
      
    }

    public function submit_reset (Request $request) {
         $request->validate([         
            'password' => 'required|confirmed'
        ]);
        $email = $request->email;
        $code = $request->code;
        $password = $request->password;
        $user = User::where('email',$email)->where('code',$code)->first();
        if(!$user){
             return response()->json([
                'message' => 'Email not registered',
            ], 404);
        }
        $user->password = bcrypt($password);
        $user->code = '';
        $user->save();
    }
 
}
