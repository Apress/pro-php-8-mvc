<?php

use Facebook\WebDriver\WebDriverBy;
use Framework\Testing\TestCase;
use Symfony\Component\Panther\Client;

class BrowserTest extends TestCase
{
    public function testLoginForm()
    {
        $client = Client::createFirefoxClient();
        $client->request('GET', 'http://127.0.0.1:8000/register');

        $client->waitFor('.log-in-button');
        $client->executeScript("document.querySelector('.log-in-button').click()");

        $client->waitFor('.log-in-errors');
        $element = $client->findElement(WebDriverBy::className('log-in-form'));

        $this->assertStringContainsString('email is required', $element->getText());
        $this->assertStringContainsString('password is required', $element->getText());
    }

    public function testRegisterForm()
    {
        $client = Client::createFirefoxClient();
        $client->request('GET', 'http://127.0.0.1:8000/register');

        $client->waitFor('.register-button');
        $client->executeScript("document.querySelector('.register-button').click()");

        $client->waitFor('.register-errors');
        $element = $client->findElement(WebDriverBy::className('register-form'));

        $this->assertStringContainsString('name is required', $element->getText());
        $this->assertStringContainsString('email is required', $element->getText());
        $this->assertStringContainsString('password is required', $element->getText());
    }
}
