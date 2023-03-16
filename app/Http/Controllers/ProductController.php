<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetailResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products,name',
            'description' => 'required|string',
            'enable' => 'required|boolean',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'required|regex:/^[0-9]*$/u',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $images = $request->file('images');

        DB::beginTransaction();

        try {
            $imageIDs = [];
            foreach ($images as $image) {
                $imageName = time() . "_" . $image->getClientOriginalName();
                $path = Storage::putFileAs('product_images', $image, $imageName);
                $createdImage = Image::create([
                    'name' => $imageName,
                    'file' => Storage::url($path),
                ]);

                array_push($imageIDs, $createdImage->id);
            }

            $createdProduct = Product::create($request->except(['category_ids', 'images']));
            $createdProduct->categories()->attach($request->category_ids);
            $createdProduct->images()->attach($imageIDs);

            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }

        $product = Product::with('categories', 'images')->findOrFail($createdProduct->id);

        return new ProductDetailResource($product);
    }
}
