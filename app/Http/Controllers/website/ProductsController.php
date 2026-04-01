<?php
namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SingleFoodResource;
use App\Models\Food;
use App\Modules\Core\Helper;
use App\Repositories\Api\CategoryRepository;
use App\Repositories\Api\FoodRepository;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Response;
class ProductsController extends Controller
{
        public function list_(Request $request, $filter_data = "all")
        {
			//print_r($request->all()); exit;
        $limit = $request->limit ?? 0;
        $offset = $request->offset ?? 0;

        // Initialize filter_data as an array
        $filter_data = [];

        if ($request->filled('type')) {
        $type = $request->type;
        // Handle 'type' logic here if needed
        }

        // Build filter data based on request parameters
        if ($request->has('high_orders') && $request->high_orders == 1) {
        $filter_data['order_count'] = 'desc';
        }
        if ($request->has('high_rate') && $request->high_rate == 1) {
        $filter_data['high_rate'] = 'desc';
        }
        if ($request->has('arrange_order')) {
        $filter_data['arrange_order'] = 'desc';
        }
        if ($request->has('favourite')) {
        // Uncomment and define favourite logic if needed
        // $filter_data['favourite'] = 1;
        // Additional logic for favourite can go here
        }
        if($request->has('category_id')&&($request['category_id']!=""))
                $filter_data['category_id']=$request['category_id'];
        if ($request->has('slider')&&isset($request['current_product'])){
           // exit;
            $filter_data['notid']=$request['current_product'];
            $filter_data['category_id']=$request['category_id'];

            }
        if ($request->has('search')){

            $filter_data['name']=$request['search'];

        }
        if($request->has('offer_text')){
              // Set a flash message
    session()->flash('message_offer_text', 'Choose 3 Perfume & Pay only 2 Perfume');
        }
	    if ($request->has('arrange')&&$request['arrange']=="price_low_to_high") {
      		  $filter_data['price_asc'] = 'asc';
        }
		if ($request->has('arrange')&&$request['arrange']=="popularity") {
      		  $filter_data['favourite_desc'] = 'desc';
        }
		if ($request->has('arrange')&&$request['arrange']=="price_high_to_low") {
			//exit;
      		  $filter_data['price_desc'] = 'desc';
        }
		if ($request->has('arrange')&&$request['arrange']=="new") {
      		  $filter_data['created_at_desc'] = 'desc';
        }
			
        // Create an instance of FoodRepository
        $productRepository = new FoodRepository();

        // Fetch products using the defined filters
        $products = $productRepository->list_food($filter_data, $limit, $offset, true);
		//	print_r($products); exit;
            $cat=new CategoryRepository();
            $data['categories'] = $cat->list_cats($request);
        // Return the appropriate view based on the request
           // print_r($products); exit;
        if (($request->has('favourite')&& $request->ajax())||($request->has('high_rate')&& $request->ajax())) {
        //return view('website-views.partails._table', compact('products'));
			 return view('website-views.home_partails.bestseller', compact('products'));
        }elseif ($request->has('slider')){
            return view('website-views.products.details.slider',compact('products'));
        }
			
 if ($request->ajax()) {
        return response()->json([
            'products' => view('website-views.products.partails._table', compact('products'))->render(),
            'pagination' => $products->appends($request->query())->links('layouts.website.pagination.custom')->render(),
        ]);
    }

        return view('website-views.products.index', compact('products','data'));
        }
	
	
	/**
	
	**/
/*public function xmlFeed()
{
    // Fetch products from the database
    $products = Food::active()->where('restaurant_id', config('app.default_vendor'))->get();

    // Create the XML response
    $xml = new \SimpleXMLElement('<?xml version="1.0"?><products></products>');

    foreach ($products as $product) {
        $item = $xml->addChild('product');
        $item->addChild('id', htmlspecialchars($product->id));
        $item->addChild('name', htmlspecialchars($product->name));
        $item->addChild('description', htmlspecialchars($product->description));
        $item->addChild('price', number_format($product->price, 2) . ' EGP'); // Format price
        $item->addChild('link', htmlspecialchars(route('products.details', $product->id)));
        
        // Calculate discounted price (assuming a discount percentage)
        $price_after = $product->price; // Initialize with the original price
                                                                           if ($product->discount_type == "percent") {
                                                                               $price_after -= ($product->price * $product->discount/ 100);
                                                                           } else {
                                                                               $price_after -= $product->discount;
                                                                           }

        $item->addChild('discount_price', number_format($price_after, 2) . ' EGP');
        // Add image link if you have an image URL
        $item->addChild('image_link', htmlspecialchars($product->image_url)); // Ensure 'image_url' exists
    }

    // Set the content type to XML
    return response($xml->asXML(), Response::HTTP_OK)
        ->header('Content-Type', 'text/xml');
}*/



/*public function xmlFeed()
{
    $products = Food::active()->where('restaurant_id', config('app.default_vendor'))->get();

    $xmlString = '<?xml version="1.0" encoding="UTF-8"?>';
    $xmlString .= '<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0">';
    $xmlString .= '<channel>';
    $xmlString .= '<title><![CDATA[ DubaiWay | Products ]]></title>';
    $xmlString .= '<link><![CDATA[' . url('/') . ']]></link>';
    $xmlString .= '<description><![CDATA[ Product feed for Facebook/Google ]]></description>';

    foreach ($products as $product) {
        $price = number_format($product->price, 2, '.', '');
        $priceAfter = $product->price;
        if ($product->discount_type == 'percent') {
            $priceAfter -= ($product->price * $product->discount / 100);
        } else {
            $priceAfter -= $product->discount;
        }
        $priceAfter = number_format(max($priceAfter, 0), 2, '.', '');

        $stock = $product->in_stock == 1 ? 'in stock' : 'out of stock';

        $xmlString .= '<item>';
        $xmlString .= '<g:id><![CDATA[' . $product->id . ']]></g:id>';
       // $xmlString .= '<g:title><![CDATA[' . $product->name . ']]></g:title>';
        $xmlString .= '<g:title><![CDATA[' . str_replace(']]>', ']]]]><![CDATA[>', $product->name) . ']]></g:title>';


        $xmlString .= '<g:description><![CDATA[' . strip_tags($product->description) . ']]></g:description>';
        $xmlString .= '<g:link><![CDATA[' . route('products.details', $product->id) . ']]></g:link>';
        $xmlString .= '<g:image_link><![CDATA[' . $product->image_url . ']]></g:image_link>';
        $xmlString .= '<g:availability><![CDATA[' . $stock . ']]></g:availability>';
        $xmlString .= '<g:condition><![CDATA[new]]></g:condition>';
        $xmlString .= '<g:price><![CDATA[' . $price . ' EGP]]></g:price>';
        $xmlString .= '<g:sale_price><![CDATA[' . $priceAfter . ' EGP]]></g:sale_price>';
        $xmlString .= '<g:brand><![CDATA[ DubaiWay ]]></g:brand>';
        $xmlString .= '<g:identifier_exists><![CDATA[ no ]]></g:identifier_exists>';
        $xmlString .= '<g:google_product_category><![CDATA[ Health & Beauty > Personal Care > Cosmetics > Perfume & Cologne ]]></g:google_product_category>';
        $xmlString .= '</item>';
    }

    $xmlString .= '</channel></rss>';

    return response($xmlString, 200)->header('Content-Type', 'application/xml');
}*/



/**
 * this past worked code
 */
/*public function xmlFeed()
{
    $products = Food::active()
        ->where('restaurant_id', config('app.default_vendor'))
        ->get();

    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $rss = $dom->createElement('rss');
    $rss->setAttribute('version', '2.0');
    $rss->setAttributeNS(
        'http://www.w3.org/2000/xmlns/',
        'xmlns:g',
        'http://base.google.com/ns/1.0'
    );
    $dom->appendChild($rss);

    $channel = $dom->createElement('channel');
    $rss->appendChild($channel);

    $channel->appendChild($dom->createElement('title', 'DubaiWay | Products'));
    $channel->appendChild($dom->createElement('link', url('/')));
    $channel->appendChild($dom->createElement('description', 'Product feed for Facebook/Google'));

    foreach ($products as $product) {
        $item = $dom->createElement('item');

        $add = function ($tag, $value) use ($dom, $item) {
            $item->appendChild($dom->createElementNS('http://base.google.com/ns/1.0', 'g:' . $tag))
                 ->appendChild($dom->createCDATASection($value));
        };

        $price = number_format($product->price, 2, '.', '');
        $discount = $product->discount_type === 'percent'
            ? $product->price * $product->discount / 100
            : $product->discount;
        $sale_price = number_format(max($product->price - $discount, 0), 2, '.', '');

        $stock = $product->in_stock == 1 ? 'in stock' : 'out of stock';

        $add('id', $product->id);
        $add('title', $product->name);
        $add('description', strip_tags($product->description));
        $add('link', route('products.details', $product->id));
        $add('image_link', $product->image_url);
        $add('availability', $stock);
        $add('condition', 'new');
        $add('price', $price . ' EGP');
        $add('sale_price', $sale_price . ' EGP');
        $add('brand', 'DubaiWay');
        $add('identifier_exists', 'no');
        $add('google_product_category', 'Health & Beauty > Personal Care > Cosmetics > Perfume & Cologne');

        $channel->appendChild($item);
    }

    return response($dom->saveXML(), 200)->header('Content-Type', 'application/xml');
}*/

/**
 * this new code 
 */
public function xmlFeed()
{
    $products = Food::active()
        ->where('restaurant_id', config('app.default_vendor'))
        ->with('category')
        ->get();

    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $rss = $dom->createElement('rss');
    $rss->setAttribute('version', '2.0');
    $rss->setAttributeNS(
        'http://www.w3.org/2000/xmlns/',
        'xmlns:g',
        'http://base.google.com/ns/1.0'
    );
    $dom->appendChild($rss);

    $channel = $dom->createElement('channel');
    $rss->appendChild($channel);

    $channel->appendChild($dom->createElement('title', 'DubaiWay | Products'));
    $channel->appendChild($dom->createElement('link', url('/')));
    $channel->appendChild($dom->createElement('description', 'Product feed for Facebook/Google'));

    foreach ($products as $product) {
        $item = $dom->createElement('item');

        $add = function ($tag, $value) use ($dom, $item) {
            $item->appendChild($dom->createElementNS('http://base.google.com/ns/1.0', 'g:' . $tag))
                ->appendChild($dom->createCDATASection($value));
        };

        $price = number_format($product->price, 2, '.', '');
        $discount = $product->discount_type === 'percent'
            ? $product->price * $product->discount / 100
            : $product->discount;
        $sale_price = number_format(max($product->price - $discount, 0), 2, '.', '');

        $stock = $product->in_stock == 1 ? 'in stock' : 'out of stock';

        $categoryName = $product->category->name ?? 'General';
        $customLabel0 = 'DubaiWay';
        $customLabel1 = $product->is_featured ? 'Featured' : 'Regular';

        // ???? ?? ???? ????? 112 ?????? ?????? ?????
        $customLabel2 = $product->category_id == 112 ? 'Favorite' : '';

        $add('id', $product->id);
        $add('title', $product->name);
        $add('description', strip_tags($product->description));
        $add('link', route('products.details', $product->id));
        $add('image_link', $product->image_url);
        $add('availability', $stock);
        $add('condition', 'new');
        $add('price', $price . ' EGP');
        $add('sale_price', $sale_price . ' EGP');
        $add('brand', 'DubaiWay');
        $add('identifier_exists', 'no');

        // ?????? Facebook Catalog
        $add('google_product_category', 'Health & Beauty > Personal Care > Cosmetics > Perfume & Cologne');
        $add('product_type', $categoryName);
        $add('custom_label_0', $customLabel0);
        $add('custom_label_1', $customLabel1);

        // ? ??? custom_label_2 ??? ??? ?????
        if (!empty($customLabel2)) {
            $add('custom_label_2', $customLabel2);
        }

        $channel->appendChild($item);
    }

    return response($dom->saveXML(), 200)->header('Content-Type', 'application/xml');
}






/*
    // Set the content type to XML
    return response($this->buildXml($products), 200)
            ->header('Content-Type', 'application/xml');
}





private function buildXml($products)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0"?><items></items>');

        foreach ($products as $product) {
            $item = $xml->addChild('item');

            //$item->addChild('g:gtin', htmlspecialchars($this->getGtin($product->ID)));
            $item->addChild('g:id', htmlspecialchars($product->ID));
            $item->addChild('g:title', htmlspecialchars($product->name));
            $item->addChild('g:description', htmlspecialchars($product->description));
            $item->addChild('g:image_link', htmlspecialchars($product->image_url));
           // $item->addChild('g:availability', '<![CDATA[in stock]]>');
            $item->addChild('g:price', '<![CDATA['.$product->price.'EGP]]>'); // Adjust price as needed
            $item->addChild('g:link', htmlspecialchars(route('products.details', $product->id)));
            $price_after = $product->price; // Initialize with the original price
               if ($product->discount_type == "percent") {
                   $price_after -= ($product->price * $product->discount/ 100);
               } else {
                   $price_after -= $product->discount;
               }
               $item->addChild('g:discount_price', '<![CDATA['.$price_after.'EGP]]>');

        }

        return $xml->asXML();
    }
	


*/
	
