<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    const TEST_ROUTE = 'first';
    const TEST_IP = '127.0.0.1';
    const TEST_METHOD = 'POST';
    const TEST_LAST_DAYS = '10';
    const TEST_SEARCH = 'test';

    public static $id;

    /**
     * Test adding request in /storeRequest/*
     */
    public function testStoreRequest()
    {
        $client = static::createClient();
        $client->request(
            self::TEST_METHOD,
            '/storeRequest/' . self::TEST_ROUTE,
            array(
                'body' => 'my ' . self::TEST_SEARCH
            ),
            array(),
            array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'CONTENT_TYPE' => 'application/json'
            )
        );

        $content = json_decode($client->getResponse()->getContent(), true);
        static::$id = $content['id'];
        $this->assertEquals(true, $content['Success']);
    }

    /**
     * Test response in /getRequest/
     */
    public function testGetRequest()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/getRequest/',
            array(
                'route' => self::TEST_ROUTE,
                'ip' => self::TEST_IP,
                'method' => self::TEST_METHOD,
                'last_days' => self::TEST_LAST_DAYS,
                'search' => self::TEST_SEARCH,
            ),
            array(),
            array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'CONTENT_TYPE' => 'application/json'
            )
        );

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(static::$id, $content[count($content) - 1]['id']);
    }
}