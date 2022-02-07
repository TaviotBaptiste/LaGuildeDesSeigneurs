<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Tests redirect index
     */
    private $client;
    public function setUp(): void{
        $this->client = static::createClient();
    }

    public function testRedirectIndex(){
        $client = static::createClient();
        $client->request('GET','character');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
     }
     public function testBadIdentifier(){
         $this->client->request("GET","character/display/badIdentifier");
         $this->assertError404($this->client->getResponse()->getStatusCode());
     }
     public function assertError404($statusCode){
         $this->assertEquals(404,$statusCode);
     }

     public function textInexistingIdentifier() {
         $this->client->request("GET","/character/display/8F9RV929R87F83FZ8D87R39error");
         $this->assertError404($this->client->getResponse()->getStatusCode());
     }

     public function assertJsonResponse(){
         $response = $this->client->getResponse();
         $this->assertEquals(200, $response->getStatusCode());
         $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
     }
     public function testIndex(){
        $client = static::createClient();
        $client->request('GET','character/index');
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
     }
    public function testDisplay(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/character/display/d144bfbba888ce346321eb3f5045cfadf7c9fb54');

        $this->assertJsonResponse($client->getResponse());
    }
}
