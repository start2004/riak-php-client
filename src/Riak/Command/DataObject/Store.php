<?php

namespace OpenAdapter\Riak\Command\DataObject;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;

/**
 * Riak key value object store
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Store extends Command\DataObject implements CommandInterface
{
    /**
     * Type of operation
     *
     * @var string
     */
    protected $method = 'POST';

    public function __construct(Command\Builder\StoreObject $builder)
    {
        parent::__construct($builder);

        $this->object = $builder->getDataObject();
        $this->bucket = $builder->getBucket();
        $this->location = $builder->getLocation();
        $this->decodeAsAssociative = $builder->getDecodeAsAssociative();

        if ($this->location) {
            $this->method = 'PUT';
        }
    }

}
