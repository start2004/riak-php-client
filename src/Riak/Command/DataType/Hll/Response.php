<?php

namespace Start2004\Riak\Command\DataType\Hll;

use Start2004\Riak\DataType\Hll;
use Start2004\Riak\Location;

/**
 * Container for a response related to an operation on an hll data type
 *
 * @author Luke Bakken <lbakken@basho.com>
 */
class Response extends \Start2004\Riak\Command\Response
{
    /**
     * @var \Start2004\Riak\DataType\Hll|null
     */
    protected $hll = null;

    public function __construct($success = true, $code = 0, $message = '', $location = null, $hll = null, $date = '')
    {
        parent::__construct($success, $code, $message);

        $this->hll = $hll;
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
     * @return Hll|null
     */
    public function getHll()
    {
        return $this->hll;
    }

    /**
     * Retrieves the date of the hll's retrieval
     *
     * @return string
     * @throws \Start2004\Riak\Command\Exception
     */
    public function getDate()
    {
        return $this->date;
    }
}
