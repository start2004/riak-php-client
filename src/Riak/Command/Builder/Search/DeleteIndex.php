<?php

namespace OpenAdapter\Riak\Command\Builder\Search;

use OpenAdapter\Riak;
use OpenAdapter\Riak\Command;

/**
 * @author Christopher Mancini <cmancini at basho d0t com>
 */
class DeleteIndex extends Command\Builder implements Command\BuilderInterface
{
    /**
     * Name of index to create
     *
     * @var string
     */
    protected $name = '';

    public function __construct(Riak $riak)
    {
        parent::__construct($riak);
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function withName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     *
     * @return Command\Search\Index\Delete
     * @throws Command\Builder\Exception
     */
    public function build()
    {
        try {
            $this->validate();
        } catch (Command\Builder\Exception $e) {
        }

        return new Command\Search\Index\Delete($this);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $this->required('Name');
    }
}
