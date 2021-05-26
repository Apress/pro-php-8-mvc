<?php

namespace Framework\View;

use Framework\View\Engine\Engine;

class View
{
    public function __construct(
        protected Engine $engine,
        public string $path,
        public array $data = [],
    ) {}

    public function __toString()
    {
        return $this->engine->render($this);
    }
}
