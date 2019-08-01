<?php

namespace OpenAdapter\Riak\Command\DataObject\Keys;

/**
 * Container for a response related to an operation on an object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \OpenAdapter\Riak\Command\Response
{
    /**
     * @var \OpenAdapter\Riak\Location[]
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
     * @return \OpenAdapter\Riak\Location[]
     */
    public function getKeys()
    {
        return $this->keys;
    }
}
