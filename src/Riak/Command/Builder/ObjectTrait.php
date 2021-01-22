<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak\Api\Http;
use Start2004\Riak\DataObject;

/**
 * Allows easy code sharing for Object getters / setters within the Command Builders
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
trait ObjectTrait
{
    /**
     * @var \Start2004\Riak\DataObject|null
     */
    protected $object = null;

    /**
     * @return Object|null
     */
    public function getDataObject()
    {
        return $this->object;
    }

    /**
     * Mint a new Object instance with supplied params and attach it to the Command
     *
     * @param string $data
     * @param array $headers
     *
     * @return $this
     */
    public function buildObject($data = null, $headers = null)
    {
        $this->object = new DataObject($data, $headers);

        return $this;
    }

    /**
     * Attach an already instantiated Object to the Command
     *
     * @param \Start2004\Riak\DataObject $object
     *
     * @return $this
     */
    public function withObject(DataObject $object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Mint a new Object instance with a json encoded string
     *
     * @param mixed $data
     *
     * @return $this
     */
    public function buildJsonObject($data)
    {
        $this->object = new DataObject();
        $this->object->setData($data);
        $this->object->setContentType(Http::CONTENT_TYPE_JSON);

        return $this;
    }
}
