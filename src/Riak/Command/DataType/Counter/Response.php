<?php

namespace Start2004\Riak\Command\DataType\Counter;

use Start2004\Riak\DataType\Counter;
use Start2004\Riak\Location;

/**
 * Container for a response related to an operation on an object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \Start2004\Riak\Command\Response
{
    /**
     * @var \Start2004\Riak\DataType\Counter|null
     */
    protected $counter = null;

    /**
     * @var Location
     */
    protected $location = null;

    /**
     * @var string
     */
    protected $date = '';

    public function __construct($success = true, $code = 0, $message = '', $location = null, $counter = null, $date = '')
    {
        parent::__construct($success, $code, $message);

        $this->counter = $counter;
        $this->location = $location;
        $this->date = $date;
    }

    /**
     * Retrieves the Location value from the response headers
     *
     * @return Location
     * @throws \Start2004\Riak\Command\Exception
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return Counter|null
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * Retrieves the date of the counter's retrieval
     *
     * @return string
     * @throws \Start2004\Riak\Command\Exception
     */
    public function getDate()
    {
        return $this->date;
    }
}
