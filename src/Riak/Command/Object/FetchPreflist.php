<?php

namespace Start2004\Riak\Command\Object;

use Start2004\Riak\Command;

use Start2004\Riak\CommandInterface;

/**
 * Fetches the Preflist for a Riak Kv Object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class FetchPreflist extends Command\Object implements CommandInterface
{
    public function __construct(Command\Builder\FetchPreflist $builder)
    {
        parent::__construct($builder);

        $this->bucket = $builder->getBucket();
        $this->location = $builder->getLocation();
    }
}
