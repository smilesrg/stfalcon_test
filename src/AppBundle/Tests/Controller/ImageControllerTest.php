<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 06.01.17
 * Time: 15:33
 */

namespace AppBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageControllerTest extends WebTestCase
{
    public function testGetImage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/images/1.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetImages()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/images');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPostImage()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/pages.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"title":"title1","body":"body1"}'
        );
        $this->assertJsonResponse($client->getResponse(), 201, false);
    }

    public function testJsonPostPageActionShouldReturn400WithBadParameters()
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            '/api/v1/pages.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"ninja":"turtles"}'
        );

        $this->assertJsonResponse($this->client->getResponse(), 400, false);
    }
}