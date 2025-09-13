<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductDetail;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchasesController extends Controller
{
    public function index()
    {
        return view('back_end.puchases');
    }

    public function data()
    {
        $product_detail  = ProductDetail::with('product')->orderBy("id", "DESC")->get();
        return response([
            'status' => 200,
            'data' => [
                'product_details' => $product_detail,
            ]
        ]);
    }

    public function list(Request $request)
    {
        $limit  = 10;
        $page   = $request->page ?? 1;
        $offset = ($page - 1) * $limit;

        // Base query with relationships
        $query = Purchases::with([
            'user:id,name',
            'productDetail:id,product_id,supplier_id,cost,sale_price,product_identifier,product_description,color_id',
            'productDetail.product:id,name',
            'productDetail.supplier:id,name',
            'productDetail.color:id,name',
        ]);

        // Search filter
        if (!empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                    ->orWhereHas('productDetail.product', fn($p) => $p->where('name', 'like', "%$search%"))
                    ->orWhereHas('productDetail.supplier', fn($s) => $s->where('name', 'like', "%$search%"))
                    ->orWhere('purchase_note', 'like', "%$search%");
            });
        }

        // Total records
        $totalRecord = $query->count();

        // Paginated data
        $purchases = $query->orderBy('id', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->map(function ($purchase) {
                return [
                    'id'             => $purchase->id,
                    'user'           => $purchase->user?->name,
                    'product'        => $purchase->productDetail?->product?->name,
                    'supplier'       => $purchase->productDetail?->supplier?->name,
                    'color'          => $purchase->productDetail?->color?->name,
                    'purchase_qty'   => $purchase->purchase_qty,
                    'purchase_price' => $purchase->purchase_price,
                    'purchase_date'  => $purchase->purchase_date,
                    'note'           => $purchase->purchase_note,
                    'created_at'     => $purchase->created_at,
                ];
            });

        $totalPage = ceil($totalRecord / $limit);

        return response()->json([
            'status' => 200,
            'page' => [
                'totalRecord' => $totalRecord,
                'totalPage'   => $totalPage,
                'currentPage' => (int) $page,
            ],
            'purchases' => $purchases,
        ]);
    }



    // Store Purchases
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_date'   => 'required|date',
            'product_detail_id' => 'required|exists:product_details,id',
            'purchase_qty'    => 'required|integer|min:1',
            'purchase_price'  => 'required|numeric|min:0',
            'purchase_note'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ]);
        }

        $purchase = new Purchases();
        $purchase->user_id            = Auth::id();
        $purchase->product_detail_id  = $request->product_detail_id;
        $purchase->purchase_date      = $request->purchase_date;
        $purchase->purchase_qty       = $request->purchase_qty;
        $purchase->purchase_price     = $request->purchase_price;
        $purchase->purchase_note      = $request->purchase_note;
        $purchase->save();

        return response()->json([
            'status' => 200,
            'message' => 'Purchase created successfully',
            'data' => $purchase
        ]);
    }
}
