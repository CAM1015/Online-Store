<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
</head>
<body>
    <h1>New Order Notification</h1>
    <p>You have a new order. Here are the details:</p>
    
    <ul>
        <li><strong>Order ID:</strong> {{ $order->getId() }}</li>
        <li><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</li>
        <li><strong>Total:</strong> ${{ $order->getTotal() }}</li>
        <li><strong>Date:</strong> {{ $order->created_at }}</li>
    </ul>

    <h3>Order Items:</h3>
    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product->name }} (x{{ $item->getQuantity() }}) - ${{ $item->getPrice() * $item->getQuantity() }}</li>
        @endforeach
    </ul>

    <p>Thank you for managing the orders!</p>
</body>
</html>
