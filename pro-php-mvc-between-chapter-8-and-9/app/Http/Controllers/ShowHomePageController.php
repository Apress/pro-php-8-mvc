<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Framework\Routing\Router;

class ShowHomePageController
{
    public function handle(Router $router)
    {
        $products = Product::all();

        $productsWithRoutes = array_map(function ($product) use ($router) {
            $product->route = $router->route('view-product', ['product' => $product->id]);
            return $product;
        }, $products);

        return view('home', [
            'products' => $productsWithRoutes,
        ]);
    }
}
