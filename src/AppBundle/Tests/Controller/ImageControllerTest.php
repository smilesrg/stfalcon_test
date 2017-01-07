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
}