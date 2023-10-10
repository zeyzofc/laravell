<?php

namespace App\Imports;

use App\Models\DiscountCoupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CouponImport implements ToModel
{
    public function model(array $row)
    {
        return new DiscountCoupon([
        'code' => $row[0], // Match the Excel column name 'Name' exactly (case-sensitive)
        'name' => $row[1], // Match the Excel column name 'Slug' exactly (case-sensitive)
        'description' => $row[2], // Match the Excel column name 'Status' exactly (case-sensitive)
        'max_uses' => $row[3], // Match the Excel column name 'Show Home' exactly (case-sensitive)
        'max_uses_user' => $row[4],
        'type' => $row[5],
        'discount_amount' => $row[6],
        'min_amount' => $row[7],
        'status' => $row[8],
        'starts_at' => $row[9],
        'expires_at' => $row[10],
    ]);
    }
}