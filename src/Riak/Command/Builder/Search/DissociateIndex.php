<?php

namespace OpenAdapter\Riak\Command\Builder\Search;

use OpenAdapter\Riak;
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
class DissociateIndex extends Command\Builder\SetBucketProperties
{
    public function __construct(Riak $riak)
    {
        parent::__construct($riak);

        $this->set('search_index', '_dont_index_');
    }
}
