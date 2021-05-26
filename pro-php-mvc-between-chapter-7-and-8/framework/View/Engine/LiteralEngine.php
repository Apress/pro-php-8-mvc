<?php

namespace Framework\View\Engine;

use Framework\View\Engine\HasManager;
use Framework\View\View;

class LiteralEngine implements Engine
{
    use HasManager;

    public function render(View $view): string
    {
        return file_get_contents($view->path);
    }
}
