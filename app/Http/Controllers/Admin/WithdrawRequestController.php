<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\Admin\SingleRebo\OrderRepository;
use App\Repositories\Admin\SingleRebo\WithDrawRequestRepository;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;

class WithdrawRequestController extends BaseController
{

    protected $view;
    protected $repository;

    public function __construct(WithDrawRequestRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'admin-views.withdraw_request';

    }
    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {

       $status=(isset($request->status))?$request->status:'all';

       $withdraws= parent::index($request, ['vendor'=>function ($query) {$query->with('restaurants');}], [], 'approved|' . $status . '|=', 10, []);
//print_R($orders); exit;
       /* if ($request->filled("export_excel") && $request->export_excel == true) {


            foreach ($reviews as $index => $record) {
                $data[$index]['#'] = $index + 1;
                $data[$index]['patient_name'] = optional($record->user)->full_name;
                $data[$index]['doctor_name'] = optional($record->doctor)->full_name;
                $data[$index]['comment'] = $record->comment_text;
                $data[$index]['grade'] = $record->grade;
                $data[$index]['created_at'] = $record->created_at ? Carbon::parse($record->created_at)->format("Y-m-d h:i A"): "";
            }
            $file_name="reviews";
            $headers = ["#", __('patient name'), __('doctor name'), __('comment'), __('grade'), __('date')];
            return  $this->exportList($data,$file_name,$headers);
        }

        */
        return view($this->view . '.index', compact('withdraws'));
    }



    public function change_status(Request $request)
    {
        $status= 1;
        $id= $request['id'];
        $data= $this->repository->change_status($id,$status);

       return  session()->flash('success',__('convert done succesfully'));
    }

}
