<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Input;

class FileController extends Controller
{
    /* 
     * Load the view for uploading text file
     *
     */
    public function uploadFile()
    {
        return view('upload_file');
    }

    /**
     * @param file input
     * 
     * @return array of affiliates data matching distance criteria
     */
    public function submitFile(Request $request)
    {

        $file = $request->file('textfile');
        $contents = file_get_contents($file->getRealPath());
        $contents = preg_replace( "/\n/", ",", $contents );
        $contents = "[".trim($contents)."]";
        $contents = json_decode($contents, TRUE);

        $office = \Config::get('constants.office_coordinates');

        $data = [];
        if(is_array($contents) ){
            if( !empty($contents) ){
                foreach($contents as $value){
                    // get distance between 2 coords (in Km)
                    $distance = $this->haversineGreatCircleDistance(
                        $office['latitude'], $office['longitude'],$value['latitude'], $value['longitude']
                    );
                    // affiliates matching our criteria
                    if($distance < 100){
                        $data[] = $value;
                    }
                }

                usort($data, function($a, $b) {
                    return $a['affiliate_id'] <=> $b['affiliate_id'];
                });
            }
        }
        else{
            return redirect()->back()->withErrors(['fileerror' => "Invalid data provided in the file"]);
        }
        return view('submit_file', compact('data'));
    }


    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    public function haversineGreatCircleDistance(
      $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
    }
}
