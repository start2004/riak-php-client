<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak\Bucket;
use Start2004\Riak\Location;

/**
 * Allows easy code sharing for Location getters / setters within the Command Builders
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
trait LocationTrait
{
    // location depends on bucket
    use BucketTrait;

    /**
     * @var Location|null
     */
    protected $location = null;

    /**
     * @return Location|null
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param $key
     * @param $name
     * @param string $type
     *
     * @return $this
     */
    public function buildLocation($key, $name, $type = 'default')
    {
        $this->bucket = new Bucket($name, $type);
        $this->location = new Location($key, $this->bucket);

        return $this;
    }

    /**
     * @param Location $location
     *
     * @return $this
     */
    public function atLocation(Location $location)
    {
        $this->bucket = $location->getBucket();
        $this->location = $location;

        return $this;
    }
}
