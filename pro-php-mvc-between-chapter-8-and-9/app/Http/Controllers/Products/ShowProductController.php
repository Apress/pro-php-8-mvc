<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use Framework\Routing\Router;

class ShowProductController
{
    public function handle(Router $router)
    {
        $parameters = $router->current()->parameters();

        $product = Product::find((int) $parameters['product']);

        return view('products/view', [
            'product' => $product,
            'orderAction' => $router->route('order-product', ['product' => $product->id]),
            'csrf' => csrf(),
        ]);
    }
}
