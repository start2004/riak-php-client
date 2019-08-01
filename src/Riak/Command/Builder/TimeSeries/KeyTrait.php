<?php

namespace OpenAdapter\Riak\Command\Builder\TimeSeries;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
trait KeyTrait
{
    /**
     * Stores the key
     *
     * @var \OpenAdapter\Riak\TimeSeries\Cell[]
     */
    protected $key = [];

    /**
     * Gets the key
     *
     * @return \OpenAdapter\Riak\TimeSeries\Cell[]
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Attach the provided key to the Command Builder
     *
     * @param \OpenAdapter\Riak\TimeSeries\Cell[] $key
     *
     * @return $this
     */
    public function atKey(array $key)
    {
        $this->key = $key;

        return $this;
    }
}
