<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        // Find the Category by name
        $category = Category::where('name', $row[9])->first();

        // Find the Subcategory by name
        $subcategory = Subcategory::where('name', $row[10])->first();

        // Find the Brand by name
        $brand = Brand::where('name', $row[11])->first();

        // Check if all required items exist
        if ($category && $subcategory && $brand) {
            return new Product([
                'title' => $row[0],
                'slug' => $row[1],
                'description' => $row[2],
                'short_description' => $row[3],
                'shipping_returns' => $row[4],
                'related_products' => $row[5],
                'price' => $row[6],
                'compare_price' => $row[7],
                'sku' => $row[8],
                'category_id' => $category->id,
                'sub_category_id' => $subcategory->id,
                'brand_id' => $brand->id,
                'is_featured' => $row[12],
                'barcode' => $row[13],
                'track_qty' => $row[14],
                'qty' => $row[15],
                'status' => $row[16] === 'Active' ? 1 : 0,
            ]);
        }

        return null;
    }
}