<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification = Notification::get();
        return $notification;
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->id);
        if(!$notification){
            return response()->json(['message' => 'Notification not found'], 404);
        }
        $incident = Incident::find($notification->incident_id);
        if(!$incident){
            return response()->json(['message' => 'Incident not found'], 404);
        }
        $user = User::find($incident->user_id);
        $notification->status = 1;
        $notification->save();
        $incident->image = url($incident->image);
        $incident->reporter = $user->name;
        return $incident;
        
    }

  
}
