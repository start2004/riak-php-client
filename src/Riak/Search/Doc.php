<?php

namespace Start2004\Riak\Search;

use Start2004\Riak\Bucket;
use Start2004\Riak\Location;

/**
 * Data structure for document objects returned from Solr
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Doc
{
    protected $data = null;

    protected $yzId = '';
    protected $yzRk = '';
    protected $yzRt = '';
    protected $yzRb = '';

    public function __construct(\stdClass $data)
    {
        if (isset($data->yzId)) {
            $this->yzId = $data->yzId;
            unset($data->yzId);
        }

        if (isset($data->yzRk)) {
            $this->yzRk = $data->yzRk;
            unset($data->yzRk);
        }

        if (isset($data->yzRt)) {
            $this->yzRt = $data->yzRt;
            unset($data->yzRt);
        }

        if (isset($data->yzRb)) {
            $this->yzRb = $data->yzRb;
            unset($data->yzRb);
        }

        $this->data = $data;
    }

    /**
     * Returns object location
     *
     * @return Location
     */
    public function getLocation()
    {
        return new Location($this->yzRk, new Bucket($this->yzRb, $this->yzRt));
    }

    public function __set($name, $value)
    {
        $this->data->{$name} = $value;
    }

    public function _Isset($name)
    {
        if (isset($this->data->{$name})) {
            return true;
        }

        return false;
    }

    /**
     * Returns a single value from Solr result document
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data->{$name};
    }

    /**
     * Returns all values as array from Solr result document
     *
     * @return array
     */
    public function getData()
    {
        return (array)$this->data;
    }
}
