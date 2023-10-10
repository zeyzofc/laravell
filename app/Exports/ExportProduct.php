<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ExportProduct implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
         $products = Product::select(
            'title',
            'slug',
            'description',
            'short_description',
            'shipping_returns',
            'related_products', 
            'price',
            'compare_price',
            'sku',
            'category_id',
            'sub_category_id',
            'brand_id',
            'is_featured',
            'barcode',
            'track_qty',
            'qty',
            'status',
        )->get();

        $products = $products->map(function ($product) {
            return [
                'title' => $product->title,
                'slug' => $product->slug,
                'description' => strip_tags($product->description),
                'short_description' => strip_tags($product->short_description),
                'shipping_returns' => strip_tags($product->shipping_returns),
                'related_products' => $product->related_products,
                'price' => $product->price,
                'compare_price' => $product->compare_price,
                'sku' => $product->sku,
                'category' => optional($product->category)->name,
                'subcategory' => optional($product->subcategory)->name,
                'brand' => optional($product->brand)->name,
                'is_featured' => $product->is_featured,
                'barcode' => $product->barcode,
                'track_qty' => $product->track_qty,
                'qty' => $product->qty,
                'status' => $product->status == 1 ? 'Active' : 'Inactive', // Conditionally set status
            ];
        });

        return $products;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Title',
            'Slug',
            'Description',
            'Short Description',
            'Shipping & Returns',
            'Related Products',
            'Price',
            'Compare Price',
            'SKU',
            'Category',
            'Subcategory',
            'Brand',
            'Is Featured',
            'Barcode',
            'Track Qty',
            'Qty',
            'Status',
        ];
    }
}