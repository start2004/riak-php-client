<?php

namespace Start2004\Riak\Tests\Riak\Command\Builder;

use Start2004\Riak\Command;
use Start2004\Riak\Tests\TestCase;

/**
 * Tests the configuration of Riak commands via the Command Builder class
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class FetchSetTest extends TestCase
{
    /**
     * Test command builder construct
     */
    public function testFetch()
    {
        // build an object
        $builder = new Command\Builder\FetchSet(static::$riak);
        $builder->buildLocation('some_key', 'some_bucket');
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\DataType\Set\Fetch', $command);
        $this->assertInstanceOf('Start2004\Riak\Bucket', $command->getBucket());
        $this->assertInstanceOf('Start2004\Riak\Location', $command->getLocation());
        $this->assertEquals('some_bucket', $command->getBucket()->getName());
        $this->assertEquals('default', $command->getBucket()->getType());
        $this->assertEquals('some_key', $command->getLocation()->getKey());

        $builder->buildLocation('some_key', 'some_bucket', 'some_type');
        $command = $builder->build();

        $this->assertEquals('some_type', $command->getBucket()->getType());
    }

    /**
     * Tests validate properly verifies the Location is not there
     *
     * @expectedException \Start2004\Riak\Command\Builder\Exception
     */
    public function testValidateLocation()
    {
        $builder = new Command\Builder\FetchSet(static::$riak);
        $builder->buildBucket('some_bucket');
        $builder->build();
    }
}
