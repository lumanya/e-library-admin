<?php

namespace App\Http\Controllers\API\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use \App\UserCartMapping;
use App\Http\Resources\API\Cart\CartResource;




class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['user_id'] = $user->id;

        $cart_data = UserCartMapping::where('book_id',$data['book_id'])->where('user_id',$data['user_id'])->first();

        if($cart_data != null){
            return response()->json([ 'status' => true ,'message' => trans('messages.already_in_cart') ]);
        }

        $result = UserCartMapping::Create($data);

        $message = trans('messages.add_to_cart');

        return response()->json([ 'status' => true ,'message' => $message ]);
    }

    public function removeFromCart(Request $request)
    {
        $user = Auth::user();
        $result = UserCartMapping::where('cart_mapping_id',$request->id)->first();
        $status = false;
        $message = trans('messages.no_data_found');

        if($result != null){
            $result->delete();
            $status = true;
            $message = trans('messages.remove_from_cart');
        }

        return response()->json([ 'status' => $status ,'message' => $message ]);
    }

    public function getUserCart(){
        $user = \Auth::user();
        $data = UserCartMapping::where('user_id',$user->id)->get();

        return CartResource::collection($data);

        // return response()->json([ 'status' => true ,'data' => $data ,'message' => trans('messages.list_form_title',['form' => 'Cart']) ]);

    }
}
