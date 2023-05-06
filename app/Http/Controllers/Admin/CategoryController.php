<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Category;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Book;
use App\SubCategory;

class CategoryController extends Controller
{

    public function index()
    {
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.category')  ]);
        return view('Admin.category.index', compact('pageTitle'));

    }
    public function list(Request $request){
        $query = Category::orderBy('category_id', 'DESC')->get() ;
        return Datatables::of($query)
        ->editColumn('name', function ($query) {
            return isset($query->name) ? ($query->name) :'';
        })

        ->editColumn('action', function ($query) {
            return '

            <a class="btn btn-sm btn-primary"  title ="'.trans('messages.edit') .'"
                href="'.route('category.edit', ['id' => $query->category_id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a class="btn btn-sm btn-danger" 
                href="#"
                data--toggle="delete"
                data-title="All the related subcategories and books will be deleted once you confirm!"
                data-id="{{ $id }}" 
                data--url="'.route('category.destroy', ['id' => $query->category_id]).'">
              <i class="fa fa-trash"></i>
            </a>

            ';
        })
        ->addIndexColumn()
        ->toJson();
    }


    public function create($id=-1)
    {
        if ($id != -1) {
            $pageTitle = trans('messages.update_form_title',['form' => trans('messages.category')  ]);
            $category = Category::where('category_id', $id)->first();
        }else {
            $pageTitle = trans('messages.add_button_form',['form' => trans('messages.category')  ]);
            $category = new Category;
        }
        // $relation = [ 'parent_category_name' => \App\Category::all()->where('parent_id',0)->pluck('categoryname', 'id')->prepend('Please select', ''), ];
        return view('Admin.category.create',compact('category','pageTitle'));
    }

    public function store(Request $request)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $validator=\Validator::make($request->all(),[
            'name' => 'required|regex:/^[a-z0-9 .\-]+$/i|min:2',
        ]);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $data = $request->all();
        $result = Category::updateOrCreate(['category_id'=>$request->category_id],$data);

        $message = trans('messages.update_form',['form' => trans('messages.category')]);
        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.category')]);
        }
        return redirect(route('category.index'))->withSuccess($message);


    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $auth_user=authSession();
        if($auth_user->is('demo_admin') || $auth_user->is('demo_admin')){
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        // $table_list = ['book','sub_category'];
        // $column_name = "category_id";
        // $del_status = CheckRecordExist($table_list,$column_name,$id);
        // if(!$del_status){
        //     return redirect()->back()->withErrors(trans('messages.check_delete_msg',['form' => trans('messages.category') ]));
        // }
        // else {
            $data= Category::findOrFail($id);
            Book::where('category_id',$id)->delete();
            SubCategory::where('category_id',$id)->delete();
            $data->delete();
            return response()->json(['status'=>true,'message'=> trans('messages.delete_success_msg',['form' => trans('messages.category') ]) ]);
            // return redirect(route('category.index'))->withSuccess(trans('messages.delete_success_msg',['form' => trans('messages.category') ]));
        // }
    }

    public function getCategoryList(){
        $data = Category::get();

        if(count($data) > 0 ){
            foreach ($data as $value) {
                $total_book = \App\Book::getCategoryWiseBook($value->category_id);
                $value['total_book'] = count($total_book);
            }
        }
        return response()->json(['status' => true ,'data' => $data , 'message' => trans('messages.list_form_title',['form' => trans('messages.category')]) ]);
    }
}
