<?php

namespace App\Http\Controllers\Admin;
use App\Exports\BladeExport;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BaseController extends Controller
{

    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {
        return $items = $this->repository->get($request, $with, $withCount, $filter, $paginate, $whereHas);
    }

    public function store(Request $request)
    {
        $item = $this->repository->store($request);
        if ($item) {
            session()->flash('success', __('added successfully'));
        }
        return $item;
    }

    public function show($id, $with = [], $withCount = [])
    {
        return $this->repository->show($id, $with, $withCount);
    }


    public function update(Request $request, $id)
    {
        $item = $this->repository->update($id, $request);
        if ($item) {
            session()->flash('success', __('updated successfully'));
        }
        return $item;
    }

    public function destroy($id)
    {

        $item = $this->repository->delete($id);
     //  if ($item) {
        //    session()->flash('success', __('deleted successfully'));
      //  }
        return  session()->flash('success', __('deleted successfully'));
    }


    public function addColumns(Request $request)
    {
        $symbol = $request->symbol;

        $tables = [
            'categories' => [
                'title_' => 'VARCHAR(200)'
            ],
            'cities' => [
                'name_' => 'VARCHAR(200)'
            ],
            'consaltaion_services' => [
                'name_' => 'VARCHAR(200)'
            ],
            'consulation_types' => [
                'name_' => 'VARCHAR(200)'
            ],
            'countries' => [
                'name_' => 'VARCHAR(200)'
            ],
            'doctor_works' => [
                'description_' => 'TEXT'
            ],
            'governorates' => [
                'name_' => 'VARCHAR(200)'
            ],
            'insurance_companies' => [
                'name_' => 'VARCHAR(200)'
            ],
            'locales' => [
                'name_' => 'VARCHAR(200)'
            ],
            'admin_most_questions' => [
                'title_' => 'TEXT',
                'answer_' => 'TEXT'
            ],
            'app_intro' => [
                'title_' => 'TEXT',
                'description_' => 'TEXT'
            ],
            'payment_methods' => [
                'name_' => 'VARCHAR(200)'
            ],
            'specializations' => [
                'name_' => 'VARCHAR(200)'
            ],
            'speci_custom_question_answer' => [
                'title_' => 'VARCHAR(200)'
            ],
            'speci_custom_questions' => [
                'title_' => 'TEXT'
            ],
            'speci_question_answers' => [
                'title_' => 'VARCHAR(200)'
            ],
            'speci_questions' => [
                'title_' => 'TEXT'
            ],
            'success_works' => [
                'description_' => 'TEXT'
            ],
            'providers' => [
                'name_' => 'VARCHAR(200)',
                'address_' => 'TEXT'
            ],
            'services' => [
                'title_' => 'VARCHAR(200)',
                'description_' => 'TEXT',
                'sub_title_' => 'TEXT',
                'notice_' => 'TEXT',
                'tags_' => 'TEXT',
                'meta_desc_' => 'TEXT'
            ],
            'service_types' => [
                'name_' => 'VARCHAR(200)'
            ],
            'users' => [
                'address_' => 'VARCHAR(200)'
            ],
            'doctor_certificates' => [
                'university_' => 'VARCHAR(200)',
                'collage_' => 'VARCHAR(200)'
            ],
        ];

        $query = 'start transaction;';

        foreach ($tables as $table => $columns) {
            $schema = \DB::getSchemaBuilder()->getColumnListing($table);

            foreach ($columns as $column => $type) {
                $theColumn = $column . $symbol;
                if (!in_array($theColumn, $schema)) {
                    $query .= 'ALTER TABLE ' . $table . ' ADD COLUMN ' . $theColumn . ' ' . $type . ' NULL DEFAULT NULL;';
                }
            }
        }

        $query .= 'commit;';

        return $query;
    }

    public function exportList($data,$filename='',$headers=[]){

        return Excel::download(new BladeExport($data,$headers), $filename.time().'.xlsx');

    }

    public function selectUserAjax(Request $request){


        // $company=$this->company;

        $request=$request->all();

        $users = [];

        $search=$request['q']['term']??"";

        $type=explode('"',$request['type']);
        $type=$type[1]??'all';


        $users= $this->repository->selectUserAjax($search,$type);


        return($users);



    }

}
