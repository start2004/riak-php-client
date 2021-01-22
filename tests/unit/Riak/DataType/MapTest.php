<?php

namespace Start2004\Riak\Tests\Riak;

use Start2004\Riak\DataType\Map;

/**
 * Test set for counter crdt
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class MapTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertEquals('map', Map::TYPE);

        $crdt = new Map([], '');
        $this->assertEquals('map', $crdt->getType());
    }
}
