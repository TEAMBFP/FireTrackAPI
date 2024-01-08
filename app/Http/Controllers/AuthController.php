<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage; // Add this import statement





class AuthController extends Controller
{
    

   
    public function register(Request $request)
    {
        // defaults to user, requests here coming from mobile app
        // if($request->type){
        //     response()->json(["msg" => 'Not Found'],404);
        // }
         $request->validate([
            'email' => 'required|email|max:50|unique:users',
            'name'=>'required|max:50',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'info' => json_encode($request->info),
        ]);
        event(new Registered($user));
        return ['token' =>  $user->createToken('auth_token')->plainTextToken, "user"=>$user];
    }

    public function adminRegister(Request $request)
    {
       
         $request->validate([
            'email' => 'required|email|max:50|unique:users',
            'name' => 'required|max:50',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => 'admin',
            'info' => json_encode($request->info),
        ]);
        $user->info = json_decode($user->info);
        return ['token' =>  $user->createToken('auth_token')->plainTextToken, "user"=>$user];
    }
    

   
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
      
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'msg' => ['The provided credentials are incorrect.'],
            ]);
        }

        if($user->user_type=='admin'){
            return response()->json(["message" => 'You are not allowed to login here'],404);
        }

        unset($user['code']);
        $user->info = json_decode($user->info);

        if($user->image){
            $user->image = url($user->image);
        }
     
        return ['token'=>$user->createToken('auth_token')->plainTextToken, 'user'=>$user];
       
    }

    public function adminLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
      
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'msg' => ['The provided credentials are incorrect.'],
            ]);
        }

        if($user->user_type=='user'){
            return response()->json(["message" => 'You are not allowed to login here'],404);
        }

        unset($user['code']);
        $user->info = json_decode($user->info);
        if($user->image){
            $user->image = url($user->image);
        }
     
        return ['token'=>$user->createToken('auth_token')->plainTextToken, 'user'=>$user];
       
    }
    
    public function logout(Request $request){
       
        $request->user()->currentAccessToken()->delete();
       
    }

    public function forgot(Request $request) {

        $input = $request->validate(['email' => 'required|email']);
        $registered_user = DB::table('users')->where('email', $request->email)->first();
        if(!$registered_user){
            throw ValidationException::withMessages([
                'msg' => ['We couldn\'t find an account with that email adress'],
            ]);
        }

        $status = Password::sendResetLink($input);
            return $status === "passwords.sent"
                    ? response()->json(["msg" => 'Please check your email address for a reset password'])
                    :response()->json(["msg" => 'Error request reset password, Please try again later'],500);
      
         
    }

    

    public function changeForgottenPassword(Request $request){
       
        $validInput = $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);
   

        $user = User::where('email', $request->email)->first();
      
        if($user){

            //save password
            $user->password = bcrypt($request->password);
            $user->save();

            //delete reset password token
            DB::delete('DELETE FROM password_resets WHERE email = ?', [$request->email]);
            
            return response()->json(["status"=>"Successfully reset password"]);
        }
    
    }

    public function change_pass (Request $request){
        $user = User::find($request->id);
        if(!$user){
            return response() -> json(["msg"=>"User not found"],404);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }

    public function checkEmailResetPassword(Request $request) {
        $email = $request->email;
        $emailWithResetToken =  DB::table('password_resets')->where('email', $email)->first();
        if(!$emailWithResetToken){
            return response() -> json(
                ["msg"=>"Request not found. please request a reset password for your email"]
            ,404);
        }


        if(!Hash::check($request->token, $emailWithResetToken->token)){
            return response() -> json(["Invalid token, please try again"],404);
        }

        return response() -> json(["status"=>"success"]);
         
    }

    public function user()
    {
         $user = Auth::user();
         if($user->image){
            $user->image = url($user->image);
         }
         return $user;
    }

    public function updateUser(Request $request){
        $user = User::find($request->id);
        if(!$user){
            return response() -> json(["msg"=>"User not found"],404);
        }
           $user->email = $request->email;
           $user->info = json_encode($request->info);
           $path = null;
            if ($request->image && strpos($request->image, 'data:image/') !== false) {
                $image = $request->image;
                $ext = $this->getImageExt($image);
               
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace('data:image/png;base64,', '', $image);
                
                $image = str_replace(' ', '+', $image);

                $imageName = $user->email.'-profile'.'.'.$ext;
                Storage::disk('public')->put($imageName, base64_decode($image));
                $path = '/storage/'.$imageName;

            }
           $user->image = $path ? $path : $request->image;
           $user->save();
           $user->image = url($user->image);
           $user->info = $request->info;
           
        return $user;
    }

    private function getImageExt($image) {

        // Extract the MIME type from the base64 string
        list($type, $imageData) = explode(';', $image);
        list(, $mimeType) = explode(':', $type);

        // Map the MIME type to a file extension
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            // Add more mappings if needed
        ];

        $extension = isset($extensions[$mimeType]) ? $extensions[$mimeType] : null;
        return $extension;
    }

    
    
   
    public function destroy($id)
    {
        
    }
}
