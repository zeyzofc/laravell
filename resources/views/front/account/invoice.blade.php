<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Reset default styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Invoice container */
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Header section */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        /* Billing details section */
        .bill-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        /* Itemized list section */
        .itemized-list {
            border-collapse: collapse;
            width: 100%;
        }

        .itemized-list th, .itemized-list td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .itemized-list th {
            background-color: #f2f2f2;
        }

        /* Total section */
        .total {
            text-align: right;
            margin-top: 20px;
        }

        /* Footer section */
        .footer {
            text-align: center;
            margin-top: 20px;
        }

        /* Thank you message */
        .thank-you {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <img src="https://www.pnb-gianyar.ac.id/wp-content/uploads/2022/05/Logo-Politeknik-Negeri-Bali.png" alt="Your Company Logo" class="logo">
            <h1>Invoice</h1>
        </div>

        <!-- Billing Details -->
        <div class="bill-details">
            <div>
                <p><strong>From:</strong></p>
                <p>Budi Store</p>
                <p>Jalan Budi Anjay Gurinjay</p>
            </div>
            <div>
                <p><strong>To:</strong></p>
                <p>{{ $data['user']->name }}</p>
                <p>{{ $data['address']->address }}</p>
                <p>{{ $data['address']->city }}, {{ $data['address']->state }}, {{ $data['address']->zip }}</p>
            </div>
        </div>

        <!-- Itemized List -->
        <table class="itemized-list">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Replace the following rows with your data -->
                @foreach ($data['orderItems'] as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format ($item->price, 2)}}</td>
                    <td>Rp {{ number_format ($item->total,2)}}</td>
                </tr>
                <!-- Add more rows as needed -->
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <div class="total">
            <!-- Replace the total amount with your calculated total -->
            <br>
            <br>
            <p><strong>Shipping :</strong> Rp {{ number_format($data['order']->shipping, 2) }}</p>
            <p><strong>Discount :</strong> Rp {{ number_format($data['order']->discount, 2) }}</p>
            <p><strong>Total Amount :</strong> Rp {{ number_format($data['order']->grand_total, 2) }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
          <br>
          <br>
          <br>
            <p class="thank-you">Terima Kasih Sudah Berbelanja Di Budi Store 😊🙏 </p>
        </div>
    </div>
</body>
</html>
