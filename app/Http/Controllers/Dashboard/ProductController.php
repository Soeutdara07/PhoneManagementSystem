<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSection;
use App\Models\Section;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return view('back_end.product');
    }

    public function data()
    {
        $categories = Category::orderBy("id", "DESC")->get();
        $brands     = Brand::orderBy("id", "DESC")->get();
        $sections   = Section::orderBy("id", "DESC")->get();
        $images   = ProductImage::orderBy("id", "DESC")->get();

        return response([
            'status' => 200,
            'data' => [
                'categories' => $categories,
                'brands'     => $brands,
                'sections'   => $sections,
                'images' => $images
            ]
        ]);
    }

    public function list(Request $request)
    {
        $limit = 5;
        $page  = $request->page;
        $offset = ($page - 1) * $limit;

        $query = Product::with(['images', 'category:id,category_name', 'brand:id,brand_name']);

        if ($request->search) {
            $search = $request->search;
            // group all search conditions
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%$search%")
                    ->orWhereHas('category', fn($c) => $c->where('category_name', 'like', "%$search%"))
                    ->orWhereHas('brand', fn($b) => $b->where('brand_name', 'like', "%$search%"));
            });
        }

        // total records for pagination
        $totalRecord = $query->count();

        // get products with offset & limit
        $products = $query->orderBy('id', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(fn($product) => [
                'id'       => $product->id,
                'images'   => $product->images->pluck('image_url')->toArray(),
                'product_name'     => $product->product_name,
                'category' => $product->category?->category_name,
                'brand'    => $product->brand?->brand_name,
               
            ]);

        $totalPage = ceil($totalRecord / $limit);

        return response()->json([
            'status' => 200,
            'page'   => [
                'totalRecord' => $totalRecord,
                'totalPage'   => $totalPage,
                'currentPage' => $page
            ],
            'products' => $products
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'sections.*.section_id' => 'nullable|exists:sections,id',
            'sections.*.specs.*.key' => 'nullable|string|max:255',
            'sections.*.specs.*.value' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $product = new Product();

            $product->product_name = $request->product_name;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;

            $product->save();


            // Save product images
            if ($request->image_uploads != null) {
                $images = $request->image_uploads;
                foreach ($images as $img) {
                    $image = new ProductImage();
                    $image->image_url = $img;
                    $image->product_id = $product->id;
                    // FIXED: use $product->id

                    // Move image from temp to product directory
                    if (File::exists(public_path("uploads/temp/$img"))) {
                        // copy
                        File::copy(
                            public_path("uploads/temp/$img"),
                            public_path("uploads/product_image/$img")
                        );

                        // delete from temp directory
                        File::delete(public_path("uploads/temp/$img"));
                    }

                    $image->save();
                }
            }

            // Save sections & specifications
            if ($request->sections) {
                foreach ($request->sections as $sectionData) {
                    if (!empty($sectionData['section_id'])) {
                        // create pivot row
                        $productSection = ProductSection::create([
                            'product_id' => $product->id,
                            'section_id' => $sectionData['section_id'],
                        ]);

                        // create specs
                        if (!empty($sectionData['specs'])) {
                            foreach ($sectionData['specs'] as $spec) {
                                $productSection->specifications()->create([
                                    'key'   => $spec['key'] ?? null,
                                    'value' => $spec['value'] ?? null,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status'  => 200,
                'message' => 'Product created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 500,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }




    public function edit(Request $request)
    {
        $product = Product::with([
            'productSections.specifications',
            'images'
        ])->find($request->id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found.'
            ]);
        }

        $brands = Brand::orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('id', 'DESC')->get();
        $sections = Section::orderBy('id', 'DESC')->get();

        return response()->json([
            'status' => 200,
            'data' => [
                'product' => $product,
                'brands' => $brands,
                'categories' => $categories,
                'sections' => $sections,
            ]
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255'.$request->product_id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'sections' => 'array',
            'sections.*.section_id' => 'required|exists:sections,id',
            'sections.*.specs.*.key' => 'required|string|max:255',
            'sections.*.specs.*.value' => 'required|string|max:255',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_uploads.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            $product->product_name = $request->product_name;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->save();

            // Sections
            $product->productSections()->each(function ($section) {
                $section->specifications()->delete();
                $section->delete();
            });
            if ($request->sections) {
                foreach ($request->sections as $sec) {
                    $section = $product->productSections()->create(['section_id' => $sec['section_id']]);
                    if (isset($sec['specs'])) {
                        foreach ($sec['specs'] as $spec) {
                            $section->specifications()->create($spec);
                        }
                    }
                }
            }

            // Remove old images
            if ($request->filled('remove_image_ids')) {
                $ids = explode(',', $request->remove_image_ids);
                $images = ProductImage::whereIn('id', $ids)->get();
                foreach ($images as $img) {
                    $path = public_path('uploads/product_image/' . $img->product_image);
                    if (file_exists($path)) unlink($path);
                    $img->delete();
                }
            }

            // Move temp uploaded images to product_image
            if ($request->filled('image_uploads')) {
                foreach ($request->image_uploads as $img) {
                    $temp = public_path("uploads/temp/$img");
                    $dest = public_path("uploads/product_image/$img");
                    if (file_exists($temp)) {
                        File::copy($temp, $dest);
                        File::delete($temp);
                    }
                    $product->images()->create(['image_url' => $img]);
                }
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Product updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
