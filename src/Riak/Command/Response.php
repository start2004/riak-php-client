<?php

namespace Start2004\Riak\Command;

/**
 * Data structure for handling Command responses from Riak
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Response
{
    protected $success = false;

    protected $code = '';

    protected $message = '';

    public function __construct($success = true, $code = 0, $message = '')
    {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return bool
     */
    public function isNotFound()
    {
        return 404 === (int)$this->code;
    }

    public function isUnauthorized()
    {
        return 401 === (int)$this->code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
