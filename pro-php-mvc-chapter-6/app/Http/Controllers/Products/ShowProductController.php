<?php

namespace App\Http\Controllers\Products;

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

        return view('products/view', [
            'product' => $parameters['product'],
            'scary' => '<script>alert("hello")</script>',
        ]);
    }
}
