<?php

namespace Start2004\Riak\Command\Search\Index;

use Start2004\Riak\Command;
use Start2004\Riak\CommandInterface;

/**
 * Used to fetch a search index from Riak
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Fetch extends Command implements CommandInterface
{
    /**
     * @var Command\Search\Index\Response|null
     */
    protected $response = null;

    protected $name;

    public function __construct(Command\Builder\Search\FetchIndex $builder)
    {
        parent::__construct($builder);

        $this->name = $builder->getIndexName();
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
     * @return Command\Search\Index\Response
     */
    public function execute()
    {
        return parent::execute();
    }

    public function __toString()
    {
        return $this->name;
    }
}
