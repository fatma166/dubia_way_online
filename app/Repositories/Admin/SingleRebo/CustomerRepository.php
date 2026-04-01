<?php

namespace App\Repositories\Admin\SingleRebo;

use App\Models\User;
use App\Repositories\Admin\BaseRepository;
class  CustomerRepository extends BaseRepository
{


    public function __construct()
    {
        parent::__construct(new User());

    }
    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['active'=>$status]);
    }

    /*  public function change_status($id,$status){
          $this->model->where('id',$id)->update(['status'=>$status]);
      }*/


}
