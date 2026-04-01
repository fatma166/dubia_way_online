<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\AdminRepositoryInterface;
use App\Models\User;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BaseRepository implements AdminRepositoryInterface
{

    protected $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(Request $request = null, $data = null)
    {
        if ($request != null)
            $data = $this->setDataPayload($request, 'store');
        $item = $this->model;
        $item->fill($data);
        $item->save();
        return $item;
    }

    public function update($id, Request $request = null, $data = null)
    {
       // print_r($request->all()); exit;

        if ($request != null)
            $data = $this->setDataPayload($request, 'update');

        $item = $this->model->findOrFail($id);

        $item->fill($data);
        $item->save();
        return $item;
    }

    public function show($id, $with = [], $withCount = [])
    {
        return $this->model->with($with)->findOrFail($id);
    }

    public function get(Request $request, $with = [], $withCount = [], $filter = '', $paginate = '', $whereHas = [])
    {
         DB::enableQueryLog();
        $query = $this->model->with($with)->withCount($withCount);

       // return
          return $this->data($query, $request, $filter, $paginate, $whereHas);
            print_r(DB::getQueryLog());
    }

    public function data($query, $request, $filter = '', $paginate = '', $whereHas = [])
    {
        $single=false;
        if ($filter) {

            if (str_contains($filter, "&&")) {
                $filterArr = explode("&&", $filter);

                foreach ($filterArr as $value) {
                    $value_attr= explode("|",$value);

                    if($value_attr[1]!='all') {
                        $query = $this->where($query, $value);
                    }
                }
            }else{
                $value_attr= explode("|", $filter);

                if($value_attr[1]!='all') {

                    $query = $this->where($query, $filter);
                }

            }

        }

        if (count($request->all())) {
            $table_fields = $this->getFields();

            foreach ($request->all() as $column => $val) {
                if ($column != 'page' && ($val || $val == "0")) {
                    if (in_array($column, $table_fields)) {
                        if (str_contains($column, '_id')) {

                            $query->where($column, $val);
                        }else{
                            $query->where($column, 'LIKE', '%' . $val . '%');
                        }
                    }
                }
            }
        }

        if (count($whereHas)) {
            foreach ($whereHas as $rel => $col) {
                $query->whereHas($rel, function ($q) use ($col, $request) {
                    if (is_array($col)) {
                        foreach ($col as $c => $val){
                            if (str_contains($c, "_id")){
                                $q->where($c, $val);
                            }else{
                                $q->where($c, 'LIKE', '%' . $val . '%');
                            }
                        }
                    } else {
                        if (str_contains($col, "_id")){
                            $q->where($col, $request[$col]);
                        }else{
                            $q->where($col, 'LIKE', '%' . $request[$col] . '%');
                        }
                    }

                });
            }
        }

        $query->orderBy("id", "desc");

        if (!$paginate || $request->export_excel == true || $request->print == true){
            if($single==true)
           return  $query->first();
            return  $query->get();

        //     print_r( DB::getQueryLog()); exit;
        }

        return $query->paginate(config('app.default_pagination'));
    }


    function where($query, $requestFilter)
    {
        $filter = explode("|", $requestFilter);
        if (count($filter) == 3) {

            $query->where($filter[0], $filter[2], $filter[1]);
        } else {
            $type = explode("-", $filter[1]);
            if (count($type) == 2) {
                settype($type[0], $type[1]);
                $query->where($filter[0], $type[0]);
            } else
                $query->where($filter[0], $filter[1]);
        }
        return $query;
    }

    public function delete($id)
    {
        if ($id == 0) {
            $id = request()->recordIds;// TODO: delete multiple by ids
        }
        return $this->model->destroy($id);
    }

    function setDataPayload(Request $request = null, $type = 'store')
    {

        $validate = [
            'name' => 'required',
        ];
        $store = $validate;
        if ($type = 'store') {
            $request->validate($store);
        }
        if ($type = 'update') {
            $request->validate($validate);
        }
        return $request->all();
    }

    protected function getFields()
    {
        $table = $this->model->getTable();
        return Schema::getColumnListing($table);
    }
    public function selectUserAjax($search,$type){

        // $role_id=Role::where('name',$type)->value('id');
        // DB::enableQueryLog();
        $users =User::select('users.name','users.last_name','users.id')->join('roles', function (JoinClause $join) use($type) {
            $join->on( 'roles.id', '=', 'users.role_id');
            if($type!='all')
                $join->where('roles.name',$type);
        })
            // where('role_id',$role_id)
            ->where('users.name','LIKE',"%$search%")
            ->get();
        // $QUERY= DB::getQueryLog();
        //print_R($QUERY);exit;
        return($users);
    }
    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }
}
