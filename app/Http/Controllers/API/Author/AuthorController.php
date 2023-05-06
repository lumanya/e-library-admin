<?php

namespace App\Http\Controllers\API\Author;

use Illuminate\Http\Request;
use App\Author;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Author\AuthorResource;

class AuthorController extends Controller
{
    public function getAuthorList(Request $request){
        // return AuthorResource::collection(Author::orderBy('author_id','desc')->paginate(10)); 
        $author = Author::orderBy('author_id','desc');
        $per_page = 12;
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $author->count();
            }
        }
        $author  =  $author->paginate($per_page);
        $item = AuthorResource::collection($author);
        $response = [
            'pagination' => [
                                    'total_items' => $item->total(),
                                    'per_page' => $item->perPage(),
                                    'currentPage' => $item->currentPage(),
                                    'totalPages' => $item->lastPage(),
                                    'from' => $item->firstItem(),
                                    'to' => $item->lastItem(),
                                    'next_page'=>$item->nextPageUrl(),
                                    'previous_page'=>$item->previousPageUrl(),
                                ],
            'data' => $item,
        ];
        return response()->json($response);      
    }

}