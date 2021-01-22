<?php

namespace Start2004\Riak\Command\DataObject\Keys;

use Start2004\Riak\Command;
use Start2004\Riak\CommandInterface;

/**
 * Lists Riak Kv Object keys
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Fetch extends Command\DataObject implements CommandInterface
{
    public function __construct(Command\Builder\ListObjects $builder)
    {
        parent::__construct($builder);

        $this->parameters['keys'] = 'true';
        $this->bucket = $builder->getBucket();
        $this->decodeAsAssociative = $builder->getDecodeAsAssociative();
    }
}
