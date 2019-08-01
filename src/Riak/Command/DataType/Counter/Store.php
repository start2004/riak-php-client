<?php

namespace OpenAdapter\Riak\Command\DataType\Counter;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;
use OpenAdapter\Riak\Location;


/**
 * Stores a write operation to a CRDT counter
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Store extends Command implements CommandInterface
{
    protected $method = 'POST';

    /**
     * @var int
     */
    protected $increment = 0;

    /**
     * @var Command\DataType\Counter\Response|null
     */
    protected $response = null;

    /**
     * @var Location|null
     */
    protected $location = null;

    public function __construct(Command\Builder\IncrementCounter $builder)
    {
        parent::__construct($builder);

        $this->increment = $builder->getIncrement();
        $this->bucket = $builder->getBucket();
        $this->location = $builder->getLocation();
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getEncodedData()
    {
        return json_encode($this->getData());
    }

    public function getData()
    {
        return ['increment' => $this->increment];
    }

    /**
     * @return Command\DataType\Counter\Response
     */
    public function execute()
    {
        return parent::execute();
    }
}
