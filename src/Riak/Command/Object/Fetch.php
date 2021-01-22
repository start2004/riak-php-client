<?php

namespace OpenAdapter\Riak\Command\Object;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;

/**
 * Fetches a Riak Kv Object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Fetch extends Command\Object implements CommandInterface
{
    public function __construct(Command\Builder\FetchObject $builder)
    {
        parent::__construct($builder);

        $this->bucket = $builder->getBucket();
        $this->location = $builder->getLocation();
        $this->decodeAsAssociative = $builder->getDecodeAsAssociative();
    }
}
