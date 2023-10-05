<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Country; // Import the Country model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ExportOrder implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Select the necessary fields from the Order model
        $orders = Order::select(
            'id',
            'invoice_number',
            'subtotal',
            'shipping',
            'coupon_code',
            'discount',
            'grand_total',
            'payment_status',
            'status',
            'shipped_date',
            'first_name',
            'last_name',
            'email',
            'mobile',
            'country_id',
            'address',
            'apartment',
            'city',
            'state',
            'zip',
            'notes'
        )->get();

        // Map and format the order data as needed
        $orders = $orders->map(function ($order) {
            $paymentStatusMap = [
                1 => 'Waiting Payment',
                2 => 'Paid',
                3 => 'Expired',
                4 => 'Cancelled',
            ];

            // Retrieve the country name using the Country model
            if ($order->country_id === 'rest_of_world') {
                $countryName = 'Rest of The World';
            } else {
                $country = Country::find($order->country_id);
                $countryName = $country ? $country->name : '';
            }

            return [
                'ID' => $order->id,
                'Invoice Number' => $order->invoice_number,
                'Subtotal' => $order->subtotal,
                'Shipping' => $order->shipping,
                'Coupon Code' => $order->coupon_code,
                'Discount' => $order->discount,
                'Grand Total' => $order->grand_total,
                'Payment Status' => $paymentStatusMap[$order->payment_status] ?? 'Unknown', // Map payment status
                'Order Status' => $order->status, // Conditionally set status
                'Shipped Date' => $order->shipped_date,
                'First Name' => $order->first_name,
                'Last Name' => $order->last_name,
                'Email' => $order->email,
                'Mobile' => $order->mobile,
                'Country' => $countryName, // Use 'Country' instead of 'Country ID'
                'Address' => $order->address,
                'Apartment' => $order->apartment,
                'City' => $order->city,
                'State' => $order->state,
                'ZIP' => $order->zip,
                'Notes' => $order->notes,
            ];
        });

        return $orders;
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Invoice Number',
            'Subtotal',
            'Shipping',
            'Coupon Code',
            'Discount',
            'Grand Total',
            'Payment Status',
            'Order Status',
            'Shipped Date',
            'First Name',
            'Last Name',
            'Email',
            'Mobile',
            'Country', // Change 'Country ID' to 'Country'
            'Address',
            'Apartment',
            'City',
            'State',
            'ZIP',
            'Notes',
        ];
    }
}