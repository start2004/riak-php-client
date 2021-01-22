<?php

namespace Start2004\Riak\Tests;

use Start2004\Riak;
use Start2004\Riak\Command;

/**
 * Scenario tests for when Nodes become unreachable
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class NodeUnreachableTest extends TestCase
{
    /**
     * @expectedException \Start2004\Riak\Exception
     */
    public function testUnreachableNode()
    {
        $nodes = $this->getCluster();
        $riak = new Riak([$nodes[0]]);
        $response = (new Command\Builder\Ping($riak))
            ->withConnectionTimeout(1)
            ->build()
            ->execute();

        $this->assertFalse($response);
    }

    /**
     * @expectedException \Start2004\Riak\Exception
     */
    public function testUnreachableNodes()
    {
        $riak = new Riak($this->getCluster());
        $response = (new Command\Builder\Ping($riak))
            ->withConnectionTimeout(1)
            ->build()
            ->execute();

        $this->assertFalse($response);
    }

    /**
     * @expectedException \Start2004\Riak\Exception
     */
    public function testMaxConnections()
    {
        // grab three unreachable nodes
        $nodes = $this->getCluster();

        $riak = new Riak($nodes, ['max_connect_attempts' => 2]);
        $response = (new Command\Builder\Ping($riak))
            ->withConnectionTimeout(1)
            ->build()
            ->execute();

        $this->assertFalse($response);
    }

    public function testReachableNodeInCluster()
    {
        // grab three unreachable nodes
        $nodes = $this->getCluster();

        // replace third one with reachable node
        $nodes[2] = $this->getLocalNode();

        $riak = new Riak($nodes, ['max_connect_attempts' => 3], static::getApiBridgeClass());
        $response = (new Command\Builder\Ping($riak))
            ->withConnectionTimeout(1)
            ->build()
            ->execute();

        $this->assertInstanceOf('Start2004\Riak\Command\Response', $response);
        $this->assertTrue($response->isSuccess());
    }
}
