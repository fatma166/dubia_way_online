<?php

namespace App\Repositories\Admin\SingleRebo;
use App\Libarary\CustomerPayLogic;
use App\Models\WalletTransaction;
use App\Repositories\Admin\BaseRepository;
class  UserWalletRepository extends BaseRepository
{


    public function __construct()
    {
        parent::__construct(new WalletTransaction());

    }

  /*  public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }*/
   public function store_wallet($user_id,$amount, $transaction_type, $referance){
      try {
          CustomerPayLogic::create_wallet_transaction($user_id, $amount, $transaction_type, $referance);
          return true;
      }catch (exception $e){
          return false;
      }
   }

}
