<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Muestra todos los pedidos de todos los usuarios
     */
    public function index()
    {
        // Obtener todos los pedidos con la información del usuario
        $orders = Order::with('user')->paginate(10); // 10 pedidos por página

        // Pasar los datos a la vista
        return view('admin.orders.index', compact('orders'));
    }
}