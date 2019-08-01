<?php

namespace OpenAdapter\Riak\Tests\Riak;

use OpenAdapter\Riak\DataType\Map;

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
