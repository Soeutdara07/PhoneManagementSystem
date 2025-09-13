<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
   
    public function index()
    {
        
        return view('back_end.supplier');

    }

     public function list(Request $request){

        //pagination form
        $limit = 5;
        $page  = $request->page;  //2

        $offset = ($page - 1) * $limit;

        if(!empty($request->search)){
            $suppliers = Supplier::where('supplier_name','like','%'.$request->search.'%')
                            ->orderBy("id","DESC")
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            $totalRecord = Supplier::where('supplier_name','like','%'.$request->search.'%')->count();
        }else{
            $suppliers = Supplier::orderBy("id","DESC")
                            ->limit($limit)
                            ->offset($offset)
                            ->get();
            $totalRecord = Supplier::count();
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
            'suppliers' => $suppliers
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'supplier_name' => 'required|unique:suppliers,supplier_name'
        ]);

        if($validator->passes()){

            //store to db
            $supplier = new Supplier();
            $supplier->supplier_name = $request->supplier_name;
            $supplier->type = $request->type;
            $supplier->address = $request->address;
            $supplier->contact_info = $request->contact_info;
            $supplier->save();

            return response()->json([
                'status' => 200,
                'message' => "Supplier Created successful"
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
        $supplier = Supplier::find($request->id);

        //checking category not found
        if($supplier == null){

            return response([
               'status' => 404,
               'message' => "Supplier not found with id "+$request->id
            ]);

        }else{
            return response([
               'status' => 200,
               'supplier' => $supplier
            ]);
        }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $supplier = Supplier::find($request->supplier_id);

        //checking category not found
        if($supplier == null){

            return response([
               'status' => 404,
               'message' => "Supplier not found with id "+$request->supplier_id
            ]);

        }

        $validator = Validator::make($request->all(),[
            'supplier_name' => 'required|unique:suppliers,supplier_name,'.$request->supplier_id,
        ]);

        if($validator->passes()){
            //update supplier
            $supplier->supplier_name = $request->supplier_name;
            $supplier->type = $request->type;
            $supplier->address = $request->address;
            $supplier->contact_info = $request->contact_info;
            $supplier->save();
            return response([
               'status' => 200,
               'message' => "Supplier updated successful"
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
        $supplier = Supplier::find($request->id);

        //checking category not found
        if($supplier == null){

            return response([
               'status' => 404,
               'message' => "Category not found with id "+$request->id
            ]);

        }

    
        //delete category from db
        $supplier->delete();

        return response([
           'status' => 200,
           'message' => "Category deleted successful",
        ]);

       
    }
}
