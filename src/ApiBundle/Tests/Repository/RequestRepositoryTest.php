<?php

namespace ApiBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RequestRepositoryTest extends WebTestCase
{
    const TEST_ROUTE = 'first';
    const TEST_IP = '127.0.0.1';
    const TEST_METHOD = 'POST';
    const TEST_LAST_DAYS = '10';
    const TEST_SEARCH = 'test';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * Testing find requests
     */
    public function testFindRequest()
    {
        $method = $this->em
            ->getRepository('ApiBundle:Request')
            ->findRequest(array('method' => self::TEST_METHOD))
        ;
        $this->assertEquals(self::TEST_METHOD, $method[0]->getMethod());
    }
}