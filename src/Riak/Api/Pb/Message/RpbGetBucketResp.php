<?php
/**
 * Auto generated from riak.proto at 2016-09-24 09:49:42
 *
 * Start2004\Riak\Api\Pb\Message package
 */

namespace Start2004\Riak\Api\Pb\Message {
/**
 * RpbGetBucketResp message
 */
class RpbGetBucketResp extends \ProtobufMessage
{
    /* Field index constants */
    const PROPS = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::PROPS => array(
            'name' => 'props',
            'required' => true,
            'type' => '\Start2004\Riak\Api\Pb\Message\RpbBucketProps'
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
        $this->values[self::PROPS] = null;
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
     * Sets value of 'props' property
     *
     * @param \Start2004\Riak\Api\Pb\Message\RpbBucketProps $value Property value
     *
     * @return null
     */
    public function setProps(\Start2004\Riak\Api\Pb\Message\RpbBucketProps $value)
    {
        return $this->set(self::PROPS, $value);
    }

    /**
     * Returns value of 'props' property
     *
     * @return \Start2004\Riak\Api\Pb\Message\RpbBucketProps
     */
    public function getProps()
    {
        return $this->get(self::PROPS);
    }
}
}