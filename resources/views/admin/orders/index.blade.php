@extends('layouts.admin')

@section('title', 'List of orders')

@section('content')
    <h1>List of orders</h1>

    <!-- Tabla con los pedidos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Date of order</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $orders->links() }}
@endsection
