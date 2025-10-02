<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductDetailContoller extends Controller
{
    //
    public function index()
    {
        return view('back_end.product_detail');
    }

    public function data()
    {
        $product  = Product::orderBy("id", "DESC")->get();
        $supplier  = Supplier::orderBy("id", "DESC")->get();
        $color  = ProductColor::orderBy("id", "DESC")->get();

        return response([
            'status' => 200,
            'data' => [
                'products' => $product,
                'suppliers' => $supplier,
                'colors' => $color,
            ]
        ]);
    }

    public function list(Request $request)
{
    $limit = 10;
    $page = $request->page ?? 1;

    $query = ProductDetail::with([
        'product:id,product_name',
        'product.images:id,product_id,image_url',
        'supplier:id,supplier_name',
        'color:id,name',
    ]);

    if (!empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('product', fn($p) => $p->where('product_name', 'like', "%$search%"))
              ->orWhereHas('supplier', fn($s) => $s->where('supplier_name', 'like', "%$search%"))
              ->orWhereHas('color', fn($c) => $c->where('name', 'like', "%$search%"))
              ->orWhere('product_identifier', 'like', "%$search%")
              ->orWhere('condition', 'like', "%$search%");
        });
    }

    $paginated = $query->orderBy('id', 'DESC')->paginate($limit, ['*'], 'page', $page);

    $productDetails = $paginated->getCollection()->map(fn($detail) => [
        'id'                 => $detail->id,
        'product'            => $detail->product?->product_name,
        'supplier'           => $detail->supplier?->supplier_name,
        'color'              => $detail->color?->name,
        'cost'               => $detail->cost,
        'sale_price'         => $detail->sale_price,
        'product_identifier' => $detail->product_identifier,
        'sold_status'        => $detail->sold_status,
        'condition'          => $detail->condition,
        'description'        => $detail->product_description,
        'images'             => $detail->product?->images->pluck('image_url')->toArray(),
        'created_at'         => $detail->created_at,
    ]);

    return response()->json([
        'status' => 200,
        'page' => [
            'totalRecord' => $paginated->total(),
            'totalPage'   => $paginated->lastPage(),
            'currentPage' => $paginated->currentPage(),
        ],
        'product_details' => $productDetails,
    ]);
}



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'         => 'required|exists:products,id',
            'supplier_id'        => 'required|exists:suppliers,id',
            'cost'               => 'required|numeric|min:0',
            'sale_price'         => 'required|numeric|min:0',
            'product_identifier' => 'required|string|max:255|unique:product_details,product_identifier',
            'condition'          => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'color_id'           => 'required|exists:product_colors,id',
        ]);

        if ($validator->passes()) {
            // Save ProductDetail
            $detail = new ProductDetail();
            $detail->product_id         = $request->product_id;
            $detail->supplier_id        = $request->supplier_id;
            $detail->cost               = $request->cost;
            $detail->sale_price         = $request->sale_price;
            $detail->product_identifier = $request->product_identifier;
            $detail->sold_status        = $request->sold_status;
            $detail->condition          = $request->condition;
            $detail->product_description = $request->product_description;
            $detail->color_id           = $request->color_id;
            $detail->save();


            //Save to images table in db
            return response()->json([
                'status'  => 200,
                'message' => "Product detail created successfully",
                'data'    => $detail
            ]);
        } else {
            return response()->json([
                'status'  => 422,
                'message' => 'Validation Failed',
                'errors'  => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request)
    {
        $detail = ProductDetail::with(['product', 'supplier', 'color'])->find($request->id);

        if (!$detail) {
            return response()->json([
                'status'  => 404,
                'message' => 'Product detail not found'
            ]);
        }


        $product  = Product::orderBy("id", "DESC")->get();
        $supplier  = Supplier::orderBy("id", "DESC")->get();
        $color  = ProductColor::orderBy("id", "DESC")->get();

        return response([
            'status' => 200,
            'data' => [
                'detail'=> $detail,
                'products' => $product,
                'suppliers' => $supplier,
                'colors' => $color,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $detail = ProductDetail::findOrFail($request->id);

        if (!$detail) {
            return response()->json([
                'status'  => 404,
                'message' => 'Product detail not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'product_id'         => 'required|exists:products,id',
            'supplier_id'        => 'required|exists:suppliers,id',
            'cost'               => 'required|numeric|min:0',
            'sale_price'         => 'required|numeric|min:0',
            'product_identifier' => 'required|string|max:255|unique:product_details,product_identifier,' . $detail->id,
            'condition'          => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'color_id'           => 'required|exists:product_colors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validation Failed',
                'errors'  => $validator->errors()
            ]);
        }

        // Update product detail
        $detail->product_id         = $request->product_id;
        $detail->supplier_id        = $request->supplier_id;
        $detail->cost               = $request->cost;
        $detail->sale_price         = $request->sale_price;
        $detail->product_identifier = $request->product_identifier;
        $detail->sold_status        = $request->sold_status;
        $detail->condition          = $request->condition;
        $detail->product_description = $request->product_description;
        $detail->color_id           = $request->color_id;
        $detail->save();

        return response()->json([
            'status'  => 200,
            'message' => "Product detail updated successfully",
            'data'    => $detail
        ]);
    }
}
