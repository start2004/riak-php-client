<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak;
use Start2004\Riak\Command;

/**
 * Riak real time stats
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class FetchStats extends Command\Builder implements Command\BuilderInterface
{
    public function __construct(Riak $riak)
    {
        parent::__construct($riak);
    }

    /**
     * {@inheritdoc}
     *
     * @return Command\Stats;
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\Stats($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
    }
}
