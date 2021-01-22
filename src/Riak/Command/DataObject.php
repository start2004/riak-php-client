<?php

namespace Start2004\Riak\Command;

use Start2004\Riak\Command;
use Start2004\Riak\Location;

/**
 * Base class for Commands performing operations on Kv Objects
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
abstract class DataObject extends Command
{
    /**
     * @var DataObject\Response|null
     */
    protected $response = null;

    /**
     * @var \Start2004\Riak\DataObject|null
     */
    protected $object = null;

    /**
     * @var Location|null
     */
    protected $location = null;

    protected $decodeAsAssociative = false;

    public function getObject()
    {
        return $this->object;
    }

    public function getDataObject()
    {
        return $this->object;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getEncodedData()
    {
        /**
         * @since 2021-01-21 编码后保存, 返回406 Not Acceptable
         */
        return $this->getData();

        $data = $this->getData();

        if (\in_array($this->object->getContentType(), ['application/json', 'text/json'])) {
            return json_encode($data);
        }

        if (\in_array($this->object->getContentEncoding(), ['binary', 'none'])) {
            return $data;
        }

        if ('base64' === $this->object->getContentEncoding()) {
            return base64_encode($data);
        }

        return rawurlencode($data);
    }

    public function getData()
    {
        return $this->object->getData();
    }

    public function getDecodedData($data, $contentType)
    {
        return static::decodeData($data, $contentType, $this->decodeAsAssociative);
    }

    public static function decodeData($data, $contentType = '', $decodeAsAssociative = false)
    {
        if (\in_array($contentType, ['application/json', 'text/json'])) {
            return json_decode($data, $decodeAsAssociative);
        }

        return rawurldecode($data);
    }

    /**
     * @return Command\DataObject\Response
     */
    public function execute()
    {
        return parent::execute();
    }
}
