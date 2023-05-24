<?php

namespace App\Http\Controllers\API\Audio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Audio;
use App\Http\Resources\API\Audio\AudioResource;
use App\Http\Resources\API\Audio\AudioDetailResource;
use App\Http\Resources\API\Author\AuthorResource;

class AudioController extends Controller
{
    public function getAudioAuthorWise(Request $request) {
        $audio_data = Audio::where('author_id', $request->author_id);

        $per_page = 12;

        if ($request->has('per_page') && !empty($request->per_page)) {
            if (is_numeric($request->per_page)) {
                $per_page = $request->per_page;
            }
            if ($request->per_page === 'all') {
                $per_page = $audio_data->count();
            }
        }

        $audio_data = $audio_data->paginate($per_page);

        $item = AudioResource::collection($audio_data);

        $response = [
            'pagination' => [
                'total_items' => $item->total(),
                'per_page' => $item->perPage(),
                'currentPage' => $item->currentPage(),
                'totalPages' => $item->lastPage(),
                'from' => $item->firstItem(),
                'to' => $item->lastItem(),
                'next_page' => $item->nextPageUrl(),
                'previous_page' => $item->previousPageUrl(),
            ],
            'data' => $item,
        ];

        return response()->json($response);
    }

    public function getAudioList(Request $request)
    {
        $audio_data = Audio::orderBy('audio_id', 'DESC')
            ->with([
                'getAuthor',
                'categoryName',
                'subCategoryName',
            ]);

        if ($request->has('category_id') && !empty($request->category_id)) {
            $audio_data = $audio_data->where('category_id', $request->category_id);
        }

        if ($request->has('sub_category_id') && !empty($request->sub_category_id)) {
            $audio_data = $audio_data->where('sub_category_id', $request->sub_category_id);
        }

        if($request->has('search_text') && $request->search_text != null){
            $audio_data->orWhere('name', 'LIKE', '%'.$request->search_text.'%');
            $audio_data->orWhere('title', 'LIKE', '%'.$request->search_text.'%');
        }

        if($request->has('author_id') && $request->author_id != null ){
            $audio_data->where('author_id', $request->author_id);
        }

        $per_page = 12;

        if ($request->has('per_page') && !empty($request->per_page)) {
            if (is_numeric($request->per_page)) {
                $per_page = $request->per_page;
            }
            if ($request->per_page === 'all') {
                $per_page = $audio_data->count();
            }
        }

        $audio_data = $audio_data->paginate($per_page);

        $items = AudioResource::collection($audio_data);

        $response = [
            'pagination' => [
                'total_items' => $items->total(),
                'per_page' => $items->perPage(),
                'currentPage' => $items->currentPage(),
                'totalPages' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'next_page' => $items->nextPageUrl(),
                'previous_page' => $items->previousPageUrl(),
            ],
            'data' => $items,
        ];

        return response()->json($response);
    }

    public function getAudioDetail(Request $request)
    {
        $audio_data = Audio::where('audio_id', $request->audio_id)
            ->with([
                'getAuthor',
                'categoryName',
                'subCategoryName',
            ])
            ->get();

        $getBookDetail = AudioDetailResource::collection($audio_data);

        $response = [
            'data' => $getBookDetail,
        ];

        // $view_count = $audio_data[0]->view_count + 1;

        return response()->json($response);
    }
}
