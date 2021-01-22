<?php
/**
 * Auto generated from riak_yokozuna.proto at 2016-09-24 09:49:42
 *
 * Start2004\Riak\Api\Pb\Message package
 */

namespace Start2004\Riak\Api\Pb\Message {
/**
 * RpbYokozunaSchemaPutReq message
 */
class RpbYokozunaSchemaPutReq extends \ProtobufMessage
{
    /* Field index constants */
    const SCHEMA = 1;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::SCHEMA => array(
            'name' => 'schema',
            'required' => true,
            'type' => '\Start2004\Riak\Api\Pb\Message\RpbYokozunaSchema'
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
        $this->values[self::SCHEMA] = null;
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
     * Sets value of 'schema' property
     *
     * @param \Start2004\Riak\Api\Pb\Message\RpbYokozunaSchema $value Property value
     *
     * @return null
     */
    public function setSchema(\Start2004\Riak\Api\Pb\Message\RpbYokozunaSchema $value)
    {
        return $this->set(self::SCHEMA, $value);
    }

    /**
     * Returns value of 'schema' property
     *
     * @return \Start2004\Riak\Api\Pb\Message\RpbYokozunaSchema
     */
    public function getSchema()
    {
        return $this->get(self::SCHEMA);
    }
}
}