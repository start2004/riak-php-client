<?php

namespace OpenAdapter\Riak\Command\DataType\Hll;

use OpenAdapter\Riak\DataType\Hll;
use OpenAdapter\Riak\Location;

/**
 * Container for a response related to an operation on an hll data type
 *
 * @author Luke Bakken <lbakken@basho.com>
 */
class Response extends \OpenAdapter\Riak\Command\Response
{
    /**
     * @var \OpenAdapter\Riak\DataType\Hll|null
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
     * @throws \OpenAdapter\Riak\Command\Exception
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
     * @throws \OpenAdapter\Riak\Command\Exception
     */
    public function getDate()
    {
        return $this->date;
    }
}
