<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Transaction;
use \App\UserAddress;
use Datatables;

class TransactionController extends Controller
{
    public function index()
    {
        $pageTitle="Sales";
        return view('Admin.users.user-transaction-list',compact('pageTitle'));
    }

    public function list($user_id = "", $limit="")
    {
        $transactiondata =  Transaction::orderBy("transaction_id","DESC");
        if($user_id != "" && $user_id != "-1"){
            $transactiondata->where("user_id", $user_id);
        }
        if($limit != ""){
            $transactiondata->take($limit);
        }
        $transactiondata->withTrashed();
        return Datatables::eloquent($transactiondata)
        ->editColumn('created_at', function ($transactiondata) {
            return isset($transactiondata->created_at) ? date('Y-m-d',strtotime($transactiondata->created_at)) : '-';
        })
        ->editColumn('txn_id', function ($transactiondata) {
            return optional($transactiondata)->txn_id;
        })
        ->editColumn('order_by', function ($transactiondata) {
            return ucwords(optional($transactiondata->getUser)->name);
        })
        ->editColumn('total_amount', function ($transactiondata) {
            return money(optional($transactiondata)->total_amount);
        })

        ->editColumn('payment_type', function ($transactiondata) {
            $payment_type = $transactiondata->payment_type;
            if($transactiondata->txn_id != "null" && $transactiondata->txn_id != null) {
                switch($payment_type){
                    case 1 :
                        return 'Paytm';
                        break;
                    case 2 :
                        return 'Paypal';
                        break;
                    default :
                        return "-";
                        break;
                }
            }
        })
        ->filterColumn('order_by', function($transactiondata, $keyword) {
            $transactiondata->orWhereHas('getUser',function($q) use($keyword){
                $q->where('name','like',"%{$keyword}%");
            });
        })
        ->editColumn('payment_status' , function ($transactiondata){
            $payment_status = ucwords(str_replace("_"," " ,$transactiondata->payment_status));
            if($payment_status != null && $transactiondata->payment_type == 1){
                $payment_status = $payment_status;
            }
            if($transactiondata->txn_id == "null" || $transactiondata->txn_id == null) {
                $payment_status = trans('messages.transaction_fail');
            }
            return $payment_status;
        })
        ->addIndexColumn()
        ->rawColumns(['image','transaction', 'book_name','order_by','action','payment_status'])
        ->toJson();
    }

    public function updatePaymentStatus($id,$status,Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $result = Transaction::where('transaction_id',$id)->update(['status' => $status]);

        if($result) {
            $message = trans('messages.update_form',['form' => 'Payment status ']);
        } else {
            $message =  trans('messages.not_updated',['form' => 'Payment']);
        }

        return redirect(route('transactions.index'))->withSuccess($message);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $pageTitle = "Shipping Address";
        $address = UserAddress::where('user_address_id',$id)->first();
        // $address = Transaction:: where('transaction_id',$id)->first()->shipping_address;
        return view('Admin.users.transaction-shipping-address',compact('pageTitle','address'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
