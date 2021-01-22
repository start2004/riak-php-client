<?php

namespace Start2004\Riak\Command\Object;

use Start2004\Riak\Api\Http\Translators\SecondaryIndexHeaderTranslator;
use Start2004\Riak\Command;
use Start2004\Riak\CommandInterface;

/**
 * Riak key value object store
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Store extends Command\Object implements CommandInterface
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

        $this->object = $builder->getObject();
        $this->bucket = $builder->getBucket();
        $this->location = $builder->getLocation();
        $this->decodeAsAssociative = $builder->getDecodeAsAssociative();

        if ($this->location) {
            $this->method = 'PUT';
        }
    }
}
