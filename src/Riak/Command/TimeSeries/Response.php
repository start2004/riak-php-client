<?php

namespace Start2004\Riak\Command\TimeSeries;

use Start2004\Riak\Command;

/**
 * Response object for TS Fetch, Store, Delete
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends Command\Response
{
    protected $rows = [];

    public function __construct($success = true, $code = 0, $message = '', $rows = [])
    {
        parent::__construct($success, $code, $message);

        $this->rows = $rows;
    }

    /**
     * @return \Start2004\Riak\TimeSeries\Cell[]|null
     */
    public function getRow()
    {
        return !empty($this->rows[0]) ? $this->rows[0] : null;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }
}
