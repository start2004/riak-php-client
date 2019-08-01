<?php

namespace OpenAdapter\Riak\Tests\Riak\Search;

use OpenAdapter\Riak\Search\Doc;
use PHPUnit\Framework\TestCase as TestCase;

/**
 * Search result document test
 *
 * @author Michael Mayer <michael@lastzero.net>
 */
class DocTest extends TestCase
{
    /**
     * @var Doc
     */
    protected $doc;

    public function setUp()
    {
        $data = new \stdClass();
        $data->yzId = '1*tests*test*5*39';
        $data->yzRk = '5';
        $data->yzRt = 'tests';
        $data->yzRb = 'test';
        $data->foo = 'bar';
        $data->_status = 200;
        $this->doc = new Doc($data);
    }

    public function testGetLocation()
    {
        $result = $this->doc->getLocation();
        $this->assertInstanceOf('\OpenAdapter\Riak\Location', $result);
        $this->assertInstanceOf('\OpenAdapter\Riak\Bucket', $result->getBucket());
        $this->assertEquals('tests', $result->getBucket()->getType());
        $this->assertEquals('test', $result->getBucket()->getName());
        $this->assertEquals('5', $result->getKey());
    }

    public function testGetData()
    {
        $result = $this->doc->getData();
        $this->assertInternalType('array', $result);
        $this->assertEquals('bar', $result['foo']);
        $this->assertEquals(200, $result['_status']);
    }

    public function testMagicGetter()
    {
        $this->assertEquals('bar', $this->doc->foo);
        $this->assertEquals(200, $this->doc->_status);
    }
}
