<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use Framework\Routing\Router;

class ShowProductController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        $parameters = $this->router->current()->parameters();

        $product = Product::find((int) $parameters['product']);

        return view('products/view', [
            'product' => $product,
            'orderAction' => $this->router->route('order-product', ['product' => $product->id]),
            'csrf' => csrf(),
        ]);
    }
}
