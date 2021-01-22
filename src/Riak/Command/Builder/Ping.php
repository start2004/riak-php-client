<?php

namespace Start2004\Riak\Command\Builder;

use Start2004\Riak;
use Start2004\Riak\Command;

/**
 * Used to fetch KV objects from Riak
 *
 * <code>
 * $command = (new Command\Builder\FetchObject($riak))
 *   ->buildLocation($user_id, 'users', 'default')
 *   ->build();
 *
 * $response = $command->execute();
 *
 * $user = $response->getDataObject();
 * </code>
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class Ping extends Command\Builder implements Command\BuilderInterface
{
    public function __construct(Riak $riak)
    {
        parent::__construct($riak);
    }

    /**
     * {@inheritdoc}
     *
     * @return Command\Ping;
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\Ping($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
    }
}
