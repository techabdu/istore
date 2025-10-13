<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $sale->invoice->invoice_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20pt;
            margin: 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice</h1>
        <p>Invoice Number: <strong>{{ $sale->invoice->invoice_number }}</strong></p>
        <p>Date: {{ $sale->date->format('Y-m-d') }}</p>
    </div>

    <h2>Products Sold</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $productId => $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="text-center">{{ $quantities[$productId] }}</td>
                    <td class="text-right">${{ number_format($product->selling_price, 2) }}</td>
                    <td class="text-right">${{ number_format($product->selling_price * $quantities[$productId], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                <td class="text-right"><strong>${{ number_format($sale->total_price, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
