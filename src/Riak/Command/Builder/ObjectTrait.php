<?php

/*
Copyright 2014 Basho Technologies, Inc.

Licensed to the Apache Software Foundation (ASF) under one or more contributor license agreements.  See the NOTICE file
distributed with this work for additional information regarding copyright ownership.  The ASF licenses this file
to you under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance
with the License.  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an
"AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  See the License for the
specific language governing permissions and limitations under the License.
*/

namespace Basho\Riak\Command\Builder;

use Basho\Riak\Object;

/**
 * Class ObjectTrait
 *
 * Allows easy code sharing for Object getters / setters
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
trait ObjectTrait
{
    /**
     * @var \Basho\Riak\Object|null
     */
    protected $object = NULL;

    public function getObject()
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
    public function addObject($data = NULL, $headers = NULL)
    {
        $this->object = new Object($data, $headers);

        return $this;
    }

    /**
     * Attach an already instantiated Object to the Command
     *
     * @param \Basho\Riak\Object $object
     *
     * @return $this
     */
    public function withObject(Object $object)
    {
        $this->object = $object;

        return $this;
    }
}