<?php
namespace App\Traits;

// use Illuminate\Support\Str;
// use Ballen\Distical\Calculator as DistanceCalculator;
// use Ballen\Distical\Entities\LatLong;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\Point;

trait LocationTrait
{
    public function get_zone_from_location($data)
    {
        $point = new Point($data['latitude'], $data['longitude']);
        $zone_ids = array_column(Zone::contains('coordinates', $point)->latest()->get(['id'])->toArray(), 'id');;

       if(empty($zone_ids)) {
          // $zone_ids = array_column(Zone::orderByDistance('coordinates', $point, 'desc')->latest()->get(['id'])/*->take()*/ ->toArray(), 'id');
          //if(!empty($zone_ids))
         //  $zone_ids=array_slice($zone_ids, 0, 1);
           //if(isset($zone_ids[0]))
             //  $zone_ids=$zone_ids[0];
           //  print_r($zone_ids); exit;
             return false;
       }


        return $zone_ids;

    }
}
