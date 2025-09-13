<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
   
    public function index()
    {
        
        return view('back_end.category');

    }

    // public function list(){
    //     $categories = Category::orderBy("id","DESC")->get();

    //     return response()->json([
    //         'status' => 200,
    //         'categories' => $categories
    //     ]);
    // } 
    public function list(Request $request){

        //pagination form
        $limit = 5;
        $page  = $request->page;  //2

        $offset = ($page - 1) * $limit;

        if(!empty($request->search)){
            $categories = Category::where('Category_name','like','%'.$request->search.'%')
                            ->orderBy("id","DESC")
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            $totalRecord = Category::where('Category_name','like','%'.$request->search.'%')->count();
        }else{
            $categories = Category::orderBy("id","DESC")
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            $totalRecord = Category::count();
        }
 
        
       
        //totalRecord 
        $totalPage   = ceil($totalRecord /  $limit);  // 2.1 => 3

        return response([
            'status' => 200,
            'page' => [
                'totalRecord' => $totalRecord,
                'totalPage'  => $totalPage,
                'currentPage' => $page,
            ],
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'category_name' => 'required|unique:categories,category_name'
        ]);

        if($validator->passes()){

            //store to db
            $category = new Category();
            $category->category_name = $request->category_name;
            $category->status = $request->status;
            $category->save();

            return response([
                'status' => 200,
                'message' => "Category Created successful"
            ]);

        }else{

            return response()->json([
                'status' => 500,
                'error' => $validator->errors(),
            ]);
        }
        
        
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $category = Category::find($request->id);

        //checking category not found
        if($category == null){

            return response([
               'status' => 404,
               'message' => "Category not found with id "+$request->id
            ]);

        }else{
            return response([
               'status' => 200,
               'category' => $category
            ]);
        }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $category = Category::find($request->category_id);

        //checking category not found
        if($category == null){

            return response([
               'status' => 404,
               'message' => "Category not found with id "+$request->category_id
            ]);

        }

        $validator = Validator::make($request->all(),[
            'category_name' => 'required|unique:categories,category_name,'.$request->category_id,
        ]);

        if($validator->passes()){
            //update category
            $category->category_name = $request->category_name;
            $category->status = $request->status;
            $category->save();

            return response([
               'status' => 200,
               'message' => "Category updated successful"
            ]);
        }else{
            return response()->json([
               'status' => 500,
                'error' => $validator->errors(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category = Category::find($request->id);

        //checking category not found
        if($category == null){

            return response([
               'status' => 404,
               'message' => "Category not found with id "+$request->id
            ]);

        }

    
        //delete category from db
        $category->delete();

        return response([
           'status' => 200,
           'message' => "Category deleted successful",
        ]);

       
    }
}
