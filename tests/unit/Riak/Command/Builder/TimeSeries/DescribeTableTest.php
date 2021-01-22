<?php

namespace Start2004\Riak\Tests\Riak\Command\Builder;

use Start2004\Riak\Command;
use Start2004\Riak\Tests\TestCase;
use Start2004\Riak\Tests\TimeSeriesTrait;

/**
 * Tests the configuration of Riak commands via the Command Builder class
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class DescribeTableTest extends TestCase
{
    use TimeSeriesTrait;

    /**
     * Test command builder construct
     */
    public function testDescribeTable()
    {
        // initialize builder
        $builder = (new Command\Builder\TimeSeries\DescribeTable(static::$riak))
            ->withTable(static::$table);

        // build a command
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\TimeSeries\Query\Fetch', $command);
        $this->assertEquals("DESCRIBE " . static::$table, $command->getData()["query"]);
    }
}
