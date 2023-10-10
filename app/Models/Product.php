<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'title',
    'slug',
    'description',
    'short_description',
    'shipping_returns',
    'related_products',
    'price',
    'compare_price',
    'category_id',
    'sub_category_id',
    'brand_id',
    'is_featured',
    'sku',
    'barcode',
    'track_qty',
    'qty',
    'status',
];
    use HasFactory;

    public function product_images(){
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}