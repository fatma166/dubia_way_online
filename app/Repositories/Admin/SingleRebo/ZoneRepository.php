<?php

namespace App\Repositories\Admin\SingleRebo;

use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\ZoneRequest;
use App\Models\Banner;
use App\Models\Restaurant;
use App\Models\Zone;
use App\Repositories\Admin\BaseRepository;
use App\Traits\UploadAttachTrait;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;

class ZoneRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Zone());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {


        $validate= new ZoneRequest() ;

        $data= $request->validate($validate->rules(),[],$validate->attributes());

        return($data);
    }
    public function store(Request $request = null, $data = null)
    {
        if ($request != null)
            $dataa= $this->setDataPayload($request, 'store');



        $value = $request->coordinates;
        foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
            if($index == 0)
            {
                $lastcord = explode(',',$single_array);
            }
            $coords = explode(',',$single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $zone_id=Zone::all()->count() + 1;
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $zone = new Zone();
        $zone->name = $request->name;
        $zone->coordinates = new Polygon([new LineString($polygon)]);
        $zone->restaurant_wise_topic =  'zone_'.$zone_id.'_restaurant';
        $zone->customer_wise_topic = 'zone_'.$zone_id.'_customer';
        $zone->save();

        return $zone;
    }

    public function update($id, Request $request = null, $data = null)
    {
        if ($request != null)
            $data = $this->setDataPayload($request, 'store');

        $value = $request->coordinates;
        foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
            if($index == 0)
            {
                $lastcord = explode(',',$single_array);
            }
            $coords = explode(',',$single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $zone=Zone::findOrFail($id);
        $zone->name = $request->name;
        $zone->coordinates = new Polygon([new LineString($polygon)]);
        $zone->restaurant_wise_topic =  'zone_'.$id.'_restaurant';
        $zone->customer_wise_topic = 'zone_'.$id.'_customer';
        $zone->save();
        return $zone;
    }

    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }




}
