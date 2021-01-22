<?php

namespace Start2004\Riak\Command\Search\Index;

use Start2004\Riak\Command;
use Start2004\Riak\CommandInterface;

/**
 * Riak Yokozuna Search Index Store
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Store extends Command implements CommandInterface
{
    protected $method = 'PUT';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $schema = '';

    /**
     * @var Command\Response|null
     */
    protected $response = null;

    public function __construct(Command\Builder\Search\StoreIndex $builder)
    {
        parent::__construct($builder);

        $this->name = $builder->getName();
        $this->schema = $builder->getSchema();
    }

    public function getEncodedData()
    {
        return json_encode($this->getData());
    }

    public function getData()
    {
        return ['schema' => $this->schema];
    }

    /**
     * @return Command\Response
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
