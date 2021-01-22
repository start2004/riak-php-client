<?php

namespace Start2004\Riak\Tests\Riak\Command\Builder;

use Start2004\Riak\Command;
use Start2004\Riak\Tests\TestCase;

/**
 * Tests the configuration of Riak commands via the Command Builder class
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class UpdateSetTest extends TestCase
{
    /**
     * Test command builder construct
     */
    public function testStoreWithKey()
    {
        // build an object
        $builder = new Command\Builder\UpdateSet(static::$riak);
        $builder->add('some_element');
        $builder->remove('some_other_element');
        $builder->buildLocation('some_key', 'some_bucket');
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\DataType\Set\Store', $command);
        $this->assertInstanceOf('Start2004\Riak\Bucket', $command->getBucket());
        $this->assertInstanceOf('Start2004\Riak\Location', $command->getLocation());
        $this->assertEquals('some_bucket', $command->getBucket()->getName());
        $this->assertEquals('default', $command->getBucket()->getType());
        $this->assertEquals('some_key', $command->getLocation()->getKey());
        $this->assertEquals(['add_all' => ['some_element'], 'remove_all' => ['some_other_element']], $command->getData());
        $this->assertEquals(json_encode(['add_all' => ['some_element'], 'remove_all' => ['some_other_element']]), $command->getEncodedData());
    }

    /**
     * Test command builder construct
     */
    public function testStoreWithOutKey()
    {
        // build an object
        $builder = new Command\Builder\UpdateSet(static::$riak);
        $builder->add('some_element');
        $builder->buildBucket('some_bucket');
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\DataType\Set\Store', $command);
        $this->assertEquals('some_bucket', $command->getBucket()->getName());
        $this->assertEquals(['add_all' => ['some_element'], 'remove_all' => []], $command->getData());
        $this->assertEquals(json_encode(['add_all' => ['some_element'], 'remove_all' => []]), $command->getEncodedData());
    }

    /**
     * Tests validate properly verifies that an intended change is not applied
     *
     * @expectedException \Start2004\Riak\Command\Builder\Exception
     */
    public function testValidateObject()
    {
        $builder = new Command\Builder\UpdateSet(static::$riak);
        $builder->buildBucket('some_bucket');
        $builder->build();
    }

    /**
     * Tests validate properly verifies the Bucket is not there
     *
     * @expectedException \Start2004\Riak\Command\Builder\Exception
     */
    public function testValidateBucket()
    {
        $builder = new Command\Builder\UpdateSet(static::$riak);
        $builder->add('some_element');
        $builder->build();
    }

    /**
     * Tests validate properly verifies that remove commands require the context
     *
     * @expectedException \Start2004\Riak\Command\Builder\Exception
     */
    public function testValidateRemove()
    {
        $builder = new Command\Builder\UpdateSet(static::$riak);
        $builder->remove('some_element');
        $builder->build();
    }
}
