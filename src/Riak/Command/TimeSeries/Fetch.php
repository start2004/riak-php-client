<?php

namespace Start2004\Riak\Command\TimeSeries;

use Start2004\Riak\Command;
use Start2004\Riak\CommandInterface;

/**
 * Used to fetch data within a TS table
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Fetch extends Command implements CommandInterface
{
    /**
     * Stores the table name
     *
     * @var string|null
     */
    protected $table = null;

    /**
     * Stores the key
     *
     * @var \Start2004\Riak\TimeSeries\Cell[]
     */
    protected $key = [];

    public function __construct(Command\Builder\TimeSeries\FetchRow $builder)
    {
        parent::__construct($builder);

        $this->table = $builder->getTable();
        $this->key = $builder->getKey();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getEncodedData()
    {
        return json_encode($this->getData());
    }

    public function getData()
    {
        return $this->key;
    }
}
