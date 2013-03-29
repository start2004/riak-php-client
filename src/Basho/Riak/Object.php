<?php
/**
 * Riak PHP Client
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License, Version 2.0 that is
 * bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to <marco.debo.debortoli@gmail.com> so we can send you a copy immediately.
 *
 * @category   Riak
 * @package    Object
 * @copyright  Copyright (c) 2012 debo <marco.debo.debortoli@gmail.com> (https://github.com/MarcoDeBortoli)
 */
namespace Basho\Riak;

use Basho\Riak\Exception,
    Basho\Riak\Link,
    Basho\Riak\MapReduce,
    Basho\Riak\Utils;

/**
 * Object
 *
 * @category   Riak
 * @package    Object
 * @author     debo <marco.debo.debortoli@gmail.com> (https://github.com/MarcoDeBortoli)
 */
class Object
{
    protected $meta = array();
    protected $indexes = array();
    protected $autoIndexes = array();

    /**
     * Construct a new Object.
     * @param Client $client - A Client object.
     * @param Bucket $bucket - A Bucket object.
     * @param string $key - An optional key. If not specified, then key
     * is generated by server when store(...) is called.
     */
    public function __construct($client, $bucket, $key = NULL)
    {
        $this->client = $client;
        $this->bucket = $bucket;
        $this->key = $key;
        $this->jsonize = TRUE;
        $this->headers = array();
        $this->links = array();
        $this->siblings = NULL;
        $this->exists = FALSE;
    }

    /**
     * Get the bucket of this object.
     * @return Bucket
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Get the key of this object.
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the data stored in this object. Will return a associative
     * array, unless the object was constructed with newBinary(...) or
     * getBinary(...), in which case this will return a string.
     * @return array or string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the data stored in this object. This data will be
     * JSON encoded unless the object was constructed with
     * newBinary(...) or getBinary(...).
     * @param mixed $data - The data to store.
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get the HTTP status from the last operation on this object.
     * @return integer
     */
    public function status()
    {
        return $this->headers['http_code'];
    }

    /**
     * Return true if the object exists, false otherwise. Allows you to
     * detect a get(...) or getBinary(...) operation where the object is missing.
     * @return boolean
     */
    public function exists()
    {
        return $this->exists;
    }

    /**
     * Get the content type of this object. This is either application/json, or
     * the provided content type if the object was created via newBinary(...).
     * @return string
     */
    public function getContentType()
    {
        return $this->headers['content-type'];
    }

    /**
     * Set the content type of this object.
     * @param  string $content_type - The new content type.
     * @return $this
     */
    public function setContentType($content_type)
    {
        $this->headers['content-type'] = $content_type;
        return $this;
    }

    /**
     * Get last-modified from the object.
     * @return DateTime
     */
    public function getLastModified()
    {
        if (array_key_exists('last-modified', $this->headers)) {
            return new DateTime($this->headers['last-modified']);
        } else {
            return NULL;
        }
    }


    /**
     * Add a link to a Object.
     * @param mixed $obj - Either a Object or a Link object.
     * @param string $tag - Optional link tag. (default is bucket name,
     * ignored if $obj is a Link object.)
     * @return Object
     */
    public function addLink($obj, $tag = NULL)
    {
        if ($obj instanceof Link)
            $newlink = $obj;
        else
            $newlink = new Link($obj->bucket->name, $obj->key, $tag);

        $this->removeLink($newlink);
        $this->links[] = $newlink;

        return $this;
    }

    /**
     * Remove a link to a Object.
     * @param mixed $obj - Either a Object or a Link object.
     * @param string $tag -
     * @param mixed $obj - Either a Object or a Link object.
     * @param string $tag - Optional link tag. (default is bucket name,
     * ignored if $obj is a Link object.)
     * @return $this
     */
    public function removeLink($obj, $tag = NULL)
    {
        if ($obj instanceof Link)
            $oldlink = $obj;
        else
            $oldlink = new Link($obj->bucket->name, $obj->key, $tag);

        $a = array();
        foreach ($this->links as $link) {
            if (!$link->isEqual($oldlink))
                $a[] = $link;
        }

        $this->links = $a;
        return $this;
    }

