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
class DeleteRowTest extends TestCase
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
    public function testDelete()
    {
        // initialize builder
        $builder = (new Command\Builder\TimeSeries\DeleteRow(static::$riak))
            ->atKey(static::$key)
            ->inTable(static::$table);

        // build a command
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\TimeSeries\Delete', $command);
        $this->assertEquals(static::$table, $command->getTable());
        $this->assertEquals(static::$key, $command->getData());
        $this->assertEquals("region/South%20Atlantic/state/South%20Carolina/time/1443816900", implode("/", $command->getData()));

        // change the key and reuse builder to create new command
        $key = static::$key;
        $key[2]->setTimestampValue(1443816901);
        $command = $builder->atKey($key)->build();

        $this->assertEquals("region/South%20Atlantic/state/South%20Carolina/time/1443816901", implode("/", $command->getData()));
    }
}
