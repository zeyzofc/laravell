<?php

namespace App\Exports;

use App\Models\DiscountCoupon;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Select the necessary fields from the Order model
        $users = User::select(
            'id',
            'name',
            'email',
            'phone',
        )->where('status', 1)->where('role', 1)->get();

        // Map and format the order data as needed
        $users = $users->map(function ($user) {
            return [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Phone' => $user->phone,
            ];
        });

        return $users;
    }

    public function headings(): array
    {
        return [
        'ID',
        'Name',
        'Email',
        'Phone',
        ];
    }
}