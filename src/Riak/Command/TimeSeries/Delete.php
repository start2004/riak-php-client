<?php

namespace OpenAdapter\Riak\Command\TimeSeries;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;

/**
 * Used to fetch data within a TS table
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Delete extends Command implements CommandInterface
{
    /**
     * @var string
     */
    protected $method = 'DELETE';

    /**
     * Stores the table name
     *
     * @var string|null
     */
    protected $table = null;

    /**
     * Stores the key
     *
     * @var \OpenAdapter\Riak\TimeSeries\Cell[]
     */
    protected $key = [];

    public function __construct(Command\Builder\TimeSeries\DeleteRow $builder)
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
