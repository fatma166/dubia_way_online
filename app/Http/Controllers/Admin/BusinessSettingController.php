<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRole;
use App\Models\Compilation;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Zone;
use App\Repositories\Admin\SingleRebo\AdminEmployeeRepository;
use App\Repositories\Admin\SingleRebo\AdminRoleEmployeeRepository;
use App\Repositories\Admin\SingleRebo\BannerRepository;
use App\Repositories\Admin\SingleRebo\BusinessSettingRepository;
use App\Traits\UploadAttachTrait;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class BusinessSettingController extends BaseController
{
    protected $view;
    protected $repository;

    public function __construct(BusinessSettingRepository $repository)
    {
        parent::__construct($repository);
        $this->view = 'admin-views.business_setting.';

    }
    public function index(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 10, $whereHas = [])
    {
       $setting= parent::index($request, [], [], '', 10, []);

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
        return view($this->view . 'index', compact('setting'));
    }

    public function create()
    {
        return view($this->view .'create');
    }

    public function store(Request $request)
    {

        $result=parent::store($request);
         if($result==false)
             return redirect(route('admin.business_setting.index'))->with(__('already exist'));
       return redirect(route('admin.business_setting.index'));
    }

    public function edit($id)
    {
        $countries=Country::where('active',1)->get();
        $currencies=Currency::/*where('active',1)->*/get();

        $record= parent::show($id);
        return view($this->view . 'edit', compact('record','countries','currencies'));
    }

    public function update(Request $request, $id)
    {

        parent::update($request, $id);
      return redirect(route('admin.business_setting.index'));
      //  return redirect()->back()->with('success', __('updated successfully'));
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

}
