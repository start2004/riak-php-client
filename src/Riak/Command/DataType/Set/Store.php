<?php

namespace OpenAdapter\Riak\Command\DataType\Set;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;
use OpenAdapter\Riak\Location;

/**
 * Stores a write update to a set
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Store extends Command implements CommandInterface
{
    protected $method = 'POST';

    /**
     * @var array
     */
    protected $add_all = [];

    /**
     * @var array
     */
    protected $remove_all = [];

    /**
     * @var Command\DataType\Set\Response|null
     */
    protected $response = null;

    /**
     * @var Location|null
     */
    protected $location = null;

    public function __construct(Command\Builder\UpdateSet $builder)
    {
        parent::__construct($builder);

        $this->add_all = $builder->getAddAll();
        $this->remove_all = $builder->getRemoveAll();
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
        return ['add_all' => $this->add_all, 'remove_all' => $this->remove_all];
    }

    /**
     * @return Command\DataType\Set\Response
     */
    public function execute()
    {
        return parent::execute();
    }
}
