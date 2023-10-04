<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCategory implements FromCollection, WithHeadings
{
    public function collection()
    {
        $categories = Category::select(
            'name',
            'slug',
            'status',
            'showHome'
        )->get();

        $categories = $categories->map(function ($category) {
            return [
                'name' => $category->name,
                'slug' => $category->slug,
                'status' => $category->status == 1 ? 'Active' : 'Inactive', // Conditionally set status
                'show_home' => $category->showHome, // Conditionally set showHome
            ];
        });

        return $categories;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Slug',
            'Status',
            'Show Home',
        ];
    }
}