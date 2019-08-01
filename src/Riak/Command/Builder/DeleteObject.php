<?php

namespace OpenAdapter\Riak\Command\Builder;

use OpenAdapter\Riak\Command;

/**
 * Used to delete a KV object from Riak
 *
 * <code>
 * $command = (new Command\Builder\DeleteObject($riak))
 * ->buildLocation('username', 'users')
 * ->build();
 *
 * $response = $command->execute();
 * </code>
 *
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class DeleteObject extends Command\Builder implements Command\BuilderInterface
{
    use ObjectTrait;
    use LocationTrait;

    /**
     * {@inheritdoc}
     *
     * @return Command\DataObject\Delete;
     * @throws Exception
     */
    public function build()
    {
        $this->validate();

        return new Command\DataObject\Delete($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Location');
    }
}
