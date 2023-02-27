<?php

namespace App\Tests;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful(string $uri): void
    {
        $client = self::createClient();
        $client->request('GET', $uri);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider(): Generator
    {
        yield ['/'];
        yield ['/catalogue'];
        // ...
    }
}
