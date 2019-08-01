<?php

namespace OpenAdapter\Riak\Command\DataType\Hll;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;
use OpenAdapter\Riak\Location;

/**
 * Fetches an Hll data type from Riak
 *
 * @author Luke Bakken <lbakken@basho.com>
 */
class Fetch extends Command implements CommandInterface
{
    /**
     * @var Command\DataType\Hll\Response|null
     */
    protected $response = null;

    /**
     * @var Location|null
     */
    protected $location = null;

    public function __construct(Command\Builder\FetchHll $builder)
    {
        parent::__construct($builder);

        $this->bucket = $builder->getBucket();
        $this->location = $builder->getLocation();
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getData()
    {
        return '';
    }

    public function getEncodedData()
    {
        return '';
    }

    /**
     * @return Command\DataType\Hll\Response
     */
    public function execute()
    {
        return parent::execute();
    }
}
