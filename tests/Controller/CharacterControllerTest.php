<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    public function testDisplay(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/character/display/d144bfbba888ce346321eb3f5045cfadf7c9fb54');

        $this->assertJsonResponse($client->getResponse());
    }


    public function assertJsonResponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
