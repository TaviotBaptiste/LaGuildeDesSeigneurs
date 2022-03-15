<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private $content;
    private static $identifier;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

   /**
    *Tests create
    */
    public function testCreate(){
        $this->client->request('POST','/character/create',
        array(),//parameters
        array(),//files
        array('CONTENT_TYPE' => 'application/json'),//server
        '{"kind":"Dame",
         "name":"Eldalótë",
          "surname":"Fleur elfique",
          "caste":"Elfe",
          "knowledge":"Arts",
          "intelligence":120,
          "life":12,
          "image":"/images/eldalote.jpg"}');
        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();}

    public function testDisplay(): void
    {
        $this->client->request('GET','/character/display/' . self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    public function testRedirectIndex(): void
    {
        $this->client->request('GET', '/character');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testModify(): void
    {
        //Tests with partial data array
        $this->client->request('PUT','/character/modify/' . self::$identifier,
        array(),//parameters
        array(),//files
        array('CONTENT_TYPE' => 'application/json'),//server
        '{"kind":"Seigneur", "name":"Gorthol"}');
        $this->assertJsonResponse();
        $this->assertIdentifier();
        //Tests with whole content
        $this->client->request('PUT','/character/modify/' . self::$identifier,
        array(),//parameters
        array(),//files
        array('CONTENT_TYPE' => 'application/json'),//server
        '{"kind":"Seigneur", "name":"Gorthol", "surname":"Heaume de terreur", "caste":"Chevalier", "knowledge":"Diplomatie", "intelligence":110, "life":13, "image":"/images/gorthol.jpg"}');
        $this->assertJsonResponse();
        $this->assertIdentifier();}

    public function testDelete(): void
    {
        $this->client->request('DELETE', '/character/delete/527d7dad085ed466874e9ee2e6d880ba7cf7f057' . self::$identifier);
        $this->assertJsonResponse();
    }

    public function testBadIdentifier(): void
    {
        $this->client->request('GET', '/character/display/basIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    public function testInexistingIdentifier(): void
    {
        $this->client->request('GET', '/character/display/527d7dad085ed466874e9ee2e6d880ba7cf7f057');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    public function assertJsonResponse(): void
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function assertError404($statusCode): void
    {
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Asserts that 'identifier'
     * is present in the Response
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }

    /**
     * Defines identifier
     */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }
    public function testImages(){
        //Tests without kind
        $this->client->request('GET', '/character/images/3');
        $this->assertJsonResponse();
        //Tests with kind
        $this->client->request('GET', '/character/images/dame/3');
        $this->assertJsonResponse();
    }

    public function testDisplayIntelligence(): void
    {
        $this->client->request('GET', '/character/intelligence/121');
        $this->assertJsonResponse();
    }

    public function testHtmlIntelligence(): void
    {
        $this->client->request('GET', '/character/html/intelligence/121');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testApiHtmlIntelligence(): void
    {
        $this->client->request('GET', '/character/api-html/intelligence/121');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}