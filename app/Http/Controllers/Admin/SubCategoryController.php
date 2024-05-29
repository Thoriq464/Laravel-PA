<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
   public function create(){
    $categories = Category::orderBy('name','ASC')->get();
    $data['categories'] = $categories;
    return view('admin.sub_category.create', $data);
   }

   public function store(Request $request){
       $validator = Validator::make($request->all(),[
           'name' => 'required',
           'slug' => 'required|unique::sub_categories',
           'category' => 'required',
           'status' => 'required'
       ]);

       if($validator->passes()) {

       } else {
        return response([
            'status' => false,
            'errors' => $validator->errors()
        ]);
       }
   }
}
