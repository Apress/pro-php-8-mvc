<?php

namespace Framework\Provider;

use Framework\App;
use Framework\Validation\Manager;
use Framework\Validation\Rule\RequiredRule;
use Framework\Validation\Rule\EmailRule;
use Framework\Validation\Rule\MinRule;

class ValidationProvider
{
    public function bind(App $app): void
    {
        $app->bind('validator', function($app) {
            $manager = new Manager();
    
            $this->bindRules($app, $manager);
    
            return $manager;
        });
    }

    private function bindRules(App $app, Manager $manager): void
    {
        $app->bind('validation.rule.required', fn() => new RequiredRule());
        $app->bind('validation.rule.email', fn() => new EmailRule());
        $app->bind('validation.rule.min', fn() => new MinRule());

        $manager->addRule('required', $app->resolve('validation.rule.required'));
        $manager->addRule('email', $app->resolve('validation.rule.email'));
        $manager->addRule('min', $app->resolve('validation.rule.min'));
    }
}
