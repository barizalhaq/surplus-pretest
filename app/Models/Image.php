<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'file', 'enable'
    ];

    protected $attributes = [
        'enable' => true
    ];

    /**
     * The products that belong to the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Products::class, 'product_image', 'image_id', 'product_id');
    }
}
