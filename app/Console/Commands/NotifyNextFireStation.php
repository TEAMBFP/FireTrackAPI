<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Incident;
use App\Models\IncidentDetails;
use App\Models\FireStation;
use App\Models\User;
use Carbon\Carbon;
use App\Events\NotifyNextStation;

class NotifyNextFireStation extends Command
{
   
    protected $signature = 'command:NotifyNextFireStation';

  
    protected $description = 'Notify next fire station when assigned station is busy or not available.';

   
    public function handle()
    {
        $incidents = Incident::with('details')->whereHas('details', function ($query) {
            $query->where('status->status', '1');
        })->whereDate('created_at', Carbon::today())->get();
        
        if(count($incidents) > 0){
            $stations = FireStation::get();
            $distances = [];
            foreach ($incidents as $key => $incident) {
                foreach ($stations as $station) {
                    $inactiveStation = FireStation::find($incident->fire_station_id);
                
                    $distance = $this->get_meters_between_points(
                        $inactiveStation->latitude, 
                        $inactiveStation->longitude, 
                        $station->latitude, 
                        $station->longitude
                    );
                    array_push($distances, [
                        'distance' => $distance,
                        'firestation' => $station->name,
                        'firestation_id' => $station->id
                    ]);
                }


            }
            asort($distances);
            $nearestStation = $distances[1];
        
        
            $user = User::where('info->firestation_id', $nearestStation['firestation_id'])->first();
            if($user){
                $message = "New incident reported in nearby area. Please respond immediately.";
                event(new NotifyNextStation($user, $message));
            }
        }
      
    }

    public function get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
        if (($latitude1 == $latitude2) && ($longitude1 == $longitude2)) { return 0; } // distance is zero because they're the same point
        $p1 = deg2rad($latitude1);
        $p2 = deg2rad($latitude2);
        $dp = deg2rad($latitude2 - $latitude1);
        $dl = deg2rad($longitude2 - $longitude1);
        $a = (sin($dp/2) * sin($dp/2)) + (cos($p1) * cos($p2) * sin($dl/2) * sin($dl/2));
        $c = 2 * atan2(sqrt($a),sqrt(1-$a));
        $r = 6371008; // Earth's average radius, in meters
        $d = $r * $c;
        return $d; // distance, in meters
    }
}
