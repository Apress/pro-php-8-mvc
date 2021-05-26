<?php

namespace Framework\View\Engine;

use Framework\View\Engine\HasManager;
use Framework\View\View;

class BasicEngine implements Engine
{
    use HasManager;

    public function render(View $view): string
    {
        $contents = file_get_contents($view->path);

        foreach ($view->data as $key => $value) {
            $contents = str_replace(
                '{'.$key.'}', $value, $contents
            );
        }

        return $contents;
    }
}
