<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ShippingImport implements ToModel
{
    public function model(array $row)
    {
        // Find the country based on the country name
        $country = Country::where('name', $row[0])->first();

        // Check if the country exists
        if ($country) {
            return new ShippingCharge([
                'country_id' => $country->id, // Set the country_id to the ID of the country
                'amount' => $row[1],
            ]);
        }

        // Handle the case where the country doesn't exist (you can log an error or handle it as needed)
        return null;
    }
}