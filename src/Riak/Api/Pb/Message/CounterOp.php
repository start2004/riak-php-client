<?php
/**
 * Auto generated from riak_dt.proto at 2016-09-24 09:49:42
 *
 * Start2004\Riak\Api\Pb\Message package
 */

namespace Start2004\Riak\Api\Pb\Message {
/**
 * CounterOp message
 */
class CounterOp extends \ProtobufMessage
{
    /* Field index constants */
    const INCREMENT = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::INCREMENT => array(
            'name' => 'increment',
            'required' => false,
            'type' => 6,
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
        $this->values[self::INCREMENT] = null;
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
     * Sets value of 'increment' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setIncrement($value)
    {
        return $this->set(self::INCREMENT, $value);
    }

    /**
     * Returns value of 'increment' property
     *
     * @return int
     */
    public function getIncrement()
    {
        return $this->get(self::INCREMENT);
    }
}
}