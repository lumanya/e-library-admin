<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\UserFavouriteBook;
use App\Category;
use App\StaticData;
use App\TransactionDetail;
use File;
use Datatables;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $type = (isset($request->type) && in_array($request->type, ['recommended', 'top-sell', 'all'])) ? $request->type : 'all';
        switch ($type) {
            case 'top-sell':
                $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.top_selling_book')]);
                break;
            case 'recommended':
                $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.recommended_book')]);
                break;
            case 'all':
            default:
                $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.book')]);
                break;
        }

        return view('Admin.book.index', compact(['pageTitle', 'type']));
    }

    public function create(Request $request, $id = -1)
    {
        $pageTitle = trans('messages.add_button_form', ['form' => trans('messages.book')]);
        $bookdata = new Book;
        $bookdata->format = 'pdf';
        if ($id != -1) {
            $pageTitle = trans('messages.update_form_title', ['form' => trans('messages.book')]);
            $bookdata = Book::where('book_id', $id)->with(['subCategoryName', 'categoryName'])->first();
        }
        $relation = [
            'author_id' => Author::all()->pluck('name', 'author_id')->prepend(trans('messages.select_name', ['select' => trans('messages.author')]), ''),
            'category_id' => Category::all()->pluck('name', 'category_id')->prepend(trans('messages.select_name', ['select' => trans('messages.category')]), ''),
            'language' => StaticData::all()->where('type', 'language')->pluck('value', 'id')->prepend(trans('messages.select_name', ['select' => trans('messages.language')]), ''),
            'book_formate' => StaticData::where('type', 'formate')->get(),
        ];

        return view('Admin.book.create', compact('pageTitle', 'bookdata') + $relation);
    }

    public function bookActions(Request $request)
    {
        $book = Book::where('book_id', $request->book_id)->first();
        if (isset($request->flag_top_sell)) {
            $data['flag_top_sell'] = $request->flag_top_sell;
        }
        if (isset($request->flag_recommend)) {
            $data['flag_recommend'] = $request->flag_recommend;
        }
        if (!empty($book) && $book->update($data)) {
            if (isset($request->event) && $request->event == "add") {
                return response()->json(['status' => true, 'message' => 'Book Added']);
            } else {
                return response()->json(['status' => true, 'message' => 'Book Removed']);
            }
        } else {
            return response()->json(['status' => true, 'message' => 'No Book Found']);
        }
    }

    public function bookList(Request $request)
    {
        $type = (isset($request->type) && in_array($request->type, ['recommended', 'top-sell', 'all'])) ? $request->type : 'all';
        $alldata = Book::orderBy('book_id', 'DESC');

        if ($type == 'top-sell') {
            $alldata->where('flag_top_sell', 1);
        }
        if ($type == 'recommended') {
            $alldata->where('flag_recommend', 1);
        }

        $alldata->with(['getAuthor', 'categoryName'])->select('book.*');


        return Datatables::eloquent($alldata)
            ->editColumn('name', function ($alldata) {
                return isset($alldata->name) ? ($alldata->name) : '';
            })
            ->editColumn('flag_top_sell', function ($alldata) use ($type) {
                return '
            <label class="custom-toggle">
              <input type="checkbox" class="flag_top_sell_toggle" ' . ($alldata->flag_top_sell ? "checked" : "") . ' value="' . $alldata->book_id . '">
              <span class="custom-toggle-slider rounded-circle"></span>
            </label>';
            })
            ->editColumn('flag_recommend', function ($alldata) use ($type) {
                return '
            <label class="custom-toggle">
              <input type="checkbox" class="flag_recommend_toggle" ' . ($alldata->flag_recommend ? "checked" : "") . ' value="' . $alldata->book_id . '">
              <span class="custom-toggle-slider rounded-circle"></span>
            </label>';
            })
            ->editColumn('title', function ($alldata) {
                return isset($alldata->title) ? ($alldata->title) : '';
            })
            ->editColumn('author_name', function ($alldata) {
                // $default=\URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
                // $image = $default;
                // if(isset(optional($alldata->getAuthor)->image) && optional($alldata->getAuthor)->image != null){
                //     $image = fileExitsCheck($default,'uploads/author-image',optional($alldata->getAuthor)->image);
                // }
                // return '<a  href="'.route('author.show',['id'=>$alldata->author_id,'redirect_url'=>route('book.index')]).' "  class="tooltip tooltip-effect-3" ><b>'.(optional($alldata->getAuthor)->name).'</b><span class="tooltip-content"><span class="tooltip-front"><img class="m-inherit mlr-auto mt-6px" src="'.$image.'" alt="user3"/></span><span class="tooltip-back"><div>'.(optional($alldata->getAuthor)->name).'</div></span></span></a>';
                return '<a  href="' . route('author.show', ['id' => $alldata->author_id, 'redirect_url' => route('book.index')]) . ' "  class="tooltip tooltip-effect-3" ><b>' . (optional($alldata->getAuthor)->name) . '</b><span class="tooltip-content"><span class="tooltip-front"><img class="m-inherit mlr-auto mt-6px" src="' . getSingleMedia($alldata->getAuthor, 'image', null) . '" alt="user3"/></span><span class="tooltip-back"><div>' . (optional($alldata->getAuthor)->name) . '</div></span></span></a>';
            })
            ->editColumn('category_name', function ($alldata) {
                return isset($alldata->categoryName) ? $alldata->categoryName->name : '';
            })

            ->editColumn('front_cover', function ($alldata) {
                // $default=\URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
                // $front_cover = $default;
                // if(isset($alldata->front_cover) && $alldata->front_cover != null){
                //     $front_cover = fileExitsCheck($default,'uploads/front-image',$alldata->front_cover);
                // }
                // return '<img src='.$front_cover.' border="0" width="40" class="img-rounded dashboard-image" align="center" />';
                return '<img src="' . getSingleMedia($alldata, 'front_cover', null) . '" border="0" width="40" class="img-rounded dashboard-image" align="center" />';
            })
            ->editColumn('action', function ($alldata) {
                return '<a href="' . route('book.view', ['id' => $alldata->book_id]) . ' " title = "' . trans('messages.view') . '" class="btn btn-sm btn-info text-white"><i class="fa fa-eye"></i><a/>
            <a class="btn btn-sm btn-primary" title = "' . trans('messages.edit') . '"
               href="' . route('book.update', ['id' => $alldata->book_id]) . '">
             <i class="fa fa-edit "></i>
           </a>
           <a onclick="return confirm(\'Are you sure?\')" class="btn btn-sm btn-danger" title = "' . trans('messages.delete') . '"
           href="' . route('book.delete', ['id' => $alldata->book_id]) . '">
             <i class="fa fa-trash"></i>
           </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['front_cover', 'action', 'author_name', 'flag_top_sell', 'flag_recommend'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $auth_user = authSession();
        if ($auth_user->is('demo_admin') || $auth_user->is('demo_admin')) {
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $bookdata = $request->all();
        $validator = Validator::make($bookdata, [
            'front_cover' => 'mimes:jpg,png,jpeg|file|max:2048',
            'back_cover' => 'mimes:jpg,png,jpeg|file|max:2048',
        ], [
            'front_cover' => 'Image should be png/PNG, jpg/JPG', 'back_cover' => 'Image should be png/PNG, jpg/JPG'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if (isset($request->format)) {
            if ($request->format == 'pdf') {
                $validation_string  = 'mimes:pdf|file';
                $validation_message = 'File type must be in pdf format.';
            } elseif ($request->format == 'video') {
                $validation_string  = 'mimes:mp4,mov,ogg,wmv|file';
                $validation_message = 'File type must be in mp4 , mov, ogg, wmv format.';
            } elseif ($request->format == 'epub') {
                $validation_string  = 'mimes:epub|file';
                $validation_message = 'File type must be in epub format.';
            } else {
                $validation_message = 'Enter valid file.';
            }
            $file_validator = validator::make($bookdata, [
                'file_path' => $validation_string,
            ], [$validation_message]);
            if ($file_validator->fails()) {
                return Redirect::back()->withInput()->withErrors($file_validator);
            }
        }

        if (!isset($request->book_id)) {
            $validator = Validator::make($bookdata, [
                'file_path' => 'required',
                'format' => 'required',
            ], [
                'Book file format is required'
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }

        $bookdata['date_of_publication'] = date('Y-m-d', strtotime($request->date_of_publication));

        if ($request->discount != null && $request->discount > 0) {
            $bookdata['discounted_price'] = $bookdata['price'] - ($bookdata['price']  * ($bookdata['discount'] / 100));
        } else {
            $bookdata['discount']  = 0;
            $bookdata['discounted_price'] = 0;
        }

        if (isset($request->book_id) && $request->book_id != null) {
            $book = Book::where('book_id', $request->book_id)->first();
            if ($book->format != $request->format) {
                $bookdata['file_path'] = $bookdata['file_sample_path'] = null;
            }
        }
        $result = Book::updateOrCreate(['book_id' => $request->book_id], $bookdata);
        if (isset($request->front_cover) && $request->front_cover != null) {
            storeMediaFile($result,$request->front_cover, 'front_cover');
        }
        if (isset($request->back_cover) && $request->back_cover != null) {
            storeMediaFile($result,$request->back_cover, 'back_cover');
        }
        if (isset($request->file_path) && $request->file_path != null) {
            storeMediaFile($result,$request->file_path, 'file_path');
        }

        if (isset($request->file_sample_path) && $request->file_sample_path != null) {
            storeMediaFile($result,$request->file_sample_path, 'file_sample_path');
        }

        $message = trans('messages.update_form', ['form' =>  trans('messages.book')]);
        if ($result->wasRecentlyCreated) {
            $message = trans('messages.save_form', ['form' =>  trans('messages.book')]);
            $user_data = \App\User::whereNotNull('registration_id')->where('registration_id', '!=', '')->get();
            if (isset($user_data) && count($user_data) > 0) {

                $user_register_id = $user_data->pluck('registration_id')->toArray();

                $front_cover = getSingleMedia($result, 'front_cover', null);

                $device_data = array(
                    'title'   => trans('messages.new_book_added'),
                    'message' => trans('messages.form_added', ['form' => $result->name]),
                    'image'   => $front_cover,
                    'book_id' => $result->book_id,
                    'notification_type' => 'book_added'
                );
                sendOneSignalMessage($user_register_id, $device_data);
            }
        }
        return redirect(route('book.index'))->withSuccess($message);
    }

    public function view($id, Request $request)
    {
        $pageTitle =  trans('messages.form_detail', ['form' => trans('messages.book')]);
        $viewdata = Book::where('book_id', $id)->with(['getAuthor', 'categoryName', 'subCategoryName', 'getBookRating'])->first();



        $avg_rating = $count_rating = 0;
        if (count($viewdata->getBookRating) > 0) {
            $avg_rating = $viewdata->getBookRating->avg('rating');
            $count_rating = $viewdata->getBookRating->count();
        }
        $book_language  = DB::table('static_data')->where('id', $viewdata->language)->first();
        $extra = [
            'redirect_url' => optional($request)->redirect_url,
        ];
        return view("Admin.book.view", compact('viewdata', 'book_language', 'avg_rating', 'count_rating', 'pageTitle', 'extra'));
    }

    public function destroy($id)
    {
        $auth_user = authSession();
        if ($auth_user->is('demo_admin') || $auth_user->is('demo_admin')) {
            return redirect()->back()->withSuccess(trans('messages.demo_permission_denied'));
        }
        $book_data = Book::where('book_id', $id)->first();
        if ($book_data != '') {
            $tran_data = TransactionDetail::where('book_id', $id)->with('getUser')->first();

            if (!empty($tran_data) && !empty($tran_data->getUser)) {
                return redirect(route('book.index'))->withSuccess(trans('messages.check_delete_msg', ['form' => trans('messages.book')]));
            } else {
                $book_data->delete();
                return redirect(route('book.index'))->withSuccess(trans('messages.delete_success_msg', ['form' => trans('messages.book')]));
            }
        } else {
            return redirect()->back()->withSuccess(trans('messages.not_found_entry', ['form' => trans('messages.book')]));
        }
    }

    public function trash($id, $type)
    {

       
        $file = Book::find($id);

        if ($type == 'file_path') {
            $file_name = $file->file_path;
            $file_path = public_path('uploads/file-path/' . $file_name);
            if (\File::exists($file_path)) {
                \File::delete($file_path);
                $file->file_path = null;
            }
        } else {
            $file_name1 = $file->file_sample_path;
            $file_path2 = public_path('uploads/sample-file/' . $file_name1);

            //dd($file_path2);
            if (\File::exists($file_path2)) {
                \File::delete($file_path2);
                $file->file_sample_path = null;
            }
        }    

     //dd($file_path);
      $file->update();

        return  response()->json('File Removed Succesfully',200);
    }
}
