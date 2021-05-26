<?php

namespace Framework\Testing;

use Framework\App;
use Framework\Http\Response;

class TestResponse
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function isRedirecting(): bool
    {
        return $this->response->type() === Response::REDIRECT;
    }

    public function redirectingTo(): ?string
    {
        return $this->response->redirect();
    }

    public function follow(): static
    {
        while ($this->isRedirecting()) {
            $_SERVER['REQUEST_METHOD'] = 'GET';
            $_SERVER['REQUEST_URI'] = $this->redirectingTo();
            $this->response = App::getInstance()->run();
        }

        return $this;
    }

    public function __call(string $method, array $parameters = []): mixed
    {
        return $this->response->$method(...$parameters);
    }
}
