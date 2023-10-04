<?php

namespace App\Exports;

use App\Models\ShippingCharge;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportShipping implements FromCollection, WithHeadings
{
    public function collection()
    {
        $shippingCharges = ShippingCharge::select(
            'country_id',
            'amount'
        )->get();
        
        $shippingCharges = $shippingCharges->map(function ($shippingCharge) {
            if ($shippingCharge->country_id === 'rest_of_world') {
                $countryName = 'Rest of The World';
            } else {
                $country = Country::find($shippingCharge->country_id);
                $countryName = $country ? $country->name : '';
            }

            return [
                'country' => $countryName,
                'amount' => $shippingCharge->amount,
            ];
        });

        // Add 'Rest of World' if it doesn't exist in the ShippingCharge table
        if (!$shippingCharges->contains('country', 'Rest of World')) {
            $shippingCharges->push([
                'country' => 'Rest of The World',
                'amount' => '', // You can set the amount to an empty string or any default value
            ]);
        }
    
        return $shippingCharges;
    }
    
    public function headings(): array
    {
        return [
            'Country Name',
            'Amount',
        ];
    }
}