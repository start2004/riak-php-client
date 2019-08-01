<?php

namespace OpenAdapter\Riak\Command\Builder\TimeSeries;

use OpenAdapter\Riak;
use OpenAdapter\Riak\Command;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Query extends Command\Builder implements Command\BuilderInterface
{
    protected $query = '';
    protected $interps = [];

    public function __construct(Riak $riak)
    {
        parent::__construct($riak);
    }

    /**
     * TimeSeries SQL'ish query
     *
     * @param $query
     *
     * @return $this
     */
    public function withQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getInterps()
    {
        return $this->interps;
    }

    /**
     * {@inheritdoc}
     *
     * @return Command\TimeSeries\Store
     * @throws Command\Builder\Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\TimeSeries\Query\Fetch($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Query');
    }
}
