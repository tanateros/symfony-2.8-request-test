<?php

namespace ApiBundle\Tests\Entity;

use ApiBundle\Entity\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RequestTest extends WebTestCase
{
    const TEST_ROUTE = 'first';
    const TEST_IP = '127.0.0.1';
    const TEST_METHOD = 'POST';
    const TEST_LAST_DAYS = '10';
    const TEST_SEARCH = 'test';

    /**
     * Testing Request entity
     */
    public function testSetterGetter()
    {
        $request = new Request();
        $request->setCreated();
        $request->setIp(self::TEST_IP);
        $this->assertEquals(self::TEST_IP, $request->getIp());
        $request->setMethod(self::TEST_METHOD);
        $this->assertEquals(self::TEST_METHOD, $request->getMethod());
        $request->setRoute(self::TEST_ROUTE);
        $this->assertEquals(self::TEST_ROUTE, $request->getRoute());
        $request->setBody(self::TEST_SEARCH);
        $this->assertEquals(self::TEST_SEARCH, $request->getBody());
        $customHeader = json_encode(array("HTTP_CUSTOM"=>"custom header"));
        $request->setHeaders($customHeader);
        $this->assertEquals($customHeader, $request->getHeaders());
    }
}