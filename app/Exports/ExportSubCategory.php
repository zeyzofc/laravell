<?php

namespace App\Exports;

use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSubCategory implements FromCollection, WithHeadings
{
    public function collection()
    {
        $subCategories = SubCategory::select(
            'name',
            'slug',
            'status',
            'showHome',
            'category_id'
        )->get();

        $subCategories = $subCategories->map(function ($subCategory) {
            return [
                'name' => $subCategory->name,
                'slug' => $subCategory->slug,
                'status' => $subCategory->status == 1 ? 'Active' : 'Inactive', // Conditionally set status
                'show_home' => $subCategory->showHome, // Conditionally set showHome
                'category' => optional($subCategory->category)->name,
            ];
        });

        return $subCategories;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Slug',
            'Status',
            'Show Home',
            'Category',
        ];
    }
}