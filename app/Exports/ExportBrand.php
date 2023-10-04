<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBrand implements FromCollection, WithHeadings
{
    public function collection()
    {
        $brands = Brand::select(
            'name',
            'slug',
            'status'
        )->get();

        $brands = $brands->map(function ($brand) {
            return [
                'name' => $brand->name,
                'slug' => $brand->slug,
                'status' => $brand->status == 1 ? 'Active' : 'Inactive', // Conditionally set status
            ];
        });

        return $brands;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Slug',
            'Status',
        ];
    }
}