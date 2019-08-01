<?php

namespace OpenAdapter\Riak\Tests\Riak;

use OpenAdapter\Riak\DataType\Set;

/**
 * Test set for set crdt
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class SetTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertEquals('set', Set::TYPE);

        $crdt = new Set([], '');
        $this->assertEquals('set', $crdt->getType());

    }
}
