<?php

namespace App\Http\Controllers\API\SubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Http\Resources\API\SubCategory\SubCategoryResource;

class SubCategoryController extends Controller
{
    public function getSubCategoryList(Request $request){
        $sub_category = SubCategory::where('category_id',$request->category_id)->get();
        return SubCategoryResource::collection($sub_category);   
    }
}