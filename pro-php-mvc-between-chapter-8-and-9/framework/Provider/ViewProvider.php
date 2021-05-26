<?php

namespace Framework\Provider;

use Framework\App;
use Framework\View\Manager;
use Framework\View\Engine\BasicEngine;
use Framework\View\Engine\AdvancedEngine;
use Framework\View\Engine\PhpEngine;
use Framework\View\Engine\LiteralEngine;

class ViewProvider
{
    public function bind(App $app)
    {
        $app->bind('view', function($app) {
            $manager = new Manager();
    
            $this->bindPaths($app, $manager);
            $this->bindMacros($app, $manager);
            $this->bindEngines($app, $manager);
    
            return $manager;
        });
    }

    private function bindPaths(App $app, Manager $manager)
    {
        $manager->addPath($app->resolve('paths.base') . '/resources/views');
        $manager->addPath($app->resolve('paths.base') . '/resources/images');
    }

    private function bindMacros(App $app, Manager $manager)
    {
        $manager->addMacro('escape', fn($value) => htmlspecialchars($value, ENT_QUOTES));
        $manager->addMacro('includes', fn(...$params) => print view(...$params));
    }

    private function bindEngines(App $app, Manager $manager)
    {
        $app->bind('view.engine.basic', fn() => new BasicEngine());
        $app->bind('view.engine.advanced', fn() => new AdvancedEngine());
        $app->bind('view.engine.php', fn() => new PhpEngine());
        $app->bind('view.engine.literal', fn() => new LiteralEngine());

        $manager->addEngine('basic.php', $app->resolve('view.engine.basic'));
        $manager->addEngine('advanced.php', $app->resolve('view.engine.advanced'));
        $manager->addEngine('php', $app->resolve('view.engine.php'));
        $manager->addEngine('svg', $app->resolve('view.engine.literal'));
    }
}
