
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
        .order-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #e9ecef;
        }
        .admin-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Order Alert</h1>
        <p>A new order has been placed on your platform</p>
    </div>

    <div class="content">
        <p>Hello Admin,</p>
        
        <p>A new order has been placed on your e-commerce platform. Please review the details below:</p>

        <div class="order-details">
            <h3>Order Information</h3>
            <p><strong>Order Number:</strong> #{{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y \a\t H:i A') }}</p>
            <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
        </div>

        <div class="order-details">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Shipping Address:</strong><br>{{ $order->shipping_address }}</p>
        </div>

        <h3>Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->equipment->name ?? 'Product' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3"><strong>Total Amount</strong></td>
                    <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: center;">
            <a href="{{ route('adminorders.show', $order->id) }}" class="admin-button">View Order in Admin Panel</a>
        </div>

        <p>Please process this order as soon as possible.</p>
    </div>

    <div class="footer">
        <p>This is an automated notification from your e-commerce platform.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }} Admin Panel</p>
    </div>
</body>
</html>
