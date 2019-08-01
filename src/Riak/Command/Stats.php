<?php

namespace OpenAdapter\Riak\Command;

use OpenAdapter\Riak\Command;
use OpenAdapter\Riak\CommandInterface;

/**
 * Riak real time stats
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Stats extends Command implements CommandInterface
{
    public function __construct(Command\Builder\FetchStats $builder)
    {
        parent::__construct($builder);
    }

    public function getData()
    {
        return '';
    }

    public function getEncodedData()
    {
        return '';
    }
}
