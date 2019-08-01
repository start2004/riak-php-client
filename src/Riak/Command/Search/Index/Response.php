<?php

namespace OpenAdapter\Riak\Command\Search\Index;

/**
 * Container for a response related to an operation on an object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \OpenAdapter\Riak\Command\Response
{
    /**
     * @var \stdClass|null
     */
    protected $index = null;

    public function __construct($success = true, $code = 0, $message = '', $index = null)
    {
        parent::__construct($success, $code, $message);

        $this->index = $index;
    }

    public function getIndex()
    {
        return $this->index;
    }
}
