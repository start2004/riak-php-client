<?php

namespace Start2004\Riak\DataType;

use Start2004\Riak\DataType;

/**
 * Class Hll
 *
 * Data structure for HyperLogLog CRDT
 *
 * @author Luke Bakken <lbakken@basho.com>
 */
class Hll extends DataType
{
    /**
     * {@inheritdoc}
     */
    const TYPE = 'hll';

    /**
     * @param integer $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return integer
     */
    public function getData()
    {
        return $this->data;
    }
}