    /**
     * Return an array of Link objects.
     * @return array()
     */
    public function getLinks()
    {
        # Set the clients before returning...
        foreach ($this->links as $link) {
            $link->client = $this->client;
        }
        return $this->links;
    }

    /** @section Indexes */

    /**
     * Adds a secondary index to the object
     * This will create the index if it does not exist, or will
     * append an additional value if the index already exists and
     * does not contain the provided value.
     * @param string $indexName
     * @param string $indexType - Must be one of 'int' or 'bin' - the
     * only two index types supported by Riak
     * @param string|int optional $explicitValue - If provided, uses this
     * value explicitly.  If not provided, this will search the object's
     * data for a field with the name $indexName, and use that value.
     * @return $this
     */
    public function addIndex($indexName, $indexType = null, $explicitValue = null)
    {
        if ($explicitValue === null) {
            $this->addAutoIndex($indexName, $indexType);
            return;
        }

        if ($indexType !== null) {
            $index = strtolower("{$indexName}_{$indexType}");
        } else {
            $index = strtolower($indexName);
        }
        if (!isset($this->indexes[$index])) $this->indexes[$index] = array();

        if (false === array_search($explicitValue, $this->indexes[$index])) {
            $this->indexes[$index][] = $explicitValue;
        }
        return $this;
    }

    /**
     * Sets a given index to a specific value or set of values
     * @param string $indexName
     * @param string $indexType - must be 'bin' or 'int'
     * @param array|string|int $values
     * @return $this
     */
    public function setIndex($indexName, $indexType = null, $values)
    {
        if ($indexType !== null) {
            $index = strtolower("{$indexName}_{$indexType}");
        } else {
            $index = strtolower($indexName);
        }

        $this->indexes[$index] = $values;

        return $this;
    }

    /**
     * Gets the current values for the identified index
     * Note, the NULL value has special meaning - when the object is
     * ->store()d, this value will be replaced with the current value
     * the value of the field matching $indexName from the object's data
     * @param string $indexName
     * @param string $indexType
     */
    public function getIndex($indexName, $indexType = null)
    {
        if ($indexType !== null) {
            $index = strtolower("{$indexName}_{$indexType}");
        } else {
            $index = strtolower($indexName);
        }
        if (!isset($this->indexes[$index])) return array();

        return $this->indexes[$index];
    }

    /**
     * Removes a specific value from a given index
     * @param string $indexName
     * @param string $indexType - must be 'bin' or 'int'
     * @param string|int optional $explicitValue
     * @return $this
     */
    public function removeIndex($indexName, $indexType = null, $explicitValue = null)
    {
        if ($explicitValue === null) {
            $this->removeAutoIndex($indexName, $indexType);
            return;
        }
        if ($indexType !== null) {
            $index = strtolower("{$indexName}_{$indexType}");
        } else {
            $index = strtolower($indexName);
        }

        if (!isset($this->indexes[$index])) return;

        if (false !== ($position = array_search($explicitValue, $this->indexes[$index]))) {
            unset($this->indexes[$index][$position]);
        }

        return $this;
    }

    /**
     * Bulk index removal
     * If $indexName and $indexType are provided, all values for the
     * identified index are removed.
     * If just $indexName is provided, all values for all types of
     * the identified index are removed
     * If neither is provided, all indexes are removed from the object
     *
     * Note that this function will NOT affect auto indexes
     *
     * @param string optional $indexName
     * @param string optional $indexType
     *
     * @return $this
     */
    public function removeAllIndexes($indexName = null, $indexType = null)
    {
        if ($indexName === null) {
            $this->indexes = array();
        } else if ($indexType === null) {
            $indexName = strtolower($indexName);
            unset($this->indexes["{$indexName}_int"]);
            unset($this->indexes["{$indexName}_bin"]);
        } else {
            unset($this->indexes[strtolower("{$indexName}_{$indexType}")]);
        }

        return $this;
    }

