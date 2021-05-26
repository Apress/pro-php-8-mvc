<?php

namespace App\Http\Controllers\Products;

use Framework\Routing\Router;

class OrderProductController
{
    public function handle(Router $router)
    {
        secure();

        // use $data to create a database record...

        $_SESSION['ordered'] = true;

        return redirect($router->route('show-home-page'));
    }
}
