<?php

namespace Start2004\Riak\Tests;

use Start2004\Riak\Command;

/**
 * Functional tests related to Key-Value objects
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class ObjectOperationsTest extends TestCase
{
    private static $key = '';

    /**
     * @var \Start2004\Riak\DataObject|null
     */
    private static $object = null;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // make completely random key based on time
        static::$key = md5(rand(0, 99) . time());
    }

    public function testStoreNewWithoutKey()
    {
        // build an object
        $command = (new Command\Builder\StoreObject(static::$riak))
            ->buildObject('some_data')
            ->buildBucket('users')
            ->build();

        $response = $command->execute();

        // expects 201 - Created
        $this->assertEquals('201', $response->getCode());
        $this->assertNotEmpty($response->getLocation());
        $this->assertInstanceOf('\Start2004\Riak\Location', $response->getLocation());
    }

    public function testFetchNotFound()
    {
        $command = (new Command\Builder\FetchObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();

        $this->assertEquals('404', $response->getCode());
    }

    /**
     * @depends      testFetchNotFound
     */
    public function testStoreNewWithKey()
    {
        $command = (new Command\Builder\StoreObject(static::$riak))
            ->buildObject('some_data')
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();

        // expects 204 - No Content
        // this is wonky, its not 201 because the key may have been generated on another node
        $this->assertEquals('204', $response->getCode());
        $this->assertEmpty($response->getLocation());
    }

    /**
     * @depends      testStoreNewWithKey
     */
    public function testFetchOk()
    {
        $command = (new Command\Builder\FetchObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();

        $this->assertEquals('200', $response->getCode());
        $this->assertInstanceOf('Start2004\Riak\DataObject', $response->getDataObject());
        $this->assertEquals('some_data', $response->getDataObject()->getData());
        $this->assertNotEmpty($response->getDataObject()->getVclock());

        // confirm we are using the HTTP api bridge
        if (static::$riak->getApi() instanceof \Start2004\Riak\Api\Http) {
            $headers = static::$riak->getApi()->getResponseHeaders();
            $this->assertNotEmpty($headers);
            $this->assertNotEmpty($headers["Last-Modified"]);
            $this->assertNotEmpty(new \DateTime($headers["Last-Modified"]));
        }

        static::$object = $response->getDataObject();
    }

    /**
     * @depends      testFetchOk
     */
    public function testStoreExisting()
    {
        $object = static::$object;

        $object->setData('some_new_data');

        $command = (new Command\Builder\StoreObject(static::$riak))
            ->withObject($object)
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();

        // 204 - No Content
        $this->assertEquals('204', $response->getCode());
    }

    /**
     * @depends      testStoreExisting
     */
    public function testDelete()
    {
        $command = (new Command\Builder\DeleteObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();

        $this->assertEquals('204', $response->getCode());
    }

    /**
     * @depends      testDelete
     */
    public function testFetchDeleted()
    {
        $command = (new Command\Builder\FetchObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();

        $this->assertEquals('404', $response->getCode());

        // deleted keys leave behind a tombstone with their causal context, aka vclock unless delete_immediate = 1
        //$this->assertNotEmpty($response->getVclock());
    }

    public function testListKeys()
    {
        $bucket = 'list-keys-php';
        $keys = ['key1', 'key2', 'key3', 'key4', 'key5'];

        $builder = (new Command\Builder\StoreObject(static::$riak))
            ->buildObject(true);

        foreach ($keys as $key) {
            $builder->buildLocation($key, $bucket)->build()->execute();
        }

        $response = (new Command\Builder\ListObjects(static::$riak))
            ->buildBucket($bucket)
            ->acknowledgeRisk(true)
            ->build()
            ->execute();

        $this->assertTrue($response->getKeys() >= count($keys));

        $found = [];
        foreach ($response->getKeys() as $location) {
            if (in_array($location->getKey(), $keys)) {
                $found[$location->getKey()] = 1;
            }
        }

        $this->assertEquals(count($found), count($keys));
    }

    public function testFetchAssociativeArray()
    {
        $data = ['myData' => 42];

        $command = (new Command\Builder\StoreObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->buildJsonObject($data)
            ->build();

        $response = $command->execute();

        $this->assertEquals('204', $response->getCode());

        // Fetch as associative array
        $command = (new Command\Builder\FetchObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->withDecodeAsAssociative()
            ->build();

        $response = $command->execute();
        $this->assertEquals('200', $response->getCode());
        $this->assertEquals($data, $response->getDataObject()->getData());
        $this->assertEquals('array', gettype($response->getDataObject()->getData()));

        // Fetch normal to get as stdClass object
        $command = (new Command\Builder\FetchObject(static::$riak))
            ->buildLocation(static::$key, 'users')
            ->build();

        $response = $command->execute();
        $this->assertEquals('200', $response->getCode());
        $this->assertEquals('object', gettype($response->getDataObject()->getData()));
    }
}