    /** @section Auto Indexes */

    /**
     * Adds an automatic secondary index to the object
     * The value of an automatic secondary index is determined at
     * time of ->store() by looking for an $fieldName key
     * in the object's data.
     *
     * @param string $fieldName
     * @param string $indexType Must be one of 'int' or 'bin'
     *
     * @return $this
     */
    public function addAutoIndex($fieldName, $indexType = null)
    {
        if ($indexType !== null) {
            $index = strtolower("{$fieldName}_{$indexType}");
        } else {
            $index = strtolower($fieldName);
        }
        $this->autoIndexes[$index] = $fieldName;

        return $this;
    }

    /**
     * Returns whether the object has a given auto index
     * @param string $fieldName
     * @param string $indexType - must be one of 'int' or 'bin'
     *
     * @return boolean
     */
    public function hasAutoIndex($fieldName, $indexType = null)
    {
        if ($indexType !== null) {
            $index = strtolower("{$fieldName}_{$indexType}");
        } else {
            $index = strtolower($fieldName);
        }
        return isset($this->autoIndexes[$index]);
    }

    /**
     * Removes a given auto index from the object
     *
     * @param string $fieldName
     * @param string $indexType
     *
     * @return $this
     */
    public function removeAutoIndex($fieldName, $indexType = null)
    {
        if ($indexType !== null) {
            $index = strtolower("{$fieldName}_{$indexType}");
        } else {
            $index = strtolower($fieldName);
        }
        unset($this->autoIndexes[$index]);
        return $this;
    }

    /**
     * Removes all auto indexes
     * If $fieldName is not provided, all auto indexes on the
     * object are stripped, otherwise just indexes on the given field
     * are stripped.
     * If $indexType is not provided, all types of index for the
     * given field are stripped, otherwise just a given type is stripped.
     *
     * @param string $fieldName
     * @param string $indexType
     *
     * @return $this
     */
    public function removeAllAutoIndexes($fieldName = null, $indexType = null)
    {
        if ($fieldName === null) {
            $this->autoIndexes = array();
        } else if ($indexType === null) {
            $fieldName = strtolower($fieldName);
            unset($this->autoIndexes["{$fieldName}_bin"]);
            unset($this->autoIndexes["{$fieldName}_int"]);
        } else {
            unset($this->autoIndexes[strtolower("{$fieldName}_{$indexType}")]);
        }
        return $this;
    }

    /** @section Meta Data */

    /**
     * Gets a given metadata value
     * Returns null if no metadata value with the given name exists
     *
     * @param string $metaName
     *
     * @return string|null
     */
    public function getMeta($metaName)
    {
        $metaName = strtolower($metaName);
        if (isset($this->meta[$metaName])) return $this->meta[$metaName];
        return null;
    }

    /**
     * Sets a given metadata value, overwriting an existing
     * value with the same name if it exists.
     * @param string $metaName
     * @param string $value
     * @return $this
     */
    public function setMeta($metaName, $value)
    {
        $this->meta[strtolower($metaName)] = $value;
        return $this;
    }

    /**
     * Removes a given metadata value
     * @param string $metaName
     * @return $this
     */
    public function removeMeta($metaName)
    {
        unset ($this->meta[strtolower($metaName)]);
        return $this;
    }

    /**
     * Gets all metadata values
     * @return array<string>=string
     */
    public function getAllMeta()
    {
        return $this->meta;
    }

    /**
     * Strips all metadata values
     * @return $this;
     */
    public function removeAllMeta()
    {
        $this->meta = array();
        return $this;
    }

