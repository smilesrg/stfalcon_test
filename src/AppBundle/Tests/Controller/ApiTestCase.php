<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 10.01.17
 * Time: 10:33
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiTestCase extends WebTestCase
{
    /**
     * @param Response $response
     * @param int $statusCode
     */
    protected function assertJsonResponse(Response $response, $statusCode)
    {
        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            'the "Content-Type" header is "application/json"'
        );
        $this->assertJson($response->getContent());
    }
}