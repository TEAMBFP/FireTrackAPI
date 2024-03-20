<?php

namespace App\Http\Controllers;

use App\Models\CitizenIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Add this import statement
use Illuminate\Support\Str;
use App\Models\IncidentDetails;
use App\Models\FireStatus;
use App\Models\FireType;
use Carbon\Carbon;
use App\Events\IncidentReported;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Models\FireStation;
use App\Models\User;
use App\Models\AlarmLevel;



class CitizenIncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_report_incident()
    {
        $incidents = CitizenIncident::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $incidents->map(function($incident){
            $incident->image = url($incident->image);
            $user = User::find($incident->user_id);
            if($user){
                $incident->informat = $user->firstname.' '.$user->lastname;
            }
            $details = IncidentDetails::where('incident_id', $incident->id)->first();
            $status = FireStatus::find(json_decode($details->status)->status);
            if($details && $status){
                $incident->status = $status->status;
            }
            return $incident;
        });
        return $incidents;
        
    }

    public function citizenIncidents (Request $request){
        $query = "SELECT * FROM incidents";
        if ($request->month) {
            $query .= " WHERE MONTH(created_at) = " . $request->month;
        }
        
        if ($request->year) {
            $query .= $request->month ? " AND" : " WHERE";
            $query .= " YEAR(created_at) = " . $request->year;
        }
        if ($request->fire_station_id) {
            $query .= $request->month || $request->year ? " AND" : " WHERE";
            $query .= " fire_station_id = '" . $request->fire_station_id . "'";
        }
        
        $query .= " ORDER BY created_at DESC";
        $incidents = collect(DB::select($query));

        $incidents->transform(function ($incident) {
            $incident->image = url($incident->image);
            $user = User::find($incident->user_id);

            if ($user) {
                $userInfo = json_decode($user->info);

                if ($userInfo) {
                    $incident->informat = $user->firstname . ' ' . $user->lastname;
                    $incident->contactno = isset($userInfo->phone_no) ? $userInfo->phone_no : '';
                }
            }

            $details = IncidentDetails::where('incident_id', $incident->id)->first();
            $fireStation = FireStation::find($incident->fire_station_id);
            $incident->station = $fireStation ?->name;

            if ($details) {
                $type = json_decode($details->incident) ?->type;
                $status = json_decode($details->status) ?->status;

                if ($type) {
                    $incident->type = $type;
                }

                if ($status) {
                    $findStatus = FireStatus::find($status);
                    $incident->status = $findStatus ?->status;
                }
            }

            $incident->alarm_level = AlarmLevel::find($incident->alarm_level_id) ?->name;

            return $incident;
        });

        return $incidents;
    }

     public function updateStatus (Request $request){
        $incident = CitizenIncident::find($request->id);
        $incident->status = $request->status;
        $incident->save();
        return $incident;
     }

     public function deleteIncidenet (Request $request){
        $incident = CitizenIncident::find($request->id);
        $incident->delete();
        return $incident;
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $request->validate([
            'barangay' => 'required',
        ]);

        $incident = new CitizenIncident();
        $incident->user_id = $request->user_id;
        $incident->location = $request->location;
        $incident->barangay = $request->barangay;
        $incident->fire_station_id = $request->fire_station_id;

        $check = CitizenIncident::whereDate('created_at', Carbon::today())
            ->where('user_id', $request->user_id)
            ->where('location', $request->location)
            ->first();
        if($check){
            return response()->json(['msg'=>'You have already reported this incident'], 400);
        }
        $path = null;
        if ($request->image) {
            $image = $request->image;
            
            $image = str_replace('data:image/jpg;base64,', '', $image);
            
            $image = str_replace(' ', '+', $image);

            $imageName = 'incident-'.Str::random(10).'.'.'jpg';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $path = '/storage/'.$imageName;

        }
        $incident->image = $path;
        $incident->save();
        $details = new IncidentDetails();
        $details->incident_id = $incident->id;
        $details->status = json_encode(['status'=> 1]);
        $details->save();

        $notification = new Notification();
        $notification->incident_id = $incident->id;
        $notification->message = 'New incident reported by '.auth()->user()->firstname.' '. auth()->user()->lastname. ' in '.$incident->barangay;
        $notification->save();
        event(new IncidentReported($notification->message));
        return $incident;
    }

    public function getIncidentDetails(Request $request){
        $id = $request->id; 
        $incident = IncidentDetails::where('incident_id', $id)->first();
            if($incident){
                $incident->responder = json_decode($incident->responder);
                $incident->incident = json_decode($incident->incident);
                $incident->status = json_decode($incident->status);
                $incident->fireStatus =  FireStatus::get();
                $incident->alarm_level_id =  CitizenIncident::find($incident->incident_id)->alarm_level_id;
            }
      
        
        return $incident;
    }

    public function updateIncidentDetails (Request $request){
        $incident = IncidentDetails::firstOrNew(['incident_id'=>$request->id]);
        $incident->responder =  $request->responder;
        $incident->incident = $request->incident;
        $incident->status = $request->status;
        if($request->alarm_level_id){
            CitizenIncident::find($incident->incident_id)->update(['alarm_level_id'=>$request->alarm_level_id]);
        }
        $incident->save();
        $incident->responder = json_decode($incident->responder);
        $incident->incident = json_decode($incident->incident);
        $incident->status = json_decode($incident->status);
        $incident->alarm_level_id = $request->alarm_level_id;
        return $incident;
    }

  public function getDataSet(){
    $incidents = DB::table('incidents')
        ->select(DB::raw('YEAR(created_at) as year'), 'barangay', DB::raw('COUNT(*) as count'))
        ->groupBy('year', 'barangay')
        ->get();

    $years = [
        2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023,
    ];


    $incidents = $incidents->groupBy('barangay')->map(function($incident) use ($years){
        $data = [];
        foreach ($years as $year) {
            $data[$year] = 0;
        }
        foreach ($incident as $value) {
            $data[$value->year] = $value->count;
            $data['barangay'] = $value->barangay;
        }
        return $data;
    });

    $incident = $incidents->values()->toArray();
   
    

    return $incident;
    }





   
}