    /**
     * Store the object in Riak. When this operation completes, the
     * object could contain new metadata and possibly new data if Riak
     * contains a newer version of the object according to the object's
     * vector clock.
     * @param integer $w - W-value, wait for this many partitions to respond
     * before returning to client.
     * @param integer $dw - DW-value, wait for this many partitions to
     * confirm the write before returning to client.
     * @return $this
     */
    public function store($w = NULL, $dw = NULL)
    {
        # Use defaults if not specified...
        $w = $this->bucket->getW($w);
        $dw = $this->bucket->getDW($w);

        # Construct the URL...
        $params = array('returnbody' => 'true', 'w' => $w, 'dw' => $dw);
        $url = Utils::buildRestPath($this->client, $this->bucket, $this->key, NULL, $params);

        # Construct the headers...
        $headers = array('Accept: text/plain, */*; q=0.5',
            'Content-Type: ' . $this->getContentType(),
            'X-Riak-ClientId: ' . $this->client->getClientID());

        # Add the vclock if it exists...
        if ($this->vclock() != NULL) {
            $headers[] = 'X-Riak-Vclock: ' . $this->vclock();
        }

        # Add the Links...
        foreach ($this->links as $link) {
            $headers[] = 'Link: ' . $link->toLinkHeader($this->client);
        }

        # Add the auto indexes...
        $collisions = array();
        if (!empty($this->autoIndexes) && !is_array($this->data)) {
            throw new Exception('Unsupported data type for auto indexing feature.  Object must be an array to use auto indexes.');
        }
        foreach ($this->autoIndexes as $index => $fieldName) {
            $value = null;
            // look up the value
            if (isset($this->data[$fieldName])) {
                $value = $this->data[$fieldName];
                $headers[] = "x-riak-index-$index: " . urlencode($value);

                // look for value collisions with normal indexes
                if (isset($this->indexes[$index])) {
                    if (false !== array_search($value, $this->indexes[$index])) {
                        $collisions[$index] = $value;
                    }
                }
            }
        }
        count($this->autoIndexes) > 0
            ? $this->meta['x-rc-autoindex'] = json_encode($this->autoIndexes)
            : $this->meta['x-rc-autoindex'] = null;
        count($collisions) > 0
            ? $this->meta['x-rc-autoindexcollision'] = json_encode($collisions)
            : $this->meta['x-rc-autoindexcollision'] = null;

        # Add the indexes
        foreach ($this->indexes as $index => $values) {
            $headers[] = "x-riak-index-$index: " . join(', ', array_map('urlencode', $values));
        }


        # Add the metadata...
        foreach ($this->meta as $metaName => $metaValue) {
            if ($metaValue !== null) $headers[] = "X-Riak-Meta-$metaName: $metaValue";
        }

        if ($this->jsonize) {
            $content = json_encode($this->getData());
        } else {
            $content = $this->getData();
        }

        $method = $this->key ? 'PUT' : 'POST';

        # Run the operation.
        $response = Utils::httpRequest($method, $url, $headers, $content);
        $this->populate($response, array(200, 201, 300));
        return $this;
    }

    /**
     * Reload the object from Riak. When this operation completes, the
     * object could contain new metadata and a new value, if the object
     * was updated in Riak since it was last retrieved.
     * @param integer $r - R-Value, wait for this many partitions to respond
     * before returning to client.
     * @return $this
     */
    public function reload($r = NULL)
    {
        # Do the request...
        $r = $this->bucket->getR($r);
        $params = array('r' => $r);
        $url = Utils::buildRestPath($this->client, $this->bucket, $this->key, NULL, $params);
        $response = Utils::httpRequest('GET', $url);
        $this->populate($response, array(200, 300, 404));

        # If there are siblings, load the data for the first one by default...
        if ($this->hasSiblings()) {
            $obj = $this->getSibling(0);
            $this->setData($obj->getData());
        }

        return $this;
    }

