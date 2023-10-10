<?php

namespace App\Imports;

use App\Models\Brand;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class BrandImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Brand([
        'name' => $row[0], // Match the Excel column name 'Name' exactly (case-sensitive)
        'slug' => $row[1], // Match the Excel column name 'Slug' exactly (case-sensitive)
        'status' => $row[2] === 'Active' ? 1 : 0, // Match the Excel column name 'Status' exactly (case-sensitive) // Match the Excel column name 'Show Home' exactly (case-sensitive)
    ]);
    }
}