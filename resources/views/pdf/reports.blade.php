<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Sales Report</h1>
        <p>From: <strong>{{ $startDate }}</strong> To: <strong>{{ $endDate }}</strong></p>
    </div>

    <h2>Summary</h2>
    <table>
        <tr>
            <td>Total Sales Amount</td>
            <td class="text-right">${{ number_format($totalSalesAmount, 2) }}</td>
        </tr>
        <tr>
            <td>Total Expenses Amount</td>
            <td class="text-right">${{ number_format($totalExpensesAmount, 2) }}</td>
        </tr>
        <tr>
            <td>Profit</td>
            <td class="text-right">${{ number_format($profit, 2) }}</td>
        </tr>
    </table>

    <h2>Monthly Sales</h2>
    <table>
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Total Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monthlySales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td class="text-right">${{ number_format($sale->total_price, 2) }}</td>
                    <td>{{ $sale->date->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Top Selling Products</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Selling Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topSellingProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="text-right">${{ number_format($product->selling_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
