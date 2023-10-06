<?php

namespace App\Imports;

use App\Models\subCategory;
use App\Models\Category; // Import the Category model
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class SubCategoryImport implements ToModel
{
    public function model(array $row)
    {
        // Find the category based on the category name
        $category = Category::where('name', $row[4])->first();

        // Check if the category exists
        if ($category) {
            return new subCategory([
                'name' => $row[0],
                'slug' => $row[1],
                'status' => $row[2] === 'Active' ? 1 : 0,
                'showHome' => $row[3],
                'category_id' => $category->id, // Use the category's ID
            ]);
        }

        // Handle the case where the category doesn't exist (you can log an error or handle it as needed)
        return null;
    }
}