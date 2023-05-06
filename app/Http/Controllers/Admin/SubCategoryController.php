<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Category;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.subcategory')  ]);
        return view('Admin.subcategory.index', compact('pageTitle'));
    }


    public function list(Request $request){
        $query = SubCategory::orderBy('subcategory_id', 'DESC')->get();
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->name) ? ($query->name) :'';
        })
        ->editColumn('category_id', function ($query) {
                return isset($query->category_id)  ? $query->getcategory->name : '';
        })

        ->editColumn('action', function ($query) {
            return '
           
            <a class="btn btn-sm btn-primary" title = "'.trans('messages.edit') .'" href="'.route('subcategory.edit', ['id' => $query->subcategory_id]).'">
                <i class="fa fa-edit "></i></a>
            <a class="btn btn-sm btn-danger" 
                href="#"
                data--toggle="delete"
                data-title="All the related books will be deleted once you confirm!"
                data-id="{{ $id }}" 
                data--url="'.route('subcategory.destroy', ['id' => $query->subcategory_id]).'">
              <i class="fa fa-trash"></i>
            </a>';
        })
        ->addIndexColumn()
        ->toJson();
    }

    public function create($id = -1)
    {
        if ($id != -1) {
            $pageTitle = trans('messages.update_form_title',['form' => trans('messages.subcategory')  ]);
            $sub_category = SubCategory::where('subcategory_id', $id)->first();
        }else {
            $pageTitle = trans('messages.add_button_form',['form' => trans('messages.subcategory')  ]);
            $sub_category = new SubCategory;
        }
        $relation = [ 'category_id' => \App\Category::all()->pluck('name', 'category_id')->prepend(trans('messages.select_name',['select' => trans('messages.category')  ]), '')];
        return view('Admin.subcategory.create',compact('sub_category','pageTitle')+$relation);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $validator=\Validator::make($request->all(),[
            'name' => 'required|min:2|regex:/^[a-z0-9 .\-]+$/i',
            'category_id'=>'required',

        ],['category_id.required' => 'Select category ']);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        $reportData = SubCategory::updateOrCreate(['subcategory_id'=>$request->subcategory_id],$data);
        // return redirect()->route('subcategory.index');
        $message = trans('messages.update_form',['form' => trans('messages.subcategory')]);
        if($reportData->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.subcategory')]);
        }
        return redirect(route('subcategory.index'))->withSuccess($message);
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
        // $table_list = ['book'];
        // $column_name = "subcategory_id";
        // $del_status = CheckRecordExist($table_list,$column_name,$id);
        // if($del_status == false){
        //     return redirect()->back()->withErrors(trans('messages.check_delete_msg',['form' => trans('messages.subcategory')]));
        // }
        // else {
            $data= SubCategory::findOrFail($id);
            \App\Book::where('subcategory_id',$id)->delete();
            $data->delete();
            return response()->json(['status'=>true,'message'=> trans('messages.delete_success_msg',['form' => trans('messages.subcategory') ]) ]);
            // return redirect(route('subcategory.index'))->withSuccess(trans('messages.delete_success_msg',['form' => trans('messages.subcategory')]));
        // }
    }
    public function getsubCategoryList(Request $request){
        $data = SubCategory::where('category_id',$request->category_id)->get();
        return response()->json(['status' => true ,'data' => $data , 'message' => trans('messages.list_form_title',['form' => trans('messages.subcategory')  ]) ]);
    }
}
