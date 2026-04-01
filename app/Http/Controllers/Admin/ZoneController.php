<?php

namespace App\Http\Controllers\Admin;

use App\Modules\Core\Helper;
use App\Repositories\Admin\SingleRebo\ZoneRepository;
use Illuminate\Http\Request;
use App\Models\Zone;
use Brian2694\Toastr\Facades\Toastr;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Rap2hpoutre\FastExcel\FastExcel;

class ZoneController extends BaseController
{

    protected $view;
    protected $repository;

    public function __construct(ZoneRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'admin-views.zone.';

    }
    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {
        $zones = Zone::withCount(['restaurants'])->latest()->paginate(10);//config('app.')
        return view('admin-views.zone.index', compact('zones'));
    }
    public function create()
    {
        $zones = Zone::withCount(['restaurants'])->latest()->paginate(10);//config('app.')
        return view($this->view . 'create',compact('zones'));
    }

    public function store(Request $request)
    {
        parent::store($request);
        return redirect(route('admin.zone.index'))->with('success',__('zone_added_successfully'));

    }

    public function edit($id)
    {
       /* if(env('APP_MODE')=='demo' && $id == 1)
        {
            Toastr::warning(trans('messages.you_can_not_edit_this_zone_please_add_a_new_zone_to_edit'));
            return back();
        }*/
        $zone=Zone::selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($id);
        // dd($zone->coordinates);
       // $coords=$zone->coordinates[0];
       //  dd($coords->getLat());
        return view('admin-views.zone.edit', compact('zone'));
    }

    public function update(Request $request, $id)
    {
        parent::update($request, $id);
        return redirect(route('admin.zone.index'));

    }


    public function change_status(Request $request)
    {
        $status= $request['status'];
        if($request['status']=="")$status=0;
        $id= $request['id'];

        if(isset($request['type']))
            $status= !$status;
        $data= $this->repository->change_status($id,$status);

        return back()->with('success','Copoun Status Changed succesfully');
    }
    public function status(Request $request)
    {
       /* if(env('APP_MODE')=='demo' && $request->id == 1)
        {
            Toastr::warning('Sorry!You can not inactive this zone!');
            return back();
        }*/
        $zone = Zone::findOrFail($request->id);
        $zone->status = $request->status;
        $zone->save();
        Toastr::success(trans('messages.zone_status_updated'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $zones=Zone::withCount(['restaurants','deliverymen'])->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view'=>view('admin-views.zone.partials._table',compact('zones'))->render(),
            'total'=>$zones->count()
        ]);
    }

    public function get_coordinates($id){
        $zone=Zone::withoutGlobalScopes()->selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($id);
        // print_r($zone); exit;
        $data = Helper::format_coordiantes($zone->coordinates[0]);
        $center = (object)['lat'=>(float)trim(explode(' ',$zone->center)[1], 'POINT()'), 'lng'=>(float)trim(explode(' ',$zone->center)[0], 'POINT()')];
        return response()->json(['coordinates'=>$data, 'center'=>$center]);
    }

    public function zone_filter($id)
    {
        if($id == 'all')
        {
            if(session()->has('zone_id')){
                session()->forget('zone_id');
            }
        }
        else{
            session()->put('zone_id', $id);
        }

        return back();
    }

    public function get_all_zone_cordinates($id = 0)
    {
        $zones = Zone::where('id', '<>', $id)->active()->get();
        $data = [];
        foreach($zones as $zone)
        {
            $data[] = Helper::format_coordiantes($zone->coordinates[0]);
        }
        return response()->json($data,200);
    }

    public function export_zones(Request $request, $type){


        $zones = Zone::with('restaurants', 'deliverymen')->get();
        if($type == 'excel'){
            return (new FastExcel(Helpers::export_zones($zones)))->download('Zones.xlsx');
        }elseif($type == 'csv'){
            return (new FastExcel(Helpers::export_zones($zones)))->download('Zones.csv');
        }
    }
}
