<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Vongola\InsightVmApi\Models\Base\Client;
use Vongola\InsightVmApi\Models\Root;

class ClientTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        // your code goes here
    }

    protected function tearDown()
    {
        parent::tearDown();
        // your code goes here
    }

    public function testRoot()
    {
        $root = Client::getInstance()->root();
        assertTrue(get_class($root), Root::class);
    }
}