<?php

namespace App\Http\Controllers\Admin;

use App\Audio;
use App\Author;
use App\Category;
use Datatables;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
