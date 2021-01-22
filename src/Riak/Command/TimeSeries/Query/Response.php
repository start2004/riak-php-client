<?php

namespace Start2004\Riak\Command\TimeSeries\Query;

use Start2004\Riak\Command;

/**
 * Response object for TS Fetch, Store, Delete
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends Command\Response
{
    protected $results = [];

    public function __construct($success = true, $code = 0, $message = '', $results = [])
    {
        parent::__construct($success, $code, $message);

        $this->results = $results;
    }

    /**
     * @return \Start2004\Riak\TimeSeries\Cell[]|null
     */
    public function getResult()
    {
        return !empty($this->results[0]) ? $this->results[0] : null;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }
}
