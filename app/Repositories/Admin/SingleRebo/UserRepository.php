<?php

namespace App\Repositories\Admin\SingleRebo;

use App\Models\Order;
use App\Repositories\Admin\BaseRepository;

class  UserRepository extends BaseRepository
{


    public function __construct()
    {
        parent::__construct(new Order());

    }

  /*  public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }*/


}
