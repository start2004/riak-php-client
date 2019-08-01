<?php

namespace OpenAdapter\Riak\Command\Builder\Search;

use OpenAdapter\Riak\Command;

/**
 * Used to increment counter objects in Riak by the provided positive / negative integer
 *
 * <code>
 * $command = (new Command\Builder\StoreObject($riak))
 *   ->buildObject('{"firstName":"John","lastName":"Doe","email":"johndoe@gmail.com"}')
 *   ->buildBucket('users')
 *   ->build();
 *
 * $response = $command->execute();
 *
 * $user_location = $response->getLocation();
 * </code>
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class AssociateIndex extends Command\Builder\SetBucketProperties
{
    /**
     * @param $name
     *
     * @return $this
     */
    public function withName($name)
    {
        $this->set('search_index', $name);

        return $this;
    }
}
