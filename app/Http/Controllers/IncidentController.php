<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Add this import statement
use Illuminate\Support\Str;
use App\Models\IncidentDetails;
use App\Models\FireStatus;
use App\Models\FireType;
use Carbon\Carbon;
use App\Events\IncidentReported;
use Illuminate\Support\Facades\DB;




class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_report_incident()
    {
        $incidents = Incident::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $incidents->map(function($incident){
            unset($incident['user_id']);
            $incident->image = url($incident->image);
            $details = IncidentDetails::where('incident_id', $incident->id)->first();
            $status = FireStatus::find(json_decode($details->status)->status);
            if($details && $status){
                $incident->status = $status->status;
            }
            return $incident;
        });
        return $incidents;
        
    }

    public function reportedIncidents (Request $request) {

        $query = "
        SELECT * FROM (
            SELECT *, ROW_NUMBER() OVER (PARTITION BY location, DATE(created_at) ORDER BY created_at DESC) as rn
            FROM incidents
        ) t
        WHERE t.rn = 1";

        if ($request->month) {
            $query .= " AND MONTH(created_at) = " . $request->month;
        }

        if ($request->year) {
            $query .= " AND YEAR(created_at) = " . $request->year;
        }

        if ($request->station) {
            $query .= " AND station = '" . $request->station . "'";
        }

        $incidents = collect(DB::select($query));

   
        $incidents->transform(function($incident){
            unset($incident->user_id);
            $incident->image = url($incident->image);

            $details = IncidentDetails::where('incident_id', $incident->id)->first();
          
            
            if($details){
                $type = json_decode($details->incident)?->type;
                $status = json_decode($details->status)?->status;


                if($type){
                    $findType = FireType::find($type);
                    $incident->type = $findType?->name;
                }

                if($status){
                    $findStatus = FireStatus::find($status);
                    $incident->status = $findStatus?->status;
                }
               
            }
          
            return $incident;
        });

        return $incidents;
       
    }

     public function updateStatus (Request $request){
        $incident = Incident::find($request->id);
        $incident->status = $request->status;
        $incident->save();
        return $incident;
     }

     public function deleteIncidenet (Request $request){
        $incident = Incident::find($request->id);
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
        $incident = new Incident();
        $incident->user_id = $request->user_id;
        $incident->location = $request->location;
        $incident->barangay = $request->barangay;
        $incident->station = $request->station;

        $check = Incident::whereDate('created_at', Carbon::today())
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
        event(new IncidentReported('New incident reported'));
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
            }
      
        
        return $incident;
    }

    public function updateIncidentDetails (Request $request){
        $incident = IncidentDetails::firstOrNew(['incident_id'=>$request->id]);
        $incident->incident_id = $request->id;
        $incident->responder =  $request->responder;
        $incident->incident = $request->incident;
        $incident->status = $request->status;
        $incident->save();
        $incident->responder = json_decode($incident->responder);
        $incident->incident = json_decode($incident->incident);
        $incident->status = json_decode($incident->status);

        return $incident;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        //
    }
}
