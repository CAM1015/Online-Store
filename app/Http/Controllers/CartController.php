<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Models\CartItem;


class CartController extends Controller
{
    public function index(Request $request)
    {
    //Asegurarse de que el usuario esté autenticado
    $user = Auth::user();

    //Sincronizar el carrito con la sesión desde la base de datos. este método está hecho justo debajo
    $this->syncCartSession($request);

    $cartItems = CartItem::where('user_id', $user->id)->get();

    //calcular el total de la compra
    $total = $cartItems->sum(function ($cartItem) {
        return $cartItem->product->price * $cartItem->quantity;
    });

    $viewData = [];
    $viewData["title"] = "Cart - Online Store";
    $viewData["subtitle"] = "Shopping Cart";
    $viewData["total"] = $total;
    $viewData["products"] = $cartItems;

    return view('cart.index')->with("viewData", $viewData);
    }

    //Método para sincronizar el carrito de la base de datos con la sesión
    public function syncCartSession(Request $request)
    {
    $user = Auth::user();
    
    $cartItems = CartItem::where('user_id', $user->id)->get();

    $productsInSession = [];

    // Recorre los productos del carrito y agregarlos a la sesión
    foreach ($cartItems as $cartItem) {
        $productsInSession[$cartItem->product_id] = $cartItem->quantity;
    }

    // Guardar los productos en la sesión
    $request->session()->put('products', $productsInSession);
    }



    public function add(Request $request, $id)
    {
    $user = Auth::user();
    $product = Product::findOrFail($id);
    $quantity = $request->input('quantity', 1);

    // Buscar si el producto ya está en el carrito del usuario en la base de datos
    $cartItem = CartItem::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->first();

    // Si ya está en la base de datos, sumamos la cantidad
    if ($cartItem) {
        $cartItem->quantity += $quantity;
        $cartItem->save();
    } else {
        // Si no está en la base de datos, lo agregamos
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    // Ahora lo guardamos en la sesión para mantenerlo al hacer login o logout
    $productsInSession = $request->session()->get('products', []);

    if (isset($productsInSession[$product->id])) {
        $productsInSession[$product->id] += $quantity;
    } else {
        $productsInSession[$product->id] = $quantity;
    }

    // Guardamos los productos en la sesión
    $request->session()->put('products', $productsInSession);

    // Redirigimos al carrito
    return redirect()->route('cart.index');
    }



    public function remove(Request $request, $id)
    {
    $user = Auth::user();
    
    //buscar el producto en el carrito del usuario
    $cartItem = CartItem::where('user_id', $user->id)
                        ->where('product_id', $id)
                        ->first();

    if ($cartItem) {
        $cartItem->delete();
    }

    return back();
    }


    public function purchase(Request $request)
    {
        $productsInSession = $request->session()->get("products");
        
        if ($productsInSession) {
            $user = Auth::user();
            $total = 0;
            
            $productsInCart = Product::findMany(array_keys($productsInSession));
            foreach ($productsInCart as $product) {
                $quantity = $productsInSession[$product->getId()];
                $total += $product->getPrice() * $quantity;
            }

            if ($user->getBalance() < $total) {
                return redirect()->route('cart.index')->with('error', 'No tienes suficiente saldo para realizar esta compra.');
            }

            $userId = $user->getId();
            $order = new Order();
            $order->setUserId($userId);
            $order->setTotal($total);
            $order->save();

            foreach ($productsInCart as $product) {
                $quantity = $productsInSession[$product->getId()];
                $item = new Item();
                $item->setQuantity($quantity);
                $item->setPrice($product->getPrice());
                $item->setProductId($product->getId());
                $item->setOrderId($order->getId());
                $item->save();
            }

            $newBalance = $user->getBalance() - $total;
            $user->setBalance($newBalance);
            $user->save();

            $request->session()->forget('products');

            Mail::to($user->email)->send(new OrderConfirmationMail($order));

            // Enviar una copia al administrador
            Mail::to('claudia@admin.com')->send(new OrderConfirmationMail($order));

            $viewData = [];
            $viewData["title"] = "Purchase - Online Store";
            $viewData["subtitle"] =  "Purchase Status";
            $viewData["order"] =  $order;

            return view('cart.purchase')->with("viewData", $viewData);
        } else {
            return redirect()->route('cart.index');
        }
    }
}