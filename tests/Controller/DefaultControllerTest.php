<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function provideUrlsAndStatusCodes(): array
    {
        return [
            'index' => ['/', 200],
            'contact' => ['/contact', 200],
            'book index' => ['/book', 200],
            'book show' => ['/book/1', 200],
            'toto' => ['/toto', 404],
        ];
    }

    /**
     * @dataProvider provideUrlsAndStatusCodes
     */
    public function testPublicUrlIsSuccessful(string $uri, int $statusCode): void
    {
        $client = static::createClient();
        $client->request('GET', $uri);

        $this->assertResponseStatusCodeSame($statusCode);
    }
}
