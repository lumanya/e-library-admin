<?php

namespace App\Http\Controllers\Admin;

use App\Audio;
use App\Author;
use App\Category;
use Yajra\DataTables\DataTables;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AudioController extends Controller
{
    public function index(Request $request)
    {
        $type = (isset($request->type) && in_array($request->type, ['recommended', 'top-sell', 'all'])) ? $request->type : 'all';
        switch ($type) {
            case 'top-sell':
                $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.top_selling_audio')]);
                break;
            case 'recommended':
                $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.recommended_audio')]);
                break;
            case 'all':
            default:
                $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.audio')]);
                break;
        }

        return view('Admin.audio.index', compact('pageTitle', 'type'));
    }

    public function create(Request $request, $id = -1)
    {
        $pageTitle = trans('messages.add_button_form', ['form' => trans('messages.audio')]);
        $audiodata = new Audio;
        $audiodata->format = 'mp3';

        if ($id != -1) {
            $pageTitle = trans('messages.update_form_title', ['form' => trans('messages.audio')]);
            $audiodata = Audio::where('audio_id', $id)->with(['subCategoryName', 'categoryName'])->first();
        }
        $relation = [
            'author_id' => Author::all()->pluck('name', 'author_id')->prepend(trans('messages.select_name', ['select' => trans('messages.author')]), ''),
            'category_id' => Category::all()->pluck('name', 'category_id')->prepend(trans('messages.select_name', ['select' => trans('messages.category')]), ''),
        ];

        return view('Admin.audio.create', compact('pageTitle', 'audiodata') + $relation);
    }

    public function audioActions(Request $request)
    {
        $audio = Audio::where('audio_id', $request->audio_id)->first();
        if (isset($request->flag_top_sell)) {
            $data['flag_top_sell'] = $request->flag_top_sell;
        }
        if (isset($request->flag_recommend)) {
            $data['flag_recommend'] = $request->flag_recommend;
        }
        if (!empty($audio) && $audio->update($data)) {
            if (isset($request->event) && $request->event == "add") {
                return response()->json(['status' => true, 'message' => 'Audio Added']);
            } else {
                return response()->json(['status' => true, 'message' => 'Audio Removed']);
            }
        } else {
            return response()->json(['status' => true, 'message' => 'No Audio Found']);
        }
    }

    public function audioList(Request $request)
    {
        $type = (isset($request->type) && in_array($request->type, ['recommended', 'top-sell', 'all'])) ? $request->type : 'all';
        $alldata = Audio::orderBy('audio_id', 'DESC');

        if ($type == 'top-sell') {
            $alldata->where('flag_top_sell', 1);
        }

        if ($type == 'recommended') {
            $alldata->where('flag_recommend', 1);
        }

        $alldata->with(['getAuthor', 'categoryName'])->select('audio.*');

        return Datatables::eloquent($alldata)
            ->editColumn('name', function ($alldata) {
                return isset($alldata->name) ? ($alldata->name) : '';
            })
            ->editColumn('flag_top_sell', function ($alldata) use ($type) {
                return '
            <label class="custom-toggle">
              <input type="checkbox" class="flag_top_sell_toggle" ' . ($alldata->flag_top_sell ? "checked" : "") . ' value="' . $alldata->audio_id . '">
              <span class="custom-toggle-slider rounded-circle"></span>
            </label>';
            })
            ->editColumn('flag_recommend', function ($alldata) use ($type) {
                return '
            <label class="custom-toggle">
              <input type="checkbox" class="flag_recommend_toggle" ' . ($alldata->flag_recommend ? "checked" : "") . ' value="' . $alldata->audio_id . '">
              <span class="custom-toggle-slider rounded-circle"></span>
            </label>';
            })
            ->editColumn('title', function ($alldata) {
                return isset($alldata->title) ? ($alldata->title) : '';
            })
            ->editColumn('author_name', function ($alldata) {
                return '<a  href="' . route('author.show', ['id' => $alldata->author_id, 'redirect_url' => route('audio.index')]) . ' "  class="tooltip tooltip-effect-3" ><b>' . (optional($alldata->getAuthor)->name) . '</b><span class="tooltip-content"><span class="tooltip-front"><img class="m-inherit mlr-auto mt-6px" src="' . getSingleMedia($alldata->getAuthor, 'image', null) . '" alt="user3"/></span><span class="tooltip-back"><div>' . (optional($alldata->getAuthor)->name) . '</div></span></span></a>';
            })
            ->editColumn('category_name', function ($alldata) {
                return isset($alldata->categoryName) ? $alldata->categoryName->name : '';
            })
            ->editColumn('cover_image', function ($alldata) {
                return '<img src="' . getSingleMedia($alldata, 'cover_image', null) . '" border="0" width="40" class="img-rounded dashboard-image" align="center" />';
            })
            ->editColumn('action', function ($alldata) {
                return '<a href="' . route('audio.view', ['id' => $alldata->audio_id]) . ' " title = "' . trans('messages.view') . '" class="btn btn-sm btn-info text-white"><i class="fa fa-eye"></i><a/>
            <a class="btn btn-sm btn-primary" title = "' . trans('messages.edit') . '"
               href="' . route('audio.update', ['id' => $alldata->audio_id]) . '">
             <i class="fa fa-edit "></i>
           </a>
           <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title = "' . trans('messages.delete') . '"
           href="' . route('audio.delete', ['id' => $alldata->audio_id]) . '">
             <i class="fa fa-trash"></i>
           </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['cover_image', 'action', 'author_name', 'flag_top_sell', 'flag_recommend'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $auth_user = authSession();
        if ($auth_user->is('demo_admin') || $auth_user->is('demo_admin')) {
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $audiodata = $request->all();
        $validator = Validator::make($audiodata, [
            'cover_image' => 'mimes:jpg,png,jpeg|file|max:2048',
        ], [
            'cover_image' => 'Image should be png/PNG, jpg/JPG', 'back_cover' => 'Image should be png/PNG, jpg/JPG'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $file_validator = Validator::make($audiodata, [
            'audio_file_path' => 'mimes:mp3,mp4,wav,ogg,aac|file'
        ], [
            'audio_file_path' => 'File type must be in mp3, mp4, wav, ogg or aac format.'
        ]);
        if ($file_validator->fails()) {
            return Redirect::back()->withInput()->withErrors($file_validator);
        }

        if (!isset($request->audio_id)) {
            $validator = Validator::make($audiodata, [
                'audio_file_path' => 'required',
            ], [
                '' => 'Audio file is required'
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }

        if (isset($request->audio_id) && $request->audio_id != null) {
            $audio = Audio::where('audio_id', $request->audio_id)->first();
        }

        $result = Audio::updateOrCreate(['audio_id' => $request->audio_id], $audiodata);

        if (isset($request->cover_image) && $request->cover_image != null) {
            storeMediaFile($result, $request->cover_image, 'cover_image');
        }
        if (isset($request->audio_file_path) && $request->audio_file_path != null) {
            storeMediaFile($result, $request->audio_file_path, 'audio_file_path');
        }

        $message = trans('messages.update_form', ['form' => trans('messages.audio')]);
        if ($result->wasRecentlyCreated) {
            $message = trans('messages.save_form', ['form' => trans('messages.audio')]);
            if (isset($user_data) && count($user_data) > 0) {

                $user_register_id = $user_data->pluck('registration_id')->toArray();

                $cover_image = getSingleMedia($result, 'cover_image', null);

                $device_data = array(
                    'title'   => trans('messages.new_audio_added'),
                    'message' => trans('messages.form_added', ['form' => $result->name]),
                    'image'   => $cover_image,
                    'audio_id' => $result->audio_id,
                    'notification_type' => 'audio_added'
                );
                sendOneSignalMessage($user_register_id, $device_data);
            }
        }
        return redirect(route('audio.index'))->withSuccess($message);
    }

    public function view($id, Request $request)
    {
        $pageTitle =  trans('messages.form_detail', ['form' => trans('messages.audio')]);
        $viewdata = Audio::where('audio_id', $id)->with(['getAuthor', 'categoryName', 'subCategoryName'])->first();

        $like_count = $view_count = 0;
        if (($viewdata->like_count) > 0 || ($viewdata->view_count) > 0) {
            $like_count = $viewdata->like_count;
            $view_count = $viewdata->view_count;
        }

        $extra = [
            'redirect_url' => optional($request)->redirect_url,
        ];

        return view("Admin.audio.view", compact('viewdata',  'pageTitle', 'like_count', 'view_count', 'extra'));
    }

    public function destroy($id)
    {
        $auth_user = authSession();
        if ($auth_user->is('demo_admin') || $auth_user->is('demo_admin')) {
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }

        $audio_data = Audio::where('audio_id', $id)->first();

        if ($audio_data != '') {
            $audio_data->delete();
            return redirect(route('audio.index'))->withSuccess(trans('messages.delete_success_msg', ['form' => trans('messages.audio')]));
        } else {
            return redirect()->back()->withSuccess(trans('messages.not_found_entry', ['form' => trans('messages.audio')]));
        }
    }

    public function trash($id, $type)
    {
        $file = Audio::find($id);

        if ($type == 'audio_file_path') {
            $file_name = $file->file_path;
            $file_path = public_path('uploads/audio-file-path/' . $file_name);
            if (File::exists($file_path)) {
                File::delete($file_path);
                $file->file_path = null;
            }
        }

        $file->update();

        return  response()->json('File Removed Succesfully', 200);
    }
}
