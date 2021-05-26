<?php

namespace App\Http\Controllers\Services;

use Framework\Routing\Router;

class ShowServiceController
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle()
    {
        $parameters = $this->router->current()->parameters();

        if (empty($parameters['service'])) {
            return 'all services';  
        }
    
        return "service is {$parameters['service']}";
    }
}
