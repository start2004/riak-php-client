<?php

namespace Start2004\Riak\Command\Builder\TimeSeries;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
trait KeyTrait
{
    /**
     * Stores the key
     *
     * @var \Start2004\Riak\TimeSeries\Cell[]
     */
    protected $key = [];

    /**
     * Gets the key
     *
     * @return \Start2004\Riak\TimeSeries\Cell[]
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Attach the provided key to the Command Builder
     *
     * @param \Start2004\Riak\TimeSeries\Cell[] $key
     *
     * @return $this
     */
    public function atKey(array $key)
    {
        $this->key = $key;

        return $this;
    }
}
