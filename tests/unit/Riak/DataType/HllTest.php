<?php

namespace OpenAdapter\Riak\Tests\Riak;

use OpenAdapter\Riak\DataType\Hll;

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
