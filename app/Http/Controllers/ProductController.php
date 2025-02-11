<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Products - Online Store";
        $viewData["subtitle"] = "List of products";
    
        // Obtener la categoría de la solicitud (si se proporciona)
        $category = $request->query('category');
    
        // Obtener productos según la categoría o todos si no se selecciona una
        if ($category && in_array($category, ['tshirts', 'jackets', 'bags'])) {
            $viewData["products"] = Product::where('category', $category)->get();
        } else {
            $viewData["products"] = Product::all();
        }
    
        // Pasar las categorías disponibles a la vista
        $viewData["categories"] = ['tshirts', 'jackets', 'bags'];
    
        return view('product.index')->with("viewData", $viewData);
    }
    

    public function show($id)
    {
        $viewData = [];
        $product = Product::findOrFail($id);
        $viewData["title"] = $product->getName() . " - Online Store";
        $viewData["subtitle"] = $product->getName() . " - Product information";
        $viewData["product"] = $product;

        return view('product.show')->with("viewData", $viewData);
    }

    public function loadMore(Request $request)
    {
        $perPage = 10;
        $page = $request->page ?? 1;

        $products = Product::skip($perPage * ($page - 1))
                           ->take($perPage)
                           ->get();

        return response()->json($products);
    }
}
