<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryImport implements ToModel
{
    public function model(array $row)
    {
        return new Category([
        'name' => $row[0], // Match the Excel column name 'Name' exactly (case-sensitive)
        'slug' => $row[1], // Match the Excel column name 'Slug' exactly (case-sensitive)
        'status' => $row[2] === 'Active' ? 1 : 0, // Match the Excel column name 'Status' exactly (case-sensitive)
        'showHome' => $row[3], // Match the Excel column name 'Show Home' exactly (case-sensitive)
    ]);
    }
}