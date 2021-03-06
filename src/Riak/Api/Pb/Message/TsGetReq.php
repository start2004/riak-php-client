<?php
/**
 * Auto generated from riak_ts.proto at 2016-09-24 09:49:42
 *
 * Start2004\Riak\Api\Pb\Message package
 */

namespace Start2004\Riak\Api\Pb\Message {
/**
 * TsGetReq message
 */
class TsGetReq extends \ProtobufMessage
{
    /* Field index constants */
    const TABLE = 1;
    const KEY = 2;
    const TIMEOUT = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::TABLE => array(
            'name' => 'table',
            'required' => true,
            'type' => 7,
        ),
        self::KEY => array(
            'name' => 'key',
            'repeated' => true,
            'type' => '\Start2004\Riak\Api\Pb\Message\TsCell'
        ),
        self::TIMEOUT => array(
            'name' => 'timeout',
            'required' => false,
            'type' => 5,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::TABLE] = null;
        $this->values[self::KEY] = array();
        $this->values[self::TIMEOUT] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'table' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setTable($value)
    {
        return $this->set(self::TABLE, $value);
    }

    /**
     * Returns value of 'table' property
     *
     * @return string
     */
    public function getTable()
    {
        return $this->get(self::TABLE);
    }

    /**
     * Appends value to 'key' list
     *
     * @param \Start2004\Riak\Api\Pb\Message\TsCell $value Value to append
     *
     * @return null
     */
    public function appendKey(\Start2004\Riak\Api\Pb\Message\TsCell $value)
    {
        return $this->append(self::KEY, $value);
    }

    /**
     * Clears 'key' list
     *
     * @return null
     */
    public function clearKey()
    {
        return $this->clear(self::KEY);
    }

    /**
     * Returns 'key' list
     *
     * @return \Start2004\Riak\Api\Pb\Message\TsCell[]
     */
    public function getKey()
    {
        return $this->get(self::KEY);
    }

    /**
     * Returns 'key' iterator
     *
     * @return ArrayIterator
     */
    public function getKeyIterator()
    {
        return new \ArrayIterator($this->get(self::KEY));
    }

    /**
     * Returns element from 'key' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return \Start2004\Riak\Api\Pb\Message\TsCell
     */
    public function getKeyAt($offset)
    {
        return $this->get(self::KEY, $offset);
    }

    /**
     * Returns count of 'key' list
     *
     * @return int
     */
    public function getKeyCount()
    {
        return $this->count(self::KEY);
    }

    /**
     * Sets value of 'timeout' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setTimeout($value)
    {
        return $this->set(self::TIMEOUT, $value);
    }

    /**
     * Returns value of 'timeout' property
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->get(self::TIMEOUT);
    }
}
}