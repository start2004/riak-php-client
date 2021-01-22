<?php

namespace Start2004\Riak\Command\DataObject;

use Start2004\Riak\Location;

/**
 * Container for a response related to an operation on an object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \Start2004\Riak\Command\Response
{
    /**
     * @var \Start2004\Riak\DataObject[]
     */
    protected $objects = [];

    protected $location = null;

    public function __construct($success = true, $code = 0, $message = '', $location = null, $objects = [])
    {
        parent::__construct($success, $code, $message);

        $this->objects = $objects;
        $this->location = $location;
    }

    /**
     * @return bool
     */
    public function hasSiblings()
    {
        return \count($this->objects) > 1;
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
     * @return \Start2004\Riak\DataObject|null
     */
    public function getDataObject()
    {
        return !empty($this->objects[0]) ? $this->objects[0] : null;
    }

    /**
     * Fetches the sibling tags from the response
     *
     * @return array
     */
    public function getSiblings()
    {
        return $this->objects;
    }
}
