<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Framework\Routing\Router;

class RegisterUserController
{
    public function handle(Router $router)
    {
        secure();

        $data = validate($_POST, [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ], 'register_errors');

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->save();

        session()->put('registered', true);

        return redirect($router->route('show-home-page'));
    }
}
