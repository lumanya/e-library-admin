<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Mobile_slider;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
class MobileSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.mobileslider_image')  ]);
        return view('Admin.mobile_slider.index',compact('pageTitle'));
    }

    public function list(Request $request){
        $query = Mobile_slider::orderBy('mobile_slider_id', 'DESC')->get() ;
        return Datatables::of($query)
        ->addColumn('slide_image', function ($query)  {
            // $default=\URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
            // $image = $default;
            // if(isset($query->slide_image)){
            //     $image=fileExitsCheck($default,'uploads/mobile_slider',$query->slide_image);
            // }
            // return "<img src='".$image."'border='0' width='80' class='img-rounded'>";
            return "<img src='".getSingleMedia($query,'slide_image',null)."' border='0' width='80' class='img-rounded'>";
        })
        ->editColumn('action', function ($query) {
            return '
           
            <a class="btn btn-sm btn-primary" title = "'.trans('messages.edit') .'"
                href="'.route('mobileslider.edit', ['id' => $query->mobile_slider_id]).'">
              <i class="fa fa-edit "></i>
            </a>
            <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title = "'.trans('messages.delete') .'"
            href="'.route('mobileslider.destroy', ['id' => $query->mobile_slider_id]).'">
              <i class="fa fa-trash"></i>
            </a>
          
            </a>';
        })
        ->rawColumns(['action','sr_no','slide_image'])
        ->addIndexColumn()
        ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = -1)
    {
        if($id != -1){
            $pageTitle = trans('messages.update_form_title',['form' => trans('messages.mobileslider_image')  ]);
            $slider_data= Mobile_slider::where('mobile_slider_id',$id)->first();

        }else{
            $pageTitle = trans('messages.add_button_form',['form' => trans('messages.mobileslider_image')  ]);
            $slider_data= new Mobile_slider;
        }
        return view('Admin.mobile_slider.create',compact('slider_data','pageTitle'));
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
        $data = $request->all();
        if($data['mobile_slider_id'] == null){
            $validator = \Validator::make($data, [
                'slide_image'=> 'required|mimetypes:image/jpeg,image/png,image/jpg,image/gif',
                ],['Image should be png/PNG, jpg/JPG']
            );
        }else{
            $validator = \Validator::make($data, [
                'slide_image'=> 'mimetypes:image/jpeg,image/png,image/jpg,image/gif',
                ],['Image should be png/PNG, jpg/JPG']
            );
        }
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if($request->slide_image != null ){
            storeMediaFile($result,$request->slide_image, 'slide_image');
        }

        $result = Mobile_slider::updateOrCreate(['mobile_slider_id'=>$request->mobile_slider_id],$data);
        if($request->slide_image != null ){
            $result->clearMediaCollection('slide_image');
        }
        $message = trans('messages.update_form',['form' => trans('messages.mobileslider_image')]);
        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.mobileslider_image')]);
        }
        return redirect(route('mobileslider.index'))->withSuccess($message);
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
        $slider_image = Mobile_slider::where('mobile_slider_id' , $id)->first();

        if (empty($slider_image)) {
            $message = trans('messages.not_found_entry',['form' => trans('messages.mobileslider_image') ]);
        }else{
            $slider_image->clearMediaCollection('slide_image');
            $slider_image->delete();
            $message = trans('messages.delete_form',['form' => trans('messages.mobileslider_image') ]);
        }
        return redirect(route('mobileslider.index'))->withSuccess($message);
    }
}
