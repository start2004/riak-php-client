<?php

namespace Start2004\Riak\Tests;

use Start2004\Riak;

/**
 * Main class for testing Riak clustering
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class RiakTest extends TestCase
{
    public function testNodeCount()
    {
        $nodes = static::getCluster();
        $riak = new Riak($nodes);
        $this->assertEquals(count($riak->getNodes()), count($nodes));
    }

    public function testConfig()
    {
        $nodes = static::getCluster();
        $riak = new Riak($nodes, ['max_connect_attempts' => 5]);
        $this->assertEquals(5, $riak->getConfigValue('max_connect_attempts'));
    }

    public function testPickNode()
    {
        $nodes = static::getCluster();
        $riak = new Riak($nodes);
        $this->assertNotFalse($riak->getActiveNodeIndex());
        $this->assertInstanceOf('Start2004\Riak\Node', $riak->getActiveNode());
    }

    public function testApi()
    {
        $nodes = static::getCluster();
        $riak = new Riak($nodes);
        $this->assertInstanceOf('Start2004\Riak\Api', $riak->getApi());
    }
}
