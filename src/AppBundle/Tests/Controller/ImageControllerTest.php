<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpFoundation\Response;

class ImageControllerTest extends ApiTestCase
{
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
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $content);
    }


    public function testGetImage()
    {
        $client = static::createClient();

        /** @var Image */
        $image = $this->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(Image::class)
            ->findOneBy([])
            ;

        $client->request('GET', "/api/images/" . $image->getId() . ".json");
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_OK);
        $content = json_decode($client->getResponse()->getContent());
        $this->assertEquals($image->getTitle(), $content->title);
        $this->assertEquals($image->getDescription(), $content->description);
        $this->assertObjectHasAttribute('created_at', $content);
        $this->assertNotEmpty($content->created_at);

        //Assert that there is no field like image_name, we won't expose it
        $this->assertObjectNotHasAttribute('image_name', $content);
    }


    public function testGetImages()
    {
        $client = static::createClient();

        $client->request('GET', '/api/images');
        $this->assertJsonResponse($client->getResponse(), Response::HTTP_OK);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($content);
        $this->assertArrayHasKey('items', $content);
        $this->assertNotEmpty($content['items']);
        foreach ($content['items'] as $image) {
            $this->assertArrayHasKey('title', $image);
            $this->assertArrayHasKey('description', $image);
            $this->assertArrayHasKey('created_at', $image);
        }
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