<?php

namespace Start2004\Riak\Command\Stats;

/**
 * Container for a response related to an operation on an object
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response extends \Start2004\Riak\Command\Response
{
    protected $stats = [];

    public function __construct($success = true, $code = 0, $message = '', $data = [])
    {
        parent::__construct($success, $code, $message);

        $this->stats = $data;
    }

    public function __isset($name)
    {
        if (isset($this->stats[$name])) {
            return true;
        }

        return false;
    }

    public function __set($name, $value)
    {
        $this->stats[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->stats[$name])) {
            return $this->stats[$name];
        }

        return null;
    }

    public function getAllStats()
    {
        return $this->stats;
    }
}
