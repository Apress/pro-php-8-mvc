<?php

namespace App\Http\Controllers\Products;

use Framework\Routing\Router;

class OrderProductController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        secure();

        // use $data to create a database record...

        $_SESSION['ordered'] = true;

        return redirect($this->router->route('show-home-page'));
    }
}
