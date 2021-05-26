<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

use Framework\Validation\Manager;
use Framework\Validation\Rule\EmailRule;
use Framework\Validation\Rule\MinRule;
use Framework\Validation\Rule\RequiredRule;
use Framework\Validation\ValidationException;

class ValidationTest extends Framework\Testing\TestCase
{
    protected Manager $manager;

    public function setUp(): void
    {
        parent::setUp();

        $this->manager = new Manager();
        $this->manager->addRule('email', new EmailRule());
        $this->manager->addRule('min', new MinRule());
        $this->manager->addRule('required', new RequiredRule());
    }

    public function testInvalidEmailValuesFail()
    {
        $expected = ['email' => ['email should be an email']];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->manager->validate(['email' => 'foo'], ['email' => ['email']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidEmailValuesPass()
    {
        $data = $this->manager->validate(['email' => 'foo@bar.com'], ['email' => ['email']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }

    public function testInvalidRequiredValuesFail()
    {
        $expected = ['email' => ['email is required']];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->manager->validate(['email' => ''], ['email' => ['required']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidRequiredValuesPass()
    {
        $data = $this->manager->validate(['email' => 'foo@bar.com'], ['email' => ['required']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }

    public function testInvalidMinValuesFail()
    {
        $expected = ['email' => ['email should be at least 4 characters']];

        [ $exception ] = $this->assertExceptionThrown(
            fn() => $this->manager->validate(['email' => 'foo'], ['email' => ['min:4']]),
            ValidationException::class,
        );

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidMinValuesPass()
    {
        $data = $this->manager->validate(['email' => 'foo@bar.com'], ['email' => ['min:4']]);
        $this->assertEquals($data['email'], 'foo@bar.com');
    }
}
