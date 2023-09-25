<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('path/to/your/styles.css') }}"> --}}
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .pt-2{
        padding-top:2px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-25{
        width:25%;
    }
    .w-75{
        width:75%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:180px;
        height:180px;
    }
    .logo span{
        margin-left:8px;
        top:10px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .blue-color{
        color:#1109f6;
    }
    .white-color{
        color: white;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #000000;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #fa03dd;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        margin-right: 40px;
        float:left;
    }
    .total-part{
        display: flex;
        justify-content: space-between; /* Membuat elemen dalam .total-part tersebar secara merata */
        align-items: center; /* Menengahkan elemen secara vertikal */
        font-size:14px;
        line-height:12px;
        margin-bottom: 10px;
    }
    .total-right p{
        margin-right: 10px;
        padding-right:20px;
    }
    .head-title {
        position: relative; /* Add this to enable absolute positioning */
    }
    .logo img {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
<body>
<div class="head-title">
    <h1>Invoice</h1>
    <div class="logo">
        <img src="https://i.imgur.com/Fs00trU.png">
    </div>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-2 text-bold w-100">Order Id - <span class="gray-color">{{ ($data['order']->id) }}</span></p>
        <p class="m-0 pt-2 text-bold w-100">Order Date - <span class="gray-color">{{ $data['order']->created_at->format('Y-m-d') }}</span></p>
        <p class="m-0 pt-2 text-bold w-100">Invoice Id - <span class="gray-color">#{{ ($data['order']->invoice_number) }}</span></p>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50" class="white-color">From</th>
            <th class="w-50" class="white-color">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>Budi Store</p>
                    <p>Jalan Raya Budi Gurinjay,</p>
                    <p>Denpasar Timur, Tonja, 201239</p>
                    <p>Contact : 1234567890</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>{{ $data['user']->name }}</p>
                    <p>{{ $data['address']->address }}</p>
                    <p>{{ $data['address']->city }}, {{ $data['address']->state }}, {{ $data['address']->zip }}</p>
                    <p>Contact : {{ $data['address']->mobile }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50" class="white-color">Product Name</th>
            <th class="w-50" class="white-color">Price</th>
            <th class="w-25" class="white-color">Qty</th>
            <th class="w-50" class="white-color">Subtotal</th>
        </tr>
        @foreach ($data['orderItems'] as $item)
        <tr align="center">
            <td>{{ $item->name }}</td>
            <td>Rp {{ number_format ($item->price, 2)}}</td>
            <td>{{ $item->qty }}</td>
            <td>Rp {{ number_format ($item->total,2)}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4">
                <div class="total-part">
                    <div class="total-left w-75 float-left" align="right">
                        <p>Sub Total</p>
                        <p>Shipping Fee</p>
                        <p>Discount</p>
                        <p>Grand Total</p>
                    </div>
                    <div class="total-right float-left text-bold">
                        <p>Rp {{ number_format($data['order']->subtotal, 2) }}</p>
                        <p>Rp {{ number_format($data['order']->shipping, 2) }}</p>
                        <p> - Rp {{ number_format($data['order']->discount, 2) }}</p>
                        <p>Rp {{ number_format($data['order']->grand_total, 2) }}</p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>
