<?php

namespace Start2004\Riak\Command\DataObject\Keys;

/**
 * Container for a response related to an operation on an object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \Start2004\Riak\Command\Response
{
    /**
     * @var \Start2004\Riak\Location[]
     */
    protected $keys = [];

    public function __construct($success = true, $code = 0, $message = '', $keys = [])
    {
        parent::__construct($success, $code, $message);

        $this->keys = $keys;
    }

    /**
     * Fetches the keys from the response
     *
     * @return \Start2004\Riak\Location[]
     */
    public function getKeys()
    {
        return $this->keys;
    }
}
