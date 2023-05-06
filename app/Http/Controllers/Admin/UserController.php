<?php

namespace App\Http\Controllers\Admin;

use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Feedback;
use \App\Transaction;
use \App\UserAddress;
use \App\User;
use \App\BookRating;
use Datatables;
use Validator;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.user') ]);
        return view('Admin.users.index',compact('pageTitle'));
    }

    function list(){
        $user =  User::where('user_type','user');
        return Datatables::eloquent($user)
        ->editColumn('action', function ($query) {
            return '

            <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title ="'.trans('messages.delete') .'"
            href="'.route('user.delete', ['id' => $query->id]).'">
              <i class="fa fa-trash"></i>
            </a>

            </a>';
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $user= User::find($id);
        if($user == ''){
            return redirect()->back()->withErrors(trans('messages.check_delete_msg',['form' => trans('messages.user') ]));
        }
        Transaction::where('user_id',$user->id)->delete();
        TransactionDetail::where('user_id',$user->id)->delete();
        $user->delete();
        return redirect(route('users.index'))->withSuccess(trans('messages.delete_success_msg',['form' => trans('messages.user') ]));
    }

    function userFeedback(){
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.users_feedback')  ]);
        return view('Admin.users.users-feedback',compact('pageTitle'));
    }

    function userFeedbackDataList(){
        $user_feedback_data =  Feedback::orderBy("id",'Desc');

        return Datatables::eloquent($user_feedback_data)
        ->editColumn('name', function ($user_feedback_data) {
            return optional($user_feedback_data)->name;
        })
        ->editColumn('email', function ($user_feedback_data) {
            return optional($user_feedback_data)->email;
        })
        ->editColumn('comment', function ($user_feedback_data) {
            return '<a class="tooltip"><b>'.optional($user_feedback_data)->comment.'</b><span class="tooltip-content"><span class="tooltip-text"><span class="tooltip-inner">'.optional($user_feedback_data)->comment.'</span></span></span></a>';
        })

        ->addIndexColumn()
        ->rawColumns(['image','transaction','comment'])
        ->toJson();
    }

    public function passwordUpadte(Request $request)
    {
        $role = 'user.settings';
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        if($auth_user!='' && $auth_user->is('admin')){
            $role = 'admin.settings';
        }

        $user = User::find($auth_user->id);
        $page = 'password_form';

        $validator = Validator::make($request->all(), [
            'old' => 'required|max:255',
            'password' => 'required|min:6|confirmed|max:255',
        ],['old.*'=>'The old password field is required.',
            'password.required'=>'The new password field is required.',
            'password.confirmed'=>"The password confirmation does not match."]);

        if ($validator->fails()) {
            return redirect()->route($role, ['page'=>$page])->withErrors($validator->getMessageBag()->toArray());
        }

        $hashedPassword = $user->password;
        $match=Hash::check($request->old, $hashedPassword);
        $same_exits=Hash::check($request->password, $hashedPassword);

        if($match) {

            if($same_exits){
                return redirect()->route($role, ['page'=>$page])->withErrors(trans('messages.old_password_same'));
            }

            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
            \Auth::logout();

            return redirect()->route($role, ['page'=>$page])->withSuccess('Your password has been changed.');

        }else{
            return redirect()->route($role, ['page'=>$page])->withSuccess('Please check your old password.');
        }
    }

    public function updateUpdate(Request $request){

        $id=$request->id;
        $page = 'profile_form';
        $auth_user=authSession();
        $role = 'user.settings';
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        if($auth_user!='' && $auth_user->is('admin')){
            $role = 'admin.settings';
            $validator=Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return redirect()->route($role, ['page'=>$page])->withErrors($validator->getMessageBag()->toArray());
            }
        }

        $validator=Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s-]+$/u|max:255',
            'contact_number' => 'required|digits_between:10,12|unique:users,contact_number,'.$id,
            'profile_image' => 'mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:255',
        ],['profile_image'=>'Image should be png/PNG, jpg/JPG',
        ]);

        if ($validator->fails()) {
            return redirect()->route($role, ['page'=>$page])->withErrors($validator->getMessageBag()->toArray());
        }

        $data=$request->all();

        $result=User::updateOrCreate(['id' => $id], $data);

        if($request->profile_image!=''){
            storeMediaFile($result,$request->profile_image, 'profile_image');
        }
        authSession(true);

        return redirect()->route($role, ['page'=>$page])->withSuccess(trans('messages.profile').' '.trans('messages.msg_updated'));
    }
}
