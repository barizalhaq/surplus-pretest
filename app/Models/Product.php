<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'enable'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    /**
     * The images that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'product_image', 'product_id', 'image_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            DB::beginTransaction();

            try {
                $product->categories()->detach();

                if ($product->images()->exists()) {
                    $productImageIds = $product->images()->pluck('id')->toArray();
                    $product->images()->detach();
                    Image::whereIn('id', $productImageIds)->delete();
                }

                DB::commit();
            } catch (\Exception $th) {
                DB::rollBack();
                throw $th;
            }
        });
    }
}
