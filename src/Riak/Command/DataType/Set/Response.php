<?php

namespace OpenAdapter\Riak\Command\DataType\Set;

use OpenAdapter\Riak\DataType\Set;
use OpenAdapter\Riak\Location;

/**
 * Container for a response related to an operation on a set data type
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \OpenAdapter\Riak\Command\Response
{
    /**
     * @var \OpenAdapter\Riak\DataType\Set|null
     */
    protected $set = null;

    public function __construct($success = true, $code = 0, $message = '', $location = null, $set = null, $date = '')
    {
        parent::__construct($success, $code, $message);

        $this->set = $set;
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
     * @return Set|null
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * Retrieves the date of the counter's retrieval
     *
     * @return string
     * @throws \OpenAdapter\Riak\Command\Exception
     */
    public function getDate()
    {
        return $this->date;
    }
}
