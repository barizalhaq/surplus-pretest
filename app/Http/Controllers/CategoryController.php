<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryDetailResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
            'enable' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()
                ],
                422
            );
        }

        $createdCategory = Category::create($request->all());

        return new CategoryDetailResource($createdCategory);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $id,
            'enable' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()
                ],
                422
            );
        }

        $updatedCategory = Category::findOrFail($id);
        $updatedCategory->update(
            [
                'name' => $request->name,
                'enable' => $request->enable
            ]
        );

        return new CategoryDetailResource($updatedCategory);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->exists()) {
            return response()->json(['error' => 'cannot delete the requested category, it\'s dependable by products'], 422);
        }

        $category->delete();
    }
}
