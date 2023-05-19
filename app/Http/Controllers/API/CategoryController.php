<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function show(Request $request){
        $category =  Category::all();
        return Response([
            'datas' => $category
        ], 200);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required',
                'description' => 'required',
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }else{
            $categoryUploa = [
                'name' => $request->name,
                'description' => $request->description,
            ];
            $newCategory = Category::create($categoryUploa);
            return Response([
                'data' => $newCategory
            ],200);
        }
    }
    public function edit(Request $request, $id){
        $category = Category::find($id);
        if ($category) {
            return Response([
                'data' => $category,
            ], 200);
        } else {
            return Response([
                'error' => 'not found'
            ], 400);
        }
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required',
                'description' => 'required',
            ],
        );
        if ($validator->fails()) {
            return Response([
                'error' => $validator->errors()
            ], 400);
        }else{
            $category = Category::find($id);
            if($category){
                $categoryUploa = [
                    'name' => $request->name,
                    'description' => $request->description,
                ];
                $category->update($categoryUploa);
                return Response([
                    'data' => $category
                ],200);
            }else{
                return Response([
                    'error' => 'Category Not Found'
                ], 400);
            }
        }
    }
    public function destroy(Request $request, $id){
        $category = Category::find($id);
        if($category){
            $category->delete();   
            return Response([
                'message' => 'Delete Successfully'
            ], 200) ;
        }
        else{ 
            return Response([
                'message' => 'category not found'
            ], 200) ;
        }
    }
}
