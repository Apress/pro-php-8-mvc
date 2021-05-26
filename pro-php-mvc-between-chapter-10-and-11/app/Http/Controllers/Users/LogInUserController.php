<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Framework\Routing\Router;

class LogInUserController
{
    public function handle(Router $router)
    {
        secure();

        $data = validate($_POST, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ], 'login_errors');

        $user = User::where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user->password)) {
            session()->put('user_id', $user->id);
        }

        return redirect($router->route('show-home-page'));
    }
}
