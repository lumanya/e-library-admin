<?php

namespace App\Http\Controllers\API\Category;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Category\CategoryResource;

class CategoryController extends Controller
{
    public function getCategoryList(Request $request){
        $category = Category::orderBy('category_id','desc');
        $per_page = 12;
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $category->count();
            }
        }
        $category  =  $category->paginate($per_page);
        $item = CategoryResource::collection($category);
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