    /**
     * Delete this object from Riak.
     * @param  integer $dw - DW-value. Wait until this many partitions have
     * deleted the object before responding.
     * @return $this
     */
    public function delete($dw = NULL)
    {
        # Use defaults if not specified...
        $dw = $this->bucket->getDW($dw);

        # Construct the URL...
        $params = array('dw' => $dw);
        $url = Utils::buildRestPath($this->client, $this->bucket, $this->key, NULL, $params);

        # Run the operation...
        $response = Utils::httpRequest('DELETE', $url);
        $this->populate($response, array(204, 404));

        return $this;
    }


    /**
     * Reset this object.
     * @return $this
     */
    private function clear()
    {
        $this->headers = array();
        $this->links = array();
        $this->data = NULL;
        $this->exists = FALSE;
        $this->siblings = NULL;
        $this->indexes = array();
        $this->autoIndexes = array();
        $this->meta = array();
        return $this;
    }

    /**
     * Get the vclock of this object.
     * @return string
     */
    private function vclock()
    {
        if (array_key_exists('x-riak-vclock', $this->headers)) {
            return $this->headers['x-riak-vclock'];
        } else {
            return NULL;
        }
    }

    /**
     * Given the output of Utils::httpRequest and a list of
     * statuses, populate the object. Only for use by the Riak client
     * library.
     * @return $this
     */
    public function populate($response, $expected_statuses)
    {
        $this->clear();

        # If no response given, then return.
        if ($response == NULL) {
            return $this;
        }

        # Update the object...
        $this->headers = $response[0];
        $this->data = $response[1];
        $status = $this->status();

        # Check if the server is down (status==0)
        if ($status == 0) {
            $m = 'Could not contact Riak Server: http://' . $this->client->host . ':' . $this->client->port . '!';
            throw new Exception($m);
        }

        # Verify that we got one of the expected statuses. Otherwise, throw an exception.
        if (!in_array($status, $expected_statuses)) {
            $m = 'Expected status ' . implode(' or ', $expected_statuses) . ', received ' . $status . ' with body: ' . $this->data;
            throw new Exception($m);
        }

        # If 404 (Not Found), then clear the object.
        if ($status == 404) {
            $this->clear();
            return $this;
        }

        # If we are here, then the object exists...
        $this->exists = TRUE;

        # Parse the link header...
        if (array_key_exists("link", $this->headers)) {
            $this->populateLinks($this->headers["link"]);
        }

        # Parse the index and metadata headers
        $this->indexes = array();
        $this->autoIndexes = array();
        $this->meta = array();
        foreach ($this->headers as $key => $val) {
            if (preg_match('~^x-riak-([^-]+)-(.+)$~', $key, $matches)) {
                switch ($matches[1]) {
                    case 'index':
                        $index = substr($matches[2], 0, strrpos($matches[2], '_'));
                        $type = substr($matches[2], strlen($index) + 1);
                        $this->setIndex($index, $type, array_map('urldecode', explode(', ', $val)));
                        break;
                    case 'meta':
                        $this->meta[$matches[2]] = $val;
                        break;
                }
            }
        }

        # If 300 (Siblings), then load the first sibling, and
        # store the rest.
        if ($status == 300) {
            $siblings = explode("\n", trim($this->data));
            array_shift($siblings); # Get rid of 'Siblings:' string.
            $this->siblings = $siblings;
            $this->exists = TRUE;
            return $this;
        }

        if ($status == 201) {
            $path_parts = explode('/', $this->headers['location']);
            $this->key = array_pop($path_parts);
        }

        # Possibly json_decode...
        if (($status == 200 || $status == 201) && $this->jsonize) {
            $this->data = json_decode($this->data, true);
        }

        # Look for auto indexes and deindex explicit values if appropriate
        if (isset($this->meta['x-rc-autoindex'])) {
            # dereference the autoindexes
            $this->autoIndexes = json_decode($this->meta['x-rc-autoindex'], true);
            $collisions = isset($this->meta['x-rc-autoindexcollision']) ? json_decode($this->meta['x-rc-autoindexcollision'], true) : array();

            foreach ($this->autoIndexes as $index => $fieldName) {
                $value = null;
                if (isset($this->data[$fieldName])) {
                    $value = $this->data[$fieldName];
                    if (isset($collisions[$index]) && $collisions[$index] === $value) {
                        // Don't strip this value, it's an explicit index.
                    } else {
                        if ($value !== null) $this->removeIndex($index, null, $value);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Private.
     * @return $this
     */
    private function populateLinks($linkHeaders)
    {
        $linkHeaders = explode(",", trim($linkHeaders));
        foreach ($linkHeaders as $linkHeader) {
            $linkHeader = trim($linkHeader);
            $matches = array();
            $result = preg_match("/\<\/([^\/]+)\/([^\/]+)\/([^\/]+)\>; ?riaktag=\"([^\"]+)\"/", $linkHeader, $matches);
            if ($result == 1) {
                $this->links[] = new Link(urldecode($matches[2]), urldecode($matches[3]), urldecode($matches[4]));
            }
        }

        return $this;
    }

    /**
     * Return true if this object has siblings.
     * @return boolean
     */
    public function hasSiblings()
    {
        return ($this->getSiblingCount() > 0);
    }

    /**
     * Get the number of siblings that this object contains.
     * @return integer
     */
    public function getSiblingCount()
    {
        return count($this->siblings);
    }

    /**
     * Retrieve a sibling by sibling number.
     * @param  integer $i - Sibling number.
     * @param  integer $r - R-Value. Wait until this many partitions
     * have responded before returning to client.
     * @return Object.
     */
    public function getSibling($i, $r = NULL)
    {
        # Use defaults if not specified.
        $r = $this->bucket->getR($r);

        # Run the request...
        $vtag = $this->siblings[$i];
        $params = array('r' => $r, 'vtag' => $vtag);
        $url = Utils::buildRestPath($this->client, $this->bucket, $this->key, NULL, $params);
        $response = Utils::httpRequest('GET', $url);

        # Respond with a new object...
        $obj = new Object($this->client, $this->bucket, $this->key);
        $obj->jsonize = $this->jsonize;
        $obj->populate($response, array(200));
        return $obj;
    }

    /**
     * Retrieve an array of siblings.
     * @param integer $r - R-Value. Wait until this many partitions have
     * responded before returning to client.
     * @return array of Object
     */
    public function getSiblings($r = NULL)
    {
        $a = array();
        for ($i = 0; $i < $this->getSiblingCount(); $i++) {
            $a[] = $this->getSibling($i, $r);
        }
        return $a;
    }

    /**
     * Start assembling a Map/Reduce operation.
     * @see MapReduce::add()
     * @return MapReduce
     */
    public function add($params)
    {
        $mr = new MapReduce($this->client);
        $mr->add($this->bucket->name, $this->key);
        $args = func_get_args();
        return call_user_func_array(array(&$mr, "add"), $args);
    }

    /**
     * Start assembling a Map/Reduce operation.
     * @see MapReduce::link()
     * @return MapReduce
     */
    public function link($params)
    {
        $mr = new MapReduce($this->client);
        $mr->add($this->bucket->name, $this->key);
        $args = func_get_args();
        return call_user_func_array(array(&$mr, "link"), $args);
    }

    /**
     * Start assembling a Map/Reduce operation.
     * @see MapReduce::map()
     * @return MapReduce
     */
    public function map($params)
    {
        $mr = new MapReduce($this->client);
        $mr->add($this->bucket->name, $this->key);
        $args = func_get_args();
        return call_user_func_array(array(&$mr, "map"), $args);
    }

    /**
     * Start assembling a Map/Reduce operation.
     * @see MapReduce::reduce()
     * @return MapReduce
     */
    public function reduce($params)
    {
        $mr = new MapReduce($this->client);
        $mr->add($this->bucket->name, $this->key);
        $args = func_get_args();
        return call_user_func_array(array(&$mr, "reduce"), $args);
    }
}