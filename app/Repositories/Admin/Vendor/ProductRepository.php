<?php

namespace App\Repositories\Admin\Vendor;

use App\Http\Requests\Vendor\ProductRequest;
use App\Models\Food;
use App\Models\Food_slider_image;
use App\Models\Restaurant;
use App\Repositories\Admin\BaseRepository;
use App\Traits\UploadAttachTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Modules\Core\Helper;
class ProductRepository extends BaseRepository
{
    use UploadAttachTrait;

    public function __construct()
    {
        parent::__construct(new Food());

    }
    function setDataPayload(Request $request = null, $type = 'store')
    {
//print_r($request->all());
        // try {
        if($type=='store'){
            $validate= new ProductRequest() ;

            $request = $request->validate($validate->rules(),[],$validate->attributes());
           // echo "fjkdjfks";
          //  print_r($request); exit;
        }else{
            $request_data=$request->all();

            $id=$request_data['id'];
            $validate= new ProductRequest() ;

            $request = $request->validate($validate->rules(),[],$validate->attributes());
            $request['id']=$id;
        }
        $data=$request;

        /*if (isset($data['image'])&&!empty($data['image'])) {
            $data['image'] =  $this->upload($data['image'], 'product');
            //unset($data['image']);
        }*/
        return($data);
    }
    public function store(Request $request = null, $data = null)
    {
        //print_r($request->all());
        if ($request != null)
           // echo "fkdjfks";
            $data = $this->setDataPayload($request, 'store');
//print_r($request->all());
        if($request->has('image')) {
            $images = ($this->upload(array($request->image), 'product',false));
            unset($request->image);
        }
        // $request->image=$images;
        $request= $request->except(['_token','image']);
        $vendor_id= auth('vendor')->user()->id;
        $restaurant=Restaurant::where('vendor_id',$vendor_id)->first();
        $request['restaurant_id']=$restaurant['id'];
        if(isset($images[0]))
            $request['image']=$images[0];

        /*   if ($request != null)
               $data = $this->setDataPayload($request, 'update');
   */
        //$item = $this->model;
         $category=[];
        array_push($category, [
            'id' => $request['category_id'],
            'position' => 3,
        ]);
        $request['category_ids']=json_encode($category);
        /*********************/

        $choice_options = [];
        if (isset($request['choice'])) {
            foreach ($request['choice_no'] as $key => $no) {
                $str = 'choice_options_' . $no;
                if ($request[$str][0] == null) {
                   // $validator->getMessageBag()->add('name', __('attribute_choice_option_value_can_not_be_null'));
                    return response()->json(['errors' =>__('attribute_choice_option_value_can_not_be_null')]);
                }
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request['choice'][$key];
                $item['options'] = explode(',', implode('|', preg_replace('/\s+/', ' ', $request[$str])));
                array_push($choice_options, $item);
            }
        }
        $request['choice_options'] = json_encode($choice_options);
        $variations = [];
        $options = [];
        if (isset($request['choice_no'])) {
            foreach ($request['choice_no'] as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options
        $combinations = Helper::combinations($options);
        if (count($combinations[0]) > 0) {
            foreach ($combinations as $key => $combination) {
                $str = '';
                foreach ($combination as $k => $item) {
                    if ($k > 0) {
                        $str .= '-' . str_replace(' ', '', $item);
                    } else {
                        $str .= str_replace(' ', '', $item);
                    }
                }
                $item = [];
                $item['type'] = $str;
                $item['price'] = abs($request['price_' . str_replace('.', '_', $str)]);
                array_push($variations, $item);
            }
        }
        //combinations end
        $request['variations'] = json_encode($variations);
        $request['attributes'] = json_encode($request['attribute_id']);
        unset($request['attribute_id']);
       // print_r($request); exit;
           unset($request['choice']);
           unset($request['choice_no']);
        // Filter out keys that start with 'choice_options_'
        $request= array_filter($request, function($key) {
            return strpos($key, 'choice_options_') !== 0;
        }, ARRAY_FILTER_USE_KEY);
        $request= array_filter($request, function($key) {
            return strpos($key, 'price_') !== 0;
        }, ARRAY_FILTER_USE_KEY);

        /*************/
       // print_r($request);
        $id= Food::insertGetId($request);
       // $item->fill($request);
      //  $item->save();
       // $id=$item->id;

        $slider_images=session('slider_images');
        $images=[];
        if(!empty($slider_images)&&count($slider_images)>0) {
            foreach ($slider_images as $key => $slider_image) {

                $images[$key]['image_path']=$slider_image;
                $images[$key]['food_id'] = $id;
            }

            Food_slider_image::insert($images);

        }
        //exit;
        return $id;
    }

    public function update($id, Request $request = null, $data = null)
    {

        if ($request != null)
            $data = $this->setDataPayload($request, 'update');

       if($request->has('image')) {

          // if(session('old_image')!=$request->image){

               $images = ($this->upload(array($request->image), 'product',false));
          // }

           unset($request->image);
       }

        // $request->image=$images;
        $request= $request->except(['_token','image','old_image']);

        if(isset($images[0]))
            $request['image']=$images[0];

     /*   if ($request != null)
            $data = $this->setDataPayload($request, 'update');
*/
        $request['category_ids']=array(['id'=>$request['category_id'],'position'=>0]);
		//print_r($request); exit;
		//
		 $choice_options = [];
        if (isset($request['choice'])) {
            foreach ($request['choice_no'] as $key => $no) {
                $str = 'choice_options_' . $no;
                if ($request[$str][0] == null) {
                    $validator->getMessageBag()->add('name', __('attribute_choice_option_value_can_not_be_null'));
                   // return response()->json(['errors' => Helpers::error_processor($validator)]);
					return response()->json(['errors' =>__('attribute_choice_option_value_can_not_be_null')]);
                }
                $item['name'] = 'choice_' . $no;
                $item['title'] = $request['choice'][$key];
                $item['options'] = explode(',', implode('|', preg_replace('/\s+/', ' ', $request[$str])));
                array_push($choice_options, $item);
            }
        }
        $request['choice_options'] = json_encode($choice_options);
        $variations = [];
        $options = [];
        if (isset($request['choice_no'])) {
            foreach ($request['choice_no'] as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        //Generates the combinations of customer choice options
// Generates the combinations of customer choice options
$combinations = Helper::combinations($options);
$variations = []; // Initialize variations array

if (count($combinations[0]) > 0) {
    foreach ($combinations as $key => $combination) {
        $str = '';
        foreach ($combination as $k => $item) {
            // Build the string for the combination
            $str .= ($k > 0 ? '-' : '') . str_replace(' ', '', $item);
        }

        // Check if the price key exists before accessing it
        $priceKey = 'price_' . str_replace('.', '_', $str);
        if (isset($request[$priceKey])) {
            $item = [];
            $item['type'] = $str;
            $item['price'] = abs($request[$priceKey]);
            array_push($variations, $item);
        } else {
            // Handle the case where the price key does not exist
            // Optionally log this or set a default price
            // For example: 
            // $item['price'] = 0; // or some default value
        }
    }
}

// Combinations end
$request['variations'] = json_encode($variations);
		
		//print_r($request); exit;
		//
        $item = $this->model->findOrFail($id);

        $item->fill($request);
        $item->save();
        $slider_images=session('slider_images');
        //print_r($slider_images);
        $images=[];
        if(!empty($slider_images)&&count($slider_images)>0) {
            Food_slider_image::where('food_id',$id)->delete();
            $images=Food_slider_image::where('food_id',$id)->get()->toArray();
            foreach($images as $image){
                if(file_exists($image['image_path'])){
                    unlink($image['image_path']);
                }
            }
            foreach ($slider_images as $key => $slider_image) {

                $images[$key]['image_path']=$slider_image;
                $images[$key]['food_id'] = $id;
            }
            Food_slider_image::insert($images);


        }
        return $item;
    }
    public function change_status($id,$status){
        $this->model->where('id',$id)->update(['status'=>$status]);
    }
    public function fav_status($id,$status){
        $this->model->where('id',$id)->update(['favourite'=>$status]);

    }
    public function delete($id)
    {
        if ($id == 0) {
            $id = request()->recordIds;// TODO: delete multiple by ids
        }
        $this->model->destroy($id);
        $images=Food_slider_image::where('food_id',$id)->get()->toArray();
         foreach($images as $image){
             if(file_exists($image['image_path'])){
                 unlink($image['image_path']);
             }
         }
        Food_slider_image::where('food_id',$id)->delete();
        return true;
    }
    public function destory_image($request){
        if(File::exists($request->image)) {
            unlink($request->image);
        }

        Food_slider_image::where(['food_id'=>$request->id,'image_path'=>$request->image])->delete();
    }



}
