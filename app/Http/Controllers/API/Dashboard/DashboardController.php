<?php

namespace App\Http\Controllers\API\Dashboard;

use Illuminate\Http\Request;
use App\Book;
use App\BookRating;
use App\UserWishlistBook;
use App\Mobile_slider;
use App\Author;
use App\Category;
use App\Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Book\BookResource;
use App\Http\Resources\API\Book\UserWishlistBookResource;
use App\Http\Resources\API\Book\TopSearchBookResource;
use App\Http\Resources\API\Book\TopSellBookResource;
use App\Http\Resources\API\Book\MobileSliderResource;
use App\Http\Resources\API\Author\AuthorResource;
use App\Http\Resources\API\Category\CategoryResource;

use Config;
use Braintree;

class DashboardController extends Controller
{

    public function getDashboardDetail(Request $request){
        $slider                           =  MobileSliderResource::collection(Mobile_slider::get());
        // $p_book                           = Book::orderBy('rating','desc')->paginate(12);
        $p_book                           = Book::orderBy('rating','desc');
        $per_page = 12;
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $p_book->count();
            }
        }
        $p_book  =  $p_book->paginate($per_page);
        $popular_book              = BookResource::collection($p_book);
        $t_search_book             = Book::orderBy('book_id','desc');

        if($request->has('category_id') && $request->category_id != null ){
            $t_search_book->where('category_id',$request->category_id);
        }
        // $top_search_book        = BookResource::collection($t_search_book->paginate(12));
        if($request->per_page === 'all' ){
            $per_page = $t_search_book->count();
        }
        $t_search_book  =  $t_search_book->paginate($per_page);
        $top_search_book        = BookResource::collection($t_search_book);
        
        // $top_sell_book              = BookResource::collection(Book::orderBy('book_id','desc')->where('flag_top_sell',1)->paginate(12));
        $top_sell_book = Book::orderBy('book_id','desc')->where('flag_top_sell',1);
        if($request->per_page === 'all' ){
            $per_page = $top_sell_book->count();
        }
        $top_sell_book  =  $top_sell_book->paginate($per_page);
        $top_sell_book              = BookResource::collection($top_sell_book);

        // $recommended_book           = BookResource::collection(Book::orderBy('book_id','desc')->where('flag_recommend',1)->paginate(12));
        $recommended_book = Book::orderBy('book_id','desc')->where('flag_recommend',1);
        if($request->per_page === 'all' ){
            $per_page = $recommended_book->count();
        }
        $recommended_book  =  $recommended_book->paginate($per_page);
        $recommended_book           = BookResource::collection($recommended_book);
        
        $top_author                   = AuthorResource::collection(Author::take(10)->orderBy('author_id','desc')->get());
        // $category_book            = Category::get();
        // $category_book            = CategoryResource::collection(Category::orderBy('category_id','desc')->paginate(10));
        $category_book = Category::orderBy('category_id','desc');
        if($request->per_page === 'all' ){
            $per_page = $category_book->count();
        }
        $category_book  =  $category_book->paginate($per_page);
        $category_book            = CategoryResource::collection($category_book);
        
        switch ($request->type) {

            case 'popular_book':
                    $items = $popular_book;
            break;
            case 'category_book':
                    $items = $category_book;
            break;        
            case 'top_search_book':
                    $items = $top_search_book;
            break;
            case 'top_sell_book':
                    $items = $top_sell_book;
            break;
            case 'recommended_book':
                    $items = $recommended_book;
            break;

            default:
                $setting              = Config::get('mobile-config');
                foreach($setting as $k=>$s){
                    foreach ($s as $sk => $ss){
                        if( !in_array($k ,['PAYTM','BRAINTREE'])){
                            $getSetting[]=$k.'_'.$sk;
                        }
                    }
                }
                
                $setting_value  =Setting::whereIn('key',$getSetting)->get();
                
                $paytm = Config::get('mobile-config.PAYTM');
                $paytmSetting=[];
                foreach ($paytm as $sk => $ss){
                    $paytmSetting[]= 'PAYTM_'.$sk;
                }
                
                $paytm_value = Setting::whereIn('key',$paytmSetting)->get();
                $paytm_config = false;
                if(count($paytm_value) > 0) {   
                    $paytm_config =  true;
                    foreach ($paytm_value as $key => $value) {
                        if (isset($value->value) && !empty($value->value)) {
                            continue;
                        }
                        $paytm_config = false;
                    break;
                    }
                }
                if( getenv('BRAINTREE_ENV') &&  getenv('BRAINTREE_MERCHANT_ID')  && getenv('BRAINTREE_PUBLIC_KEY') && getenv('BRAINTREE_PRIVATE_KEY') && getenv('BRAINTREE_Merchant_Account_Id') ){
                                       
                    $gateway = new Braintree\Gateway([
                        'environment' => env('BRAINTREE_ENV'),
                        'merchantId' => env('BRAINTREE_MERCHANT_ID'),
                        'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
                        'privateKey' => env('BRAINTREE_PRIVATE_KEY')
                    ]);

                    try {
                        $merchantAccount = $gateway->merchantAccount()->find(env('BRAINTREE_Merchant_Account_Id'));
                        $paypal_configuration = true;
                    }  catch (Braintree\Exception\Authentication $e) {
                        $paypal_configuration = false;
                    } catch (Braintree\Exception\NotFound $e) {
                        $paypal_configuration = false;    
                    }
                }else{
                    $paypal_configuration = false;
                }
                $response = [
                    "status"              => true,
                    "slider"                => $slider,
                    "popular_book" => $popular_book,
                    "top_search_book" => $top_search_book,
                    "top_sell_book" => $top_sell_book,
                    "recommended_book" => $recommended_book,
                    "top_author" => $top_author,
                    "category_book" => $category_book,
                    "configuration"=>$setting_value,
                    "is_paypal_configuration" => $paypal_configuration,
                    "is_paytm_configuration" => $paytm_config,
                    "message"=> trans('messages.dashboard_detail'),
                    'term_conditions'=>getSettingKeyValue('terms&condition'),
                    'privacy_policy'=>getSettingKeyValue('privacy_policy'),

                ];



                return response()->json($response);

            break;
        }

        $response = [
            'pagination' => [
                        'total_items' => $items->total(),
                        'per_page' => $items->perPage(),
                        'currentPage' => $items->currentPage(),
                        'totalPages' => $items->lastPage(),
                        'from' => $items->firstItem(),
                        'to' => $items->lastItem(),
                        'next_page'=>$items->nextPageUrl(),
                        'previous_page'=>$items->previousPageUrl()
            ],
            'data' => $items,
        ];
        return response()->json($response);
    }
}
