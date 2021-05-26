<?php

use Framework\View;

if (!function_exists('view')) {
    function view(string $template, array $data = []): View\View
    {
        static $manager;

        if (!$manager) {
            $manager = new View\Manager();

            // let's add a path for our views folder
            // so the manager knows where to look for views
            $manager->addPath(__DIR__ . '/../resources/views');

            // we'll also start adding new engine classes
            // with their expected extensions to be able to pick
            // the appropriate engine for the template
            $manager->addEngine('basic.php', new View\Engine\BasicEngine());
            $manager->addEngine('advanced.php', new View\Engine\AdvancedEngine());
            $manager->addEngine('php', new View\Engine\PhpEngine());

            // how about macros? let's add them here for now
            $manager->addMacro('escape', fn($value) => htmlspecialchars($value, ENT_QUOTES));
            $manager->addMacro('includes', fn(...$params) => print view(...$params));
        }

        // return $manager->render($template, $data);
        return $manager->resolve($template, $data);
    }
}
