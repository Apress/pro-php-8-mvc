<?php

namespace App\Http\Controllers\Users;

use Framework\Routing\Router;

class LogOutUserController
{
    public function handle(Router $router)
    {
        session()->forget('user_id');

        return redirect($router->route('show-home-page'));
    }
}