	/**
	
**/

        public function details(Request $request,$product_id){
            $cat=new CategoryRepository();
            $data['categories'] = $cat->list_cats($request);
            // TODO: Implement single_food() method.
           // $product= Food::active()->with('slider')->with('favfood')->find($product_id);
// Assuming you have a method to check if the product is a favorite
$product = Food::active()
    ->with('slider')
    ->with(['favfood' => function($query) {
        if(isset(Auth::user()->id))
        $query->where('user_id',Auth::user()->id); // Filter by logged-in user
    }])
    ->find($product_id);

// Check if the product is a favorite
$isFavorite = $product->favfood->isNotEmpty(); // True if the user has favorited the product


           // $product1= new SingleFoodResource($product);
         //  dd($product->category);exit;
            return view('website-views.products.details.index', compact('product','data','isFavorite'));
        }
        
        
        
        
        public function add_fav(Request $request){

        $food=new FoodRepository();
        $return1= $food->add_fav($request);
        return $return1;
       /* if($return1==false){
            return response()->json([
          /      'status' => HTTPResponseCodes::Sucess['status'],
                'errors'=>__('delete from_fav'),
                'message' =>__('delete from_fav'),
                'code'=>HTTPResponseCodes::Sucess['code']
            ],HTTPResponseCodes::Sucess['code']);
        }
        return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>__('add to_fav'),
            'errors' => [],
            'data' => [],
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);*/
    }
    
    
    
    public function get_user_fav(Request $request){

        $product=new FoodRepository();
        $products = $product->get_user_fav($request);
        return $products;
       /* return response()->json([
            'status' => HTTPResponseCodes::Sucess['status'],
            'message'=>HTTPResponseCodes::Sucess['message'],
            'errors' => [],
            'data' => $products,
            'code'=>HTTPResponseCodes::Sucess['code']
        ],HTTPResponseCodes::Sucess['code']);*/
    }

}