<?php

namespace App\Repositories\Api;


use App\Http\Resources\Api\ReviewResource;
use App\Interfaces\Api\ReviewInterface;
use App\Models\Restaurant;
use App\Models\RestaurantReview;
use App\Models\Review;
use App\Modules\Core\Helper;
use Illuminate\Support\Facades\Auth;

class ReviewRepository implements ReviewInterface
{

  public function review($product_id)
  {
      // TODO: Implement Review() method.
      $reviews = Review::with(['customer--', 'food'])
         // ->whereHas('food', function($query)use($restaurant_id){
            //  return $query
                  ->where('food_id', $product_id)
        //  })
          ->active()->latest()->get();

      $storage = [];
      foreach ($reviews as $item) {
          $item['attachment'] = json_decode($item['attachment']);
          $item['food_name'] = null;
          $item['food_image'] = null;
          $item['customer_name'] = null;
          if($item->food)
          {
              $item['food_name'] = $item->food->name;
              $item['food_image'] = $item->food->image;

          }
          if($item->customer)
          {
              $item['customer_name'] = $item->customer->f_name.' '.$item->customer->l_name;
          }

          unset($item['food']);
          unset($item['customer--']);
          array_push($storage, $item);
      }

      return response()->json($storage, 200);

  }
public function add_restaurant_review($request)
  {
      // TODO: Implement add_restaurant_review() method.
       $restaurant_id=$request->restaurant_id;

      
       $user_rating=$request->rating;
          $check_exist=RestaurantReview::where(['restaurant_id'=>$restaurant_id,'user_id'=>Auth::guard('api')->user()->id])->first();
          if(!empty($check_exist)){
              $json_data=Restaurant::where('id',$request->restaurant_id)->value('rating');
            
                 if($check_exist['rating']==5){
                     
                    $ss= $json_data[0]-1;
                    unset($json_data[0]);
                       $json_data[0]=$ss;
                 }elseif($check_exist['rating']==4){
                     $ss=$json_data[1]-1; 
                        unset($json_data[1]);
                       $json_data[1]=$ss;
                         
                 }elseif($check_exist['rating']==3){
                    
                      $ss=$json_data[2]-1;
                      unset($json_data[2]);
                       $json_data[2]=$ss;
                     
                 }elseif($check_exist['rating']==2){
                      $ss= $json_data[3]-1;
                         unset($json_data[3]);
                       $json_data[3]=$ss;
                 }elseif($check_exist['rating']==1){
                         $ss=$json_data[4]-1;
                         unset($json_data[4]);
                       $json_data[4]=$ss;
                 }
            // print_r( $json_data); exit;
            $restaurant_ratings[1] = $json_data[4];
            $restaurant_ratings[2] = $json_data[3];
            $restaurant_ratings[3] = $json_data[2];
            $restaurant_ratings[4] = $json_data[1];
            $restaurant_ratings[5] = $json_data[0];
          
              Restaurant::where('id',$request->restaurant_id)->update(['rating'=>$restaurant_ratings]);
                
              $update_user_rate=RestaurantReview::where(['restaurant_id'=>$restaurant_id,'user_id'=>Auth::guard('api')->user()->id])->update(['rating'=>$user_rating,'comment'=>$request->comment]);
          }
           $restaurant_old_rating=Restaurant::where('id',$request->restaurant_id)->value('rating');

      $update_rate=Helper::update_restaurant_rating($restaurant_old_rating,$user_rating);
        Restaurant::where('id',$request->restaurant_id)->update(['rating'=>$update_rate]);
      if(empty($check_exist)) {
          $insert = RestaurantReview::insert(['restaurant_id' => $restaurant_id, 'rating' => $user_rating, 'comment' => $request->comment, 'user_id' => Auth::guard('api')->user()->id]);
      }
     /* $update_rate_toarray =(json_decode(json_encode(json_decode($update_rate)), true));

       $cal_data=Helper::calculate_restaurant_rating($update_rate_toarray);

       print_r($cal_data); exit;*/
  }

  public function get_restaurant_review($request)
 {
        // TODO: Implement get_restaurant_review() method.
        $limit=$request->limit?$request->limit:6;
        $offset=$request->offset?$request->offset:0;
        $restaurant_old_rating=Restaurant::where('id',$request->restaurant_id)->value('rating');
        //  print_r($restaurant_old_rating);
        $total_submit =  $restaurant_old_rating[0]+ $restaurant_old_rating[1]+ $restaurant_old_rating[2]+$restaurant_old_rating[3]+$restaurant_old_rating[4];
        //  echo $total_submit; exit;
        if($total_submit==0) $total_submit=1;
        /*  echo  $restaurant_old_rating[0]*5;
          echo  $restaurant_old_rating[1]*4;
          echo  $restaurant_old_rating[2]*3;
          echo  $restaurant_old_rating[3]*2;
          echo  $restaurant_old_rating[4]*1;*/
        $rate[5]= (($restaurant_old_rating[0])/ $total_submit)*100;
        $rate[4]= (($restaurant_old_rating[1])/ $total_submit)*100;
        $rate[3]= (($restaurant_old_rating[2])/ $total_submit)*100;
        $rate[2]= (($restaurant_old_rating[3])/ $total_submit)*100;
        $rate[1]= (($restaurant_old_rating[4])/ $total_submit)*100;


        $cal_data=Helper::calculate_restaurant_rating( $restaurant_old_rating);
        $cal_data['each_rate']=$rate;
        $data=RestaurantReview::with('customer')->where('restaurant_id',$request->restaurant_id)->orderBy('id','asc') ->paginate($limit, ['*'], 'page', $offset);
        $cal_data['user_reviews']=ReviewResource::collection($data);
        $cal_data['currentPage']=$data->currentPage();
        $cal_data['lastPage']=$data->lastPage();

        return($cal_data);
    }


}
