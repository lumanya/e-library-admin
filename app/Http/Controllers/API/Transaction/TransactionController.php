<?php

namespace App\Http\Controllers\API\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Transaction;
use \App\TransactionDetail;
use App\Http\Resources\API\Transaction\TransactionResource;
use App\Http\Resources\API\User\UserPurchasedBookResource;
use App\Http\Resources\API\Book\BookResource;
use Braintree;

class TransactionController extends Controller
{
    public function saveTransaction(Request $request){

        $user = \Auth::user();
        
        $other_detail = json_decode($request->transaction_detail,true);

        $data['datetime'] = date('Y-m-d H:i:s');
        $data['other_transaction_detail'] = $request->transaction_detail;
        $data['user_id']  = $user->id;
        $data['payment_type'] = $request->type;
        $data['total_amount'] = $request->total_amount;

        $data['txn_id']  = $other_detail['TXNID'];
        $data['payment_status'] = $other_detail['STATUS'];

        $transaction_detail = json_decode($request->order_detail,true);

        $result  = Transaction::Create($data);
        foreach ($transaction_detail as $key => $value) {
            $td['transaction_id']     = $result->transaction_id;
            $td['book_id']   = $value['book_id'];
            $td['user_id']    = $user->id;
            $td['price'] = $value['price'];
            $td['discount'] = $value['discount'];
            TransactionDetail::create($td);

                $cart_data = \App\UserCartMapping::where('book_id',$value['book_id'])->where('user_id',$user->id)->first();
                if($cart_data != null){
                    $cart_data->delete();
                }

                $book_data = \App\Book::where('book_id',$value['book_id'])->first();
        }


        if($other_detail['STATUS'] == "TXN_SUCCESS" || $other_detail['STATUS'] == "approved" ){
                return response()->json(['status' => true ,'message' => trans('messages.save_form',['form' => 'Transaction']) ]);
        }else{
            return response()->json(['status' => false ,'message' => trans('messages.transaction_fail') ]);
        }
    }

    public function getTransactionDetail(Request $request){
        $user = \Auth::user();
    
        $data = TransactionDetail::where('user_id',$user->id)->with(['getBook','getTransaction'])->paginate(10);
        
        $transaction_data    =   TransactionResource::collection($data);

        return response()->json(['status' => true , 'data' => $transaction_data]);
    }

    public function getUserPurchaseBookList(){
        $user = \Auth::user();

        $data   =   TransactionDetail::where('user_id',$user->id)
                    ->whereHas('getTransaction',function ($q){
                        $q->whereIn('payment_status',['TXN_SUCCESS','approved']);
                    })
                    ->get();
        $purchase_data       =    UserPurchasedBookResource::collection($data);
        $message                   =   trans('messages.list_form_title',['form' => 'Purchase Book']);

        return response()->json([ "status" => true , "message" => $message ,'data' => $purchase_data ]);

    }

    public function checkSumGenerator(Request $request){
        $order_data = $request->all();

        $data = paytm_checksum($order_data);
        return response()->json(['status' => true , 'data' => $data]);
    }

    public function generateClientToken(Request $request){

        $gateway = new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);
        $user = \Auth::user()->id;

        $client_token = $gateway->clientToken()->generate([
            'merchantAccountId' => env('BRAINTREE_Merchant_Account_Id')
        ]);
        return response()->json(['status' => true ,'message' => '','data' => $client_token]);
    }

    public function braintreePaymentProcess (Request $request){
        $gateway = new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);
        $user = \Auth::user()->id;
        $result = $gateway->transaction()->sale([
            'amount' => $request->amount,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'merchantAccountId' => env('BRAINTREE_Merchant_Account_Id'),
            'options' => [
              'submitForSettlement' => True
            ]
        ]);

        return response()->json(['status' => true ,'message' => '','data' => $result]);


    }
}
