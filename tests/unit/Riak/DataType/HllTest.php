<?php

namespace Start2004\Riak\Tests\Riak;

use Start2004\Riak\DataType\Hll;

/**
 * Test for HyperLogLog CRDT
 *
 * @author Luke Bakken <lbakken@basho.com>
 */
class HllTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertEquals('hll', Hll::TYPE);

        $crdt = new Hll([], '');
        $this->assertEquals('hll', $crdt->getType());
    }
}
