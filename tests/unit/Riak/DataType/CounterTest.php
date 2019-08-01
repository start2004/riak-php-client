<?php

namespace OpenAdapter\Riak\Tests\Riak;

use OpenAdapter\Riak\DataType\Counter;

/**
 * Test set for counter crdt
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class CounterTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertEquals('counter', Counter::TYPE);

        $crdt = new Counter(1);
        $this->assertEquals('counter', $crdt->getType());
    }
}
