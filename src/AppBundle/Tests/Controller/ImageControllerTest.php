<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 06.01.17
 * Time: 15:33
 */

namespace AppBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Client;

class ImageControllerTest extends ApiTestCase
{
    /*
    public function testGetImage()
    {
        $client = static::createClient();

        $client->request('GET', '/api/images/1.json');
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_OK);
        $content = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('title', $content);
        //TODO: check content
    }
    */

    public function testGetImages()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/images');
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_OK);
    }

    public function testPostImage()
    {
        $imageContent = [
            'title' => 'Functional test Title',
            'description' => 'Description',
            'tags' => [
                ['name' => 'newtag'],
                ['name' => 'testtag'],
                ['name' => 'functionaltest'],
            ]
        ];

        $client = static::createClient();
        $client->request('POST', '/api/images', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode($imageContent));

        $this->assertJsonResponse($client->getResponse(), Response::HTTP_CREATED);
    }

    public function testPostImageWithBadRequest()
    {
        $imageContent = [
            'extrafield' => 'content',
            'tags' => 'blabla',
        ];

        $client = static::createClient();
        $client->request('POST','/api/images', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode($imageContent));

        $this->assertJsonResponse($client->getResponse(), Response::HTTP_BAD_REQUEST);
    }
}