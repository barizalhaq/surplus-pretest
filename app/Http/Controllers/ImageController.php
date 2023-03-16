<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $image = Image::findOrFail($id);

        if (Storage::delete('product_images/' . $image->name)) {
            $newImage = $request->file('image');
            $newImageName = time() . "_" . $newImage->getClientOriginalName();

            if ($path = Storage::putFileAs('product_images', $newImage, $newImageName)) {
                $image->update(
                    [
                        'name' => $newImageName,
                        'file' => Storage::url($path)
                    ]
                );
            }

            return new ProductImageResource($image);
        }

        return response()->json(['error' => 'cannot proceed update image, please try again'], 422);
    }

    public function delete($id)
    {
        $image = Image::findOrFail($id);
        if (Storage::delete('product_images/' . $image->name)) {
            if ($image->products()->exists()) {
                $image->products()->detach();
            }
            $image->delete();
        }
    }
}
