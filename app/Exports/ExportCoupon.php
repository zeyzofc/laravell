<?php

namespace App\Exports;

use App\Models\DiscountCoupon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCoupon implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Select the necessary fields from the Order model
        $discountCoupons = DiscountCoupon::select(
            'code',
            'name',
            'description',
            'max_uses',
            'max_uses_user',
            'type',
            'discount_amount',
            'min_amount',
            'status',
            'starts_at',
            'expires_at',
        )->get();

        // Map and format the order data as needed
        $discountCoupons = $discountCoupons->map(function ($discountCoupon) {
            return [
                'Code' => $discountCoupon->code,
                'Name' => $discountCoupon->name,
                'Description' => $discountCoupon->description,
                'Max Uses' => $discountCoupon->max_uses,
                'Max Uses User' => $discountCoupon->max_uses_user,
                'Type' => $discountCoupon->type,
                'Discount Amount' => $discountCoupon->discount_amount, // Conditionally set status
                'Min Amount' => $discountCoupon->min_amount,
                'Status' => $discountCoupon->status,
                'Start at' => $discountCoupon->starts_at,
                'Expires at' => $discountCoupon->expires_at,
            ];
        });

        return $discountCoupons;
    }

    public function headings(): array
    {
        return [
        'Code',
        'Name',
        'Description',
        'Max Uses',
        'Max Uses Per User',
        'Type',
        'Discount Amount',
        'Min Amount',
        'Status',
        'Start at',
        'Expires at',
        ];
    }
}