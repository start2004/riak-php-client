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
class StoreRowTest extends TestCase
{
    use TimeSeriesTrait;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::populateKey();
    }

    /**
     * Test command builder construct
     */
    public function testStoreSingle()
    {
        $row = static::generateRow();

        // initialize builder
        $builder = (new Command\Builder\TimeSeries\StoreRows(static::$riak))
            ->inTable(static::$table)
            ->withRow($row);

        // build a command
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\TimeSeries\Store', $command);
        $this->assertEquals(static::$table, $command->getTable());
        $this->assertEquals([$row], $command->getData());
    }

    /**
     * Test command builder construct
     */
    public function testStoreMany()
    {
        $rows = static::generateRows();

        // initialize builder
        $builder = (new Command\Builder\TimeSeries\StoreRows(static::$riak))
            ->inTable(static::$table)
            ->withRows($rows);

        // build a command
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\TimeSeries\Store', $command);
        $this->assertEquals(static::$table, $command->getTable());
        $this->assertEquals($rows, $command->getData());
    }

    /**
     * @expectedException Start2004\Riak\Command\Builder\Exception
     */
    public function testEmptyRowsException()
    {
        // initialize builder
        $builder = (new Command\Builder\TimeSeries\StoreRows(static::$riak))
            ->inTable(static::$table);

        // build a command
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\TimeSeries\Store', $command);
        $this->assertEquals(static::$table, $command->getTable());
        $this->assertEquals($rows, $command->getData());
    }
}
