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
}
