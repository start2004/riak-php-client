<?php

namespace Start2004\Riak\Command\Search\Schema;

use Start2004\Riak\Command;
use Start2004\Riak\CommandInterface;

/**
 * Class Fetch
 *
 * Used to fetch a counter
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Fetch extends Command implements CommandInterface
{
    /**
     * @var Command\Search\Schema\Response|null
     */
    protected $response = null;

    protected $name;

    public function __construct(Command\Builder\Search\FetchSchema $builder)
    {
        parent::__construct($builder);

        $this->name = $builder->getSchemaName();
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
     * @return Command\Search\Schema\Response
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
