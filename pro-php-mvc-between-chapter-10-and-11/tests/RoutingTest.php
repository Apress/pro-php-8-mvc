<?php

use Framework\App;
use Framework\Testing\TestCase;
use Framework\Testing\TestResponse;

class RoutingTest extends TestCase
{
    protected App $app;

    public function setUp(): void
    {
        parent::setUp();

        $this->app = App::getInstance();
        $this->app->bind('paths.base', fn() => __DIR__ . '/../');
    }

    public function testHomePageIsShown()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        $expected = 'Take a trip on a rocket ship';

        $this->assertStringContainsString($expected, $this->app->run()->content());
    }

    public function testRegistrationErrorsAreShown()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/register';
        $_SERVER['HTTP_REFERER'] = '/register';

        $_POST['email'] = 'foo';
        $_POST['csrf'] = csrf();

        $response = new TestResponse($this->app->run());

        $this->assertTrue($response->isRedirecting());
        $this->assertEquals($response->redirectingTo(), '/register');

        $response->follow();

        $this->assertStringContainsString('email should be an email', $response->content());
    }
}
