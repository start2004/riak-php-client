<?php

namespace Start2004\Riak\Tests\Riak\Command\Builder;

use Start2004\Riak\Api\Http;
use Start2004\Riak\Command;
use Start2004\Riak\Tests\TestCase;

/**
 * Tests the configuration of Riak commands via the Command Builder class
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class StoreObjectTest extends TestCase
{
    /**
     * Test command builder construct
     */
    public function testStoreWithKey()
    {
        // build an object
        $builder = new Command\Builder\StoreObject(static::$riak);
        $builder->buildObject('some_data');
        $builder->buildLocation('some_key', 'some_bucket');
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\DataObject\Store', $command);
        $this->assertInstanceOf('Start2004\Riak\DataObject', $command->getDataObject());
        $this->assertInstanceOf('Start2004\Riak\Bucket', $command->getBucket());
        $this->assertInstanceOf('Start2004\Riak\Location', $command->getLocation());
        $this->assertEquals('some_bucket', $command->getBucket()->getName());
        $this->assertEquals('default', $command->getBucket()->getType());
        $this->assertEquals('some_key', $command->getLocation()->getKey());
    }

    /**
     * Test command builder construct
     */
    public function testStoreWithOutKey()
    {
        // build an object
        $builder = new Command\Builder\StoreObject(static::$riak);
        $builder->buildObject('some_data');
        $builder->buildBucket('some_bucket');
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\DataObject\Store', $command);
        $this->assertEquals('some_bucket', $command->getBucket()->getName());
    }

    /**
     * Tests validate properly verifies the Object is not there
     *
     * @expectedException \Start2004\Riak\Command\Builder\Exception
     */
    public function testValidateObject()
    {
        $builder = new Command\Builder\StoreObject(static::$riak);
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
        $builder = new Command\Builder\StoreObject(static::$riak);
        $builder->buildObject('some_data');
        $builder->build();
    }

    /**
     * Tests that attempting to store an object generates headers for any
     * 2i entries on the object.
     */
    public function testStoreObjectWithIndexGeneratesHeaders()
    {
        $inputHeaders = [Http::METADATA_PREFIX . 'My-Header' => 'cats', 'x-riak-index-foo_bin' => 'bar, baz', 'x-riak-index-foo_int' => '42, 50'];
        $builder = new Command\Builder\StoreObject(static::$riak);
        $builder->buildObject('some_data', $inputHeaders);
        $builder->buildBucket('some_bucket');
        $command = $builder->build();

        $this->assertInstanceOf('Start2004\Riak\Command\DataObject\Store', $command);

        $this->assertArrayHasKey('My-Header', $command->getDataObject()->getMetaData());
        $this->assertEquals($command->getDataObject()->getMetaData()['My-Header'], 'cats');

        $this->assertArrayHasKey('foo_bin', $command->getDataObject()->getIndexes());
        $this->assertCount(2, $command->getDataObject()->getIndex('foo_bin'));

        $this->assertArrayHasKey('foo_int', $command->getDataObject()->getIndexes());
        $this->assertCount(2, $command->getDataObject()->getIndex('foo_int'));
    }
